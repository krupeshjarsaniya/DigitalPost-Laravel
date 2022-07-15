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
            ->editColumn('order_number', function($row) {
                $order = "<div class='row'>";
                $order .= "<div class='col-9'>";
                $order .= "<input class='form-control' type='text' id='order_".$row->id."' value='".$row->order_number."' />";
                $order .= "</div>";
                $order .= "<div class='col-3'>";
                $order .= "<button onclick='updateOrder(this)' data-id='".$row->id."' class='btn btn-sm btn-primary' >Update</button>";
                $order .= "</div>";
                $order .= "</div>";
                return $order;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deletePoliticalLogo(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image', 'order_number'])
            ->make(true);
        }
    }

    public function add(Request $request) {

        $validator = Validator::make($request->all(), [
                'image' => 'required',
            ],
            [
                'image.required' => 'Name Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        foreach ($request->file('image') as $key => $image) {
            $path = $this->multipleUploadFile($image,'Political-logo');
            $graphic = new PoliticalLogo();
            $graphic->image = $path;
            $graphic->save();
        }
        return response()->json(['status' => 1,'data' => "", 'message' => 'Political Logo added' ]);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $logo = PoliticalLogo::find($id);
        if($logo) {
            $logo->delete();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Political Logo Deleted' ]);
    }

    public function updateOrder(Request $request) {
        $id = $request->id;
        $logo = PoliticalLogo::find($id);
        if($logo) {
            $logo->order_number = $request->order;
            $logo->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Order updated' ]);
    }
}
