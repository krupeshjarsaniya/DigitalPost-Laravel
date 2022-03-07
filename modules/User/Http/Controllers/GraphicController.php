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
use App\GraphicCategory;
use App\Graphic;

class GraphicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::graphic');
    }

    public function getGraphicCategory(Request $request)
    {
        $categories = GraphicCategory::where('is_delete', 0);

        if ($request->ajax())
        {
            # code...
            return DataTables::of($categories)
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="getGraphics(this)"><i class="fa fa-eye"></i></button><br />';
                $btn .= '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editGraphicCategory(this)"><i class="flaticon-pencil"></i></button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteGraphicCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function addGraphicCategory(Request $request) {
        $validator = Validator::make($request->all(), [
                'name' => 'required',
            ],
            [
                'name.required' => 'Name Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = GraphicCategory::where('name', $request->name)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new GraphicCategory();
        $category->name = $request->name;
        if(!empty($request->order_number)) {
            $category->order_number = $request->order_number;
        }
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category created' ]);
    }

    public function deleteGraphicCategory(Request $request) {
        $id = $request->id;
        $category = GraphicCategory::find($id);
        if($category) {
            $category->is_delete = 1;
            $category->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Category Deleted' ]);
    }

    public function editGraphicCategory(Request $request) {
        $id = $request->id;
        $category = GraphicCategory::find($id);
        if(!$category) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Category not found' ]);
        }
        return response()->json(['status' => true,'data' => $category, 'message' => 'Category fetched successfully' ]);
    }

    public function updateGraphicCategory(Request $request) {
        $id = $request->edit_id;
        $validator = Validator::make($request->all(), [
                'edit_name' => 'required',
            ],
            [
                'edit_name.required' => 'Name Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkCategory = GraphicCategory::where('name', $request->edit_name)->where('id', '!=', $id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['edit_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = GraphicCategory::find($id);
        $category->name = $request->edit_name;
        if(!empty($request->edit_order_number)) {
            $category->order_number = $request->edit_order_number;
        }
        else {
            $category->order_number = null;
        }
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category updated' ]);
    }

    public function getGraphics(Request $request)
    {
        $graphics = Graphic::where('is_delete', 0)->where('graphic_id', $request->id);

        if ($request->ajax())
        {
            # code...
            return DataTables::of($graphics)
            ->editColumn('image',function($row) {
                if($row->image) {
                    $image = Storage::url($row->image);
                    return '<img src="'.$image.'" height="100" width="100">';
                }
                return "";
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deletegraphic(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function addGraphic(Request $request) {
        $validator = Validator::make($request->all(), [
                'files' => 'required',
            ],
            [
                'files.required' => 'Graphic Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        foreach ($request->file('files') as $key => $image) {
            $path = $this->multipleUploadFile($image,'Graphic');
            $thumbnail_image = $this->multipleUploadFileThumb($image,'Graphic-thumb',true,300,300);
            $graphic = new Graphic();
            $graphic->graphic_id = $request->graphic_id;
            $graphic->image = $path;
            $graphic->thumbnail_image = $thumbnail_image;
            $graphic->save();
        }

        return response()->json(['status' => 1,'data' => "", 'message' => 'Graphic added' ]);
    }

    public function deleteGraphic(Request $request) {
        $id = $request->id;
        $graphic = Graphic::find($id);
        if($graphic) {
            $graphic->is_delete = 1;
            $graphic->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Graphic Deleted' ]);
    }
}
