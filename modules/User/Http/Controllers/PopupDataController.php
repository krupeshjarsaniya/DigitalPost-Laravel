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

class PopupDataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::popup');
    }

    public function getPopup(Request $request)
    {
        $popups = Popup::where('is_delete', 0)->orderBy('start_date','ASC');
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($popups)
            ->editColumn('image',function($row) {
                $img = "";
                if($row->image != "") {
                    $img = '<img src="'.Storage::url($row->image).'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editPopup(this)"><i class="flaticon-pencil"></i></button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deletePopup(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function addPopup(Request $request) {
        $validator = Validator::make($request->all(), [
                'image' => 'required',      
                'user_type' => 'required',      
                'start_date' => 'required',      
                'end_date' => 'required',      
            ],
            [
                'image.required' => 'Image Is Required',
                'user_type.required' => 'User Type Is Required',
                'start_date.required' => 'Start Date Is Required',
                'end_date.required' => 'End Date Is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        $from = date($request->start_date);
        $to = date($request->end_date);
        $checkPopup = Popup::where('is_delete', 0)->where(function ($q) use ($from, $to){
            $q->whereBetween('start_date', [$from, $to])
            ->orWhereBetween('end_date', [$from, $to]);
        })->first();
        if($checkPopup) {
            return response()->json(['status' => 0,'message' => "Popup already available for this time!"]);
        }

        $image_name = $this->uploadFile($request, null, 'image', 'popup-image'); 
        $popup = new Popup();
        $popup->image = $image_name;
        $popup->user_type = $request->user_type;
        $popup->start_date = $request->start_date;
        $popup->end_date = $request->end_date;
        $popup->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Popup created' ]);
    }

    public function deletePopup(Request $request) {
        $popupId = $request->id;
        $popup = Popup::find($popupId);
        if($popup) {
            $popup->is_delete = 1;
            $popup->save();
        }
        return response()->json(['status' => true,'data' => "", 'message' => 'Popup Deleted' ]);
    }

    public function editPopup(Request $request) {
        $popupId = $request->id;
        $popup = Popup::find($popupId);
        if(!$popup) {
            return response()->json(['status' => false,'data' => "", 'message' => 'Popup not found' ]);
        }
        if($popup->image) {
            $popup->image = Storage::url($popup->image);
        }
        $popup->start_date = Carbon::parse($popup->start_date)->format('Y-m-d');
        $popup->end_date = Carbon::parse($popup->end_date)->format('Y-m-d');
        return response()->json(['status' => true,'data' => $popup, 'message' => 'Popup fetched successfully' ]);
    }

    public function updatePopup(Request $request) {
        $popupId = $request->edit_id;
        $validator = Validator::make($request->all(), [
                'edit_user_type' => 'required',      
                'edit_start_date' => 'required',      
                'edit_end_date' => 'required',      
            ],
            [
                'edit_user_type.required' => 'User Type Is Required',
                'edit_start_date.required' => 'Start Date Is Required',
                'edit_end_date.required' => 'End Date Is Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        $from = date($request->edit_start_date);
        $to = date($request->edit_end_date);
        $checkPopup = Popup::where('id', '!=', $popupId)->where('is_delete', 0)->where(function ($q) use ($from, $to){
            $q->whereBetween('start_date', [$from, $to])
            ->orWhereBetween('end_date', [$from, $to]);
        })->first();
        if($checkPopup) {
            return response()->json(['status' => 0,'message' => "Popup already available for this time!"]);
        }
        $popup = Popup::find($popupId);
        if($request->hasFile('edit_image')) {
            $image_name = $this->uploadFile($request, null, 'edit_image', 'popup-image'); 
            $popup->image = $image_name;
        }
        $popup->user_type = $request->edit_user_type;
        $popup->start_date = $request->edit_start_date;
        $popup->end_date = $request->edit_end_date;
        $popup->save();
        return response()->json(['status' => 1,'message' => "Popup updated!"]);
    }
}
