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
use App\StickerCategory;
use App\Sticker;

class StickerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::sticker');
    }

    public function getStickerCategory(Request $request)
    {
        $categories = StickerCategory::where('is_delete', 0);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($categories)
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="getStickers(this)"><i class="fa fa-eye"></i></button><br />';
                $btn .= '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editStickerCategory(this)"><i class="flaticon-pencil"></i></button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteStickerCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function addStickerCategory(Request $request) {
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

        $checkCategory = StickerCategory::where('name', $request->name)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new StickerCategory();
        $category->name = $request->name;
        if(!empty($request->order_number)) {
            $category->order_number = $request->order_number;
        }
        $category->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Category created' ]);
    }

    public function deleteStickerCategory(Request $request) {
        $id = $request->id;
        $category = StickerCategory::find($id);
        if($category) {
            $category->is_delete = 1;
            $category->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Category Deleted' ]);
    }

    public function editStickerCategory(Request $request) {
        $id = $request->id;
        $category = StickerCategory::find($id);
        if(!$category) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Category not found' ]);
        }
        return response()->json(['status' => true,'data' => $category, 'message' => 'Category fetched successfully' ]);
    }

    public function updateStickerCategory(Request $request) {
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

        $checkCategory = StickerCategory::where('name', $request->edit_name)->where('id', '!=', $id)->where('is_delete',0)->first();
        if($checkCategory) {
            $error=['edit_name' => 'Category already exists'];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = StickerCategory::find($id);
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

    public function getStickers(Request $request)
    {
        $stickers = Sticker::where('is_delete', 0)->where('category_id', $request->id);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($stickers)
            ->editColumn('image',function($row) {
                if($row->image) {
                    $image = Storage::url($row->image);
                    return '<img src="'.$image.'" height="100" width="100">';
                }
                return "";
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteSticker(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function addSticker(Request $request) {
        $validator = Validator::make($request->all(), [
                'files' => 'required',      
            ],
            [
                'files.required' => 'Sticker Is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        foreach ($request->file('files') as $key => $image) {
            $path = $this->multipleUploadFile($image,'sticker');
            $sticker = new Sticker();
            $sticker->category_id = $request->category_id;
            $sticker->image = $path;
            $sticker->save();
        }


        return response()->json(['status' => 1,'data' => "", 'message' => 'Sticker added' ]);
    }

    public function deleteSticker(Request $request) {
        $id = $request->id;
        $sticker = Sticker::find($id);
        if($sticker) {
            $sticker->is_delete = 1;
            $sticker->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Sticker Deleted' ]);
    }

}
