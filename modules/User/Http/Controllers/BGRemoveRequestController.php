<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BackgroundRemoveRequest;
use DataTables;

class BGRemoveRequestController extends Controller
{
    public function index(Request $request) {
        return view('user::bgRemoveRequest');
    }

    public function list(Request $request) {
        $bgRemoveRequest = BackgroundRemoveRequest::select('background_remove_request.*');
        return DataTables::of($bgRemoveRequest)
            ->editColumn('user_id', function($bgRemoveRequest) {
                return $bgRemoveRequest->user->name;
            })
            ->editColumn('business_type', function ($bgRemoveRequest) {
                return $bgRemoveRequest->business_type == 1 ? 'Normal Business' : 'Political Business';
            })
            ->editColumn('business_id', function ($bgRemoveRequest) {
                return $bgRemoveRequest->business_type == 1 ? $bgRemoveRequest->business->busi_name : $bgRemoveRequest->political_business->pb_name;
            })
            ->editColumn('mobile', function ($bgRemoveRequest) {
                $mobile = "";
                if($bgRemoveRequest->business_type == 1) {
                    $mobile .= $bgRemoveRequest->user->mobile;
                    $mobile .= "<br>" . $bgRemoveRequest->business->busi_mobile;
                    if(!empty($bgRemoveRequest->business->busi_mobile_second)) {
                        $mobile .= "<br>" . $bgRemoveRequest->business->busi_mobile_second;
                    }
                }
                else {
                    $mobile .= $bgRemoveRequest->user->mobile;
                    $mobile .= "<br>" . $bgRemoveRequest->political_business->pb_mobile;
                    if(!empty($bgRemoveRequest->political_business->pb_mobile_second)) {
                        $mobile .= "<br>" . $bgRemoveRequest->political_business->pb_mobile_second;
                    }
                }
                return $mobile;
            })
            ->editColumn('remove_logo', function ($bgRemoveRequest) {
                return $bgRemoveRequest->remove_logo == 1 ? 'Yes' : 'No';
            })
            ->editColumn('remove_watermark', function ($bgRemoveRequest) {
                return $bgRemoveRequest->remove_watermark == 1 ? 'Yes' : 'No';
            })
            ->editColumn('remove_left_image', function ($bgRemoveRequest) {
                return $bgRemoveRequest->remove_left_image == 1 ? 'Yes' : 'No';
            })
            ->editColumn('remove_right_image', function ($bgRemoveRequest) {
                return $bgRemoveRequest->remove_right_image == 1 ? 'Yes' : 'No';
            })
            ->addColumn('action', function ($bgRemoveRequest) {
                return '<button onclick="removeRequest(this)" class="btn btn-xs btn-primary btn-edit" data-id="'.$bgRemoveRequest->id.'">Delete</button>';
            })
            ->rawColumns(['action', 'mobile'])
            ->make(true);
    }

    public function remove(Request $request) {
        $id = $request->id;
        $checkRequest = BackgroundRemoveRequest::find($id);
        if(!empty($checkRequest)) {
            $checkRequest->delete();
        }

        return response()->json([
            'status' => true,
            'message' => "Request removed successfully"
        ]);
    }
}
