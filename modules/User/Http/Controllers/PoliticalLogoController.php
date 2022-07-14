<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Validator;
use App\PoliticalLogo;

class PoliticalLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::politicalLogo');
    }

    public function list(Request $request)
    {
        $logos = PoliticalLogo::where('id','!=', 0);

        if ($request->ajax())
        {
            # code...
            return DataTables::of($logos)
            ->editColumn('image',function($row) {
                if($row->image) {
                    $image = Storage::url($row->image);
                    return '<img src="'.$image.'" height="100" width="100">';
                }
                return "";
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deletePoliticalLogo(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function add(Request $request) {
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

    public function delete(Request $request) {
        $id = $request->id;
        $category = BackgroundCategory::find($id);
        if($category) {
            $category->is_delete = 1;
            $category->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Category Deleted' ]);
    }
}
