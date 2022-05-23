<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MusicCategory;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class MusicCategoryController extends Controller
{
    public function index() {
        return view('user::musicCategory');
    }

    public function getMusicCategory(Request $request) {
        $categories = MusicCategory::where('is_delete', 0);

        if ($request->ajax())
        {
            return DataTables::of($categories)
            ->editColumn('is_active',function($row) {
                if ($row->is_active == 1) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })
            ->addColumn('action',function($row) {
                $btn = "";
                $btn .= '<a class="btn btn-success btn-sm mr-2" data-id="'.$row->id.'" href="' . route('musicList', ['id' => $row->id]) . '"><i class="fa fa-eye" area-hidden="true"></i></a>';
                $btn .= '<button class="btn btn-primary btn-sm mr-2" data-id="'.$row->id.'" onclick="editMusicCategory(this)"><i class="flaticon-pencil" area-hidden="true"></i></button>';
                $btn .= '<button class="btn btn-danger btn-sm mr-2" data-id="'.$row->id.'" onclick="deleteMusicCategory(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'is_active'])
            ->make(true);
        }
    }

    public function addMusicCategory(Request $request) {
        $validator = Validator::make($request->all(), [
                'category' => 'required',
                'is_active' => 'required',
            ],
            [
                'category.required' => 'Name Is Required',
                'is_active.required' => 'Status is required',
            ]
        );

        if ($validator->fails()){
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = new MusicCategory;
        $category->name = $request->category;
        if(isset($request->order_number) && $request->order_number != '' && $request->order_number > 0) {
            $category->order_number = $request->order_number;
        }
        $category->is_active = $request->is_active;
        $category->save();

        return response()->json(['status' => true, 'message' => 'Music Category Added Successfully']);

    }

    public function getMusicCategoryById(Request $request) {
        $id = $request->id;
        $category = MusicCategory::where('id', $id)->where('is_delete', 0)->first();
        if(empty($category) || $category->is_delete) {
            return response()->json(['status' => false, 'message' => 'Music Category Not Found']);
        }
        return response()->json(['status' => true, 'data' => $category, 'message' => 'Music Category Found']);
    }

    public function updateMusicCategory(Request $request) {

        $rules = [
            'id' => 'required',
            'category' => 'required',
            'is_active' => 'required'
        ];
        $messages = [
            'id.required' => 'Category Not Found',
            'category.required' => 'Name Is Required',
            'is_active.required' => 'Status Is Required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $category = MusicCategory::where('id', $request->id)->where('is_delete', 0)->first();
        if(empty($category)) {
            return response()->json(['status' => false, 'message' => 'Music Category Not Found']);
            exit();
        }

        $category->name = $request->category;
        $category->is_active = $request->is_active;
        if(isset($request->order_number) && $request->order_number != '' && $request->order_number > 0) {
            $category->order_number = $request->order_number;
        }
        else {
            $category->order_number = null;
        }
        $category->save();

        return response()->json(['status' => true, 'message' => 'Music Category Updated']);

    }

    public function deleteMusicCategory(Request $request) {
        $id = $request->id;
        $musicCategory = MusicCategory::where('id', $id)->where('is_delete', 0)->first();
        if(empty($musicCategory)) {
            return response()->json(['status' => false, 'message' => 'Music Category not found']);
        }
        $musicCategory->is_delete = 1;
        $musicCategory->save();
        return response()->json(['status' => true,'message' => "Music Category deleted!"]);
    }
}
