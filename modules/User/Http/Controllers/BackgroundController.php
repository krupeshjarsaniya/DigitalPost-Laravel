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
use App\BackgroundCategory;
use App\Background;

class BackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::background');
    }

    public function getBackgroundCategory(Request $request)
    {
        $categories = BackgroundCategory::where('is_delete', 0);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($categories)
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="getBackgrounds(this)"><i class="fa fa-eye"></i></button><br />';
                $btn .= '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editBackgroundCategory(this)"><i class="flaticon-pencil"></i></button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteBackgroundCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function addBackgroundCategory(Request $request) {
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

        $checkCategory = BackgroundCategory::where('name', $request->name)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new BackgroundCategory();
        $category->name = $request->name;
        if(!empty($request->order_number)) {
            $category->order_number = $request->order_number;
        }
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category created' ]);
    }

    public function deleteBackgroundCategory(Request $request) {
        $id = $request->id;
        $category = BackgroundCategory::find($id);
        if($category) {
            $category->is_delete = 1;
            $category->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Category Deleted' ]);
    }

    public function editBackgroundCategory(Request $request) {
        $id = $request->id;
        $category = BackgroundCategory::find($id);
        if(!$category) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Category not found' ]);
        }
        return response()->json(['status' => true,'data' => $category, 'message' => 'Category fetched successfully' ]);
    }

    public function updateBackgroundCategory(Request $request) {
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

        $checkCategory = BackgroundCategory::where('name', $request->edit_name)->where('id', '!=', $id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['edit_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = BackgroundCategory::find($id);
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

    public function getBackgrounds(Request $request)
    {
        $backgrounds = Background::where('is_delete', 0)->where('category_id', $request->id);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($backgrounds)
            ->editColumn('image',function($row) {
                if($row->image) {
                    $image = Storage::url($row->image);
                    return '<img src="'.$image.'" height="100" width="100">';
                }
                return "";
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteBackground(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function addBackground(Request $request) {
        $validator = Validator::make($request->all(), [
                'files' => 'required',      
            ],
            [
                'files.required' => 'Background Is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        foreach ($request->file('files') as $key => $image) {
            $path = $this->multipleUploadFile($image,'Background');
            $thumbnail_image = $this->multipleUploadFileThumb($image,'Background-thumb',true,300,300);
            $sticker = new Background();
            $sticker->category_id = $request->category_id;
            $sticker->image = $path;
            $sticker->thumbnail_image = $thumbnail_image;
            $sticker->save();
        }

        return response()->json(['status' => 1,'data' => "", 'message' => 'Background added' ]);
    }

    public function deleteBackground(Request $request) {
        $id = $request->id;
        $background = Background::find($id);
        if($background) {
            $background->is_delete = 1;
            $background->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Background Deleted' ]);
    }
}
