<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DataTables;
use Validator;
use DB;
use App\User;
use App\Popup;
use App\Frame;
use App\FrameComponent;
use App\BusinessField;
use App\FrameText;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::frame');
    }

    public function getFrame(Request $request)
    {
        $frames = Frame::all();

        if ($request->ajax())
        {
            # code...
            return DataTables::of($frames)
            ->editColumn('frame_image',function($row) {
                $img = "";
                if($row->frame_image != "") {
                    $img = '<img src="'.Storage::url($row->frame_image).'" height="100" width="100">';
                }
                return $img;
            })
            ->editColumn('is_active',function($row) {
                if($row->is_active) {
                    return '<span class="badge badge-success">Active</span>';
                }
                return '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editFrame(this)">Edit</button><br />';
                $btn .= '<a href="' . route('addlayers', ['id' => $row->id]) . '" class="btn btn-success btn-sm mb-2 mt-2" onclick="AddLayers(this)">Add/Edit layers</a><br />';
                return $btn;
            })
            ->rawColumns(['action', 'frame_image', 'is_active'])
            ->make(true);
        }
    }

    public function addFrame(Request $request) {
        $validator = Validator::make($request->all(), [
                'frame_image' => 'required',
                'thumbnail_image' => 'required',
                'frame_type' => 'required',
            ],
            [
                'frame_image.required' => 'Image Is Required',
                'thumbnail_image.required' => 'Thumbnail Image Is Required',
                'frame_type.required' => 'Frame Type Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        $image_name = $this->uploadFile($request, null, 'frame_image', 'frame');
        $frame = new Frame();
        $frame->frame_image = $image_name;
        $thumb_image_name = $this->uploadFile($request, null, 'thumbnail_image', 'frame');
        $frame->thumbnail_image = $thumb_image_name;
        $frame->frame_type = $request->frame_type;
        $frame->is_active = 0;
        $frame->display_order = isset($request->display_order) ? $request->display_order : 999;
        $frame->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Popup created' ]);
    }

    public function editFrame(Request $request) {
        $frameId = $request->id;
        $frame = Frame::find($frameId);
        if(!$frame) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Frame not found' ]);
        }
        if($frame->frame_image) {
            $frame->frame_image = Storage::url($frame->frame_image);
        }
        if($frame->thumbnail_image) {
            $frame->thumbnail_image = Storage::url($frame->thumbnail_image);
        }
        return response()->json(['status' => true,'data' => $frame, 'message' => 'Frame fetched successfully' ]);
    }

    public function updateFrame(Request $request) {
        $frameId = $request->edit_id;
        $validator = Validator::make($request->all(), [
                'edit_id' => 'required',
                'edit_frame_type' => 'required',
                'edit_is_active' => 'required',
            ],
            [
                'edit_frame_type.required' => 'Start Date Is Required',
                'edit_is_active.required' => 'Status Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $frame = Frame::find($frameId);
        if($request->hasFile('edit_frame_image')) {
            $image_name = $this->uploadFile($request, null, 'edit_frame_image', 'frame');
            $frame->frame_image = $image_name;
        }
        if($request->hasFile('edit_thumbnail_image')) {
            $thumb_image_name = $this->uploadFile($request, null, 'edit_thumbnail_image', 'frame');
            $frame->thumbnail_image = $thumb_image_name;
        }
        $frame->frame_type = $request->edit_frame_type;
        $frame->is_active = $request->edit_is_active;
        $frame->display_order = isset($request->edit_display_order) ? $request->edit_display_order : 999;
        $frame->save();
        return response()->json(['status' => 1,'message' => "Frame updated!"]);
    }

    public function addlayers(Request $request, $id) {
        $frame = Frame::find($id);
        if(!$frame) {
            return redirect()->back()->with('error', 'Frame not found');
        }
        if($frame->frame_image) {
            $frame->frame_image = Storage::url($frame->frame_image);
        }

        if($frame->frame_type == "Business") {
            $image_fields = BusinessField::where('field_type', 'image')->where('field_for', 1)->get();
            $text_fields = BusinessField::where('field_type', 'text')->where('field_for', 1)->get();
        } else {
            $image_fields = BusinessField::where('field_type', 'image')->where('field_for', 2)->get();
            $text_fields = BusinessField::where('field_type', 'text')->where('field_for', 2)->get();
        }
        return view('user::addlayers', compact('frame', 'image_fields', 'text_fields'));
    }

    public function getComponents(Request $request, $id)
    {
        $frames = FrameComponent::where('frame_components.frame_id', $id)->with('field')->select('frame_components.*')->orderBy('frame_components.id','DESC');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($frames)
            ->editColumn('field.field_value',function($row) {
                if($row->image_for == 0) {
                    return "Other";
                }
                return $row->field->field_value;
            })
            ->editColumn('stkr_path',function($row) {
                $img = "";
                if($row->image_for == 0) {
                    $img = '<img src="'.Storage::url($row->stkr_path).'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-success btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editComponent(this)">Edit</button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="deleteComponent(this)">Delete</button><br />';
                return $btn;
            })
            ->rawColumns(['action', 'stkr_path'])
            ->make(true);
        }
    }

    public function addComponent(Request $request) {
        $validator = Validator::make($request->all(), [
                'frame_id' => 'required',
                'image_for' => 'required',
                'pos_x' => 'required',
                'pos_y' => 'required',
                'width' => 'required',
                'height' => 'required',
                'order_' => 'required',
                'field_three' => 'required',
            ],
            [
                'frame_id.required' => 'Frame Id Is Required',
                'image_for.required' => 'Image For Is Required',
                'pos_x.required' => 'Pos X Is Required',
                'pos_y.required' => 'Pos Y Is Required',
                'width.required' => 'Width Is Required',
                'height.required' => 'Height Is Required',
                'order_.required' => 'Order Is Required',
                'field_three.required' => 'Field Three Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        $stkr_path = "";
        if($request->image_for == 0) {
            $validator = Validator::make($request->all(), [
                'stkr_path' => 'required',
            ],
            [
                'stkr_path.required' => 'Image Is Required',
            ]
            );

            if ($validator->fails())
            {
                $error=json_decode($validator->errors());

                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }

            $stkr_path = $this->uploadFile($request, null, 'stkr_path', 'frame');
        }


        $frame = Frame::find($request->frame_id);
        if(!$frame) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Frame not found' ]);
        }
        $frameComponent = new FrameComponent();
        $frameComponent->frame_id = $request->frame_id;
        $frameComponent->type = "sticker";
        $frameComponent->pos_x = $request->pos_x;
        $frameComponent->pos_y = $request->pos_y;
        $frameComponent->width = $request->width;
        $frameComponent->height = $request->height;
        $frameComponent->order_ = $request->order_;
        $frameComponent->rotation = "0.0";
        $frameComponent->y_rotation = "0.0";
        $frameComponent->res_id = "0";
        $frameComponent->stkr_path = $stkr_path;
        $frameComponent->stc_color = "0";
        $frameComponent->stc_opacity = "100";
        $frameComponent->xrotateprog = "45";
        $frameComponent->yrotateprog = "45";
        $frameComponent->zrotateprog = "180";
        $frameComponent->scale_prog = "10";
        $frameComponent->stc_scale = "8";
        $frameComponent->colortype = "colored";
        $frameComponent->stc_hue = "106";
        $frameComponent->field_one = "0";
        $frameComponent->field_two = "";
        $frameComponent->field_three = $request->field_three;
        $frameComponent->field_four = "";
        $frameComponent->image_for = $request->image_for;


        $frameComponent->save();
        return response()->json(['status' => true,'data' => "", 'message' => 'Component added successfully' ]);
    }

    public function editComponent(Request $request) {
        $componentId = $request->id;
        $component = FrameComponent::find($componentId);
        if(!$component) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Component not found' ]);
        }
        if($component->image_for == 0) {
            $component->stkr_path = Storage::url($component->stkr_path);
        }
        return response()->json(['status' => true,'data' => $component, 'message' => 'Component fetched successfully' ]);
    }

    public function updateComponent(Request $request) {
        $componentId = $request->edit_id;
        $validator = Validator::make($request->all(), [
                'edit_id' => 'required',
                'edit_image_for' => 'required',
                'edit_pos_x' => 'required',
                'edit_pos_y' => 'required',
                'edit_width' => 'required',
                'edit_height' => 'required',
                'edit_order_' => 'required',
                'edit_field_three' => 'required',
            ],
            [
                'edit_id.required' => 'Component Id Is Required',
                'edit_image_for.required' => 'Image For Is Required',
                'edit_pos_x.required' => 'Pos X Is Required',
                'edit_pos_y.required' => 'Pos Y Is Required',
                'edit_width.required' => 'Width Is Required',
                'edit_height.required' => 'Height Is Required',
                'edit_order_.required' => 'Order Is Required',
                'edit_field_three.required' => 'Field Three Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $component = FrameComponent::find($componentId);
        if(!$component) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Component not found' ]);
        }

        if($request->edit_image_for == 0) {
            if(empty($component->stkr_path)) {
                $validator = Validator::make($request->all(), [
                    'edit_stkr_path' => 'required',
                ],
                [
                    'edit_stkr_path.required' => 'Image Is Required',
                ]
                );

                if ($validator->fails())
                {
                    $error=json_decode($validator->errors());

                    return response()->json(['status' => 401,'error1' => $error]);
                    exit();
                }
            }

            if($request->has('edit_stkr_path')) {
                $stkr_path = $this->uploadFile($request, null, 'edit_stkr_path', 'frame');
                $component->stkr_path = $stkr_path;
            }
        }


        $component->image_for = $request->edit_image_for;
        $component->pos_x = $request->edit_pos_x;
        $component->pos_y = $request->edit_pos_y;
        $component->width = $request->edit_width;
        $component->height = $request->edit_height;
        $component->order_ = $request->edit_order_;
        $component->field_three = $request->edit_field_three;
        $component->save();
        return response()->json(['status' => true,'data' => "", 'message' => 'Component updated successfully' ]);

    }

    public function deleteComponent(Request $request) {
        $componentId = $request->id;
        $component = FrameComponent::find($componentId);
        if(!$component) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Component not found' ]);
        }
        $component->delete();
        return response()->json(['status' => true,'message' => "Component deleted!"]);
    }

    public function getTexts(Request $request, $id)
    {
        $texts = FrameText::where('frame_texts.frame_id', $id)->with('field')->select('frame_texts.*')->orderBy('frame_texts.id','DESC');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($texts)
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-success btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editText(this)">Edit</button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="deleteText(this)">Delete</button><br />';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function addText(Request $request) {
        $validator = Validator::make($request->all(), [
                'frame_id' => 'required',
                'text_for' => 'required',
                'text_color' => 'required',
                'pos_x' => 'required',
                'pos_y' => 'required',
                'width' => 'required',
                'height' => 'required',
                'order_' => 'required',
                'field_four' => 'required',
                'field_three' => 'required',
                'font_name' => 'required',
            ],
            [
                'frame_id.required' => 'Frame Id Is Required',
                'text_for.required' => 'Text For Is Required',
                'text_color.required' => 'Text For Is Required',
                'pos_x.required' => 'Pos X Is Required',
                'pos_y.required' => 'Pos Y Is Required',
                'width.required' => 'Width Is Required',
                'height.required' => 'Height Is Required',
                'order_.required' => 'Order Is Required',
                'field_four.required' => 'Field Three Is Required',
                'field_three.required' => 'Text Alignment Is Required',
                'font_name.required' => 'Font Name Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $frameText = new FrameText();
        $frameText->frame_id = $request->frame_id;
        $frameText->type = 'text';
        $frameText->font_name = $request->font_name;
        $frameText->text_color = !empty($request->text_color) ? $request->text_color : '-16777216';
        $frameText->text = "";
        $frameText->text_alpha = "100";
        $frameText->shadow_color = "-16777216";
        $frameText->shadow_prog = "0";
        $frameText->bg_drawable = "0";
        $frameText->bg_color = "0";
        $frameText->bg_alpha = "0";
        $frameText->pos_x = $request->pos_x;
        $frameText->pos_y = $request->pos_y;
        $frameText->width = $request->width;
        $frameText->height = $request->height;
        $frameText->rotation = "0.0";
        $frameText->order_ = $request->order_;
        $frameText->xrotateprog = "45";
        $frameText->yrotateprog = "45";
        $frameText->zrotateprog = "180";
        $frameText->curveprog = "0";
        $frameText->field_one = "15";
        $frameText->field_two = "";
        $frameText->field_three = $request->field_three;
        $frameText->field_four = $request->field_four;
        $frameText->text_for = $request->text_for;
        $frameText->save();
        return response()->json(['status' => true,'data' => "", 'message' => 'Text added successfully' ]);

    }

    public function editText(Request $request) {
        $textId = $request->id;
        $text = FrameText::find($textId);
        if(!$text) {
            return response()->json(['status' => false,'data' => "", 'message' => 'text not found' ]);
        }
        return response()->json(['status' => true,'data' => $text, 'message' => 'text fetched successfully' ]);
    }

    public function updateText(Request $request) {
        $validator = Validator::make($request->all(), [
                'edit_text_id' => 'required',
                'edit_text_for' => 'required',
                'edit_text_color' => 'required',
                'edit_pos_x' => 'required',
                'edit_pos_y' => 'required',
                'edit_width' => 'required',
                'edit_height' => 'required',
                'edit_order_' => 'required',
                'edit_field_four' => 'required',
                'edit_field_three' => 'required',
                'edit_font_name' => 'required',
            ],
            [
                'edit_text_id.required' => 'Edit Id Is Required',
                'edit_text_for.required' => 'Text For Is Required',
                'edit_text_color.required' => 'Text For Is Required',
                'edit_pos_x.required' => 'Pos X Is Required',
                'edit_pos_y.required' => 'Pos Y Is Required',
                'edit_width.required' => 'Width Is Required',
                'edit_height.required' => 'Height Is Required',
                'edit_order_.required' => 'Order Is Required',
                'edit_field_four.required' => 'Field Three Is Required',
                'edit_field_three.required' => 'Text Alignment Is Required',
                'edit_font_name.required' => 'Font Name Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $textId = $request->edit_text_id;
        $text = FrameText::find($textId);
        if(!$text) {
            return response()->json(['status' => false,'data' => "", 'message' => 'text not found' ]);
        }
        $text->text_color = !empty($request->edit_text_color) ? $request->edit_text_color : '-16777216';
        $text->pos_x = $request->edit_pos_x;
        $text->pos_y = $request->edit_pos_y;
        $text->width = $request->edit_width;
        $text->height = $request->edit_height;
        $text->order_ = $request->edit_order_;
        $text->field_four = $request->edit_field_four;
        $text->field_three = $request->edit_field_three;
        $text->text_for = $request->edit_text_for;
        $text->font_name = $request->edit_font_name;
        $text->text_for = $request->edit_text_for;
        $text->save();
        return response()->json(['status' => true,'data' => "", 'message' => 'Text updated successfully' ]);

    }

    public function deleteText(Request $request) {
        $textId = $request->id;
        $text = FrameText::find($textId);
        if(!$text) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Text not found' ]);
        }
        $text->delete();
        return response()->json(['status' => true,'message' => "Text deleted!"]);
    }
}
