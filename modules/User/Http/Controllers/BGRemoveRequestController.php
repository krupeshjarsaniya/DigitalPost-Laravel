<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BackgroundRemoveRequest;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                if($bgRemoveRequest->remove_logo == 0) {
                    return "";
                }
                $image = "";
                if($bgRemoveRequest->business_type == 1) {
                    $image = Storage::url($bgRemoveRequest->business->busi_logo);
                }
                else {
                    $image = Storage::url($bgRemoveRequest->political_business->pb_party_logo);
                }
                $img = '<img src="'.$image.'" height="100" width="100">';
                return $img;
            })
            ->editColumn('remove_watermark', function ($bgRemoveRequest) {
                if($bgRemoveRequest->remove_watermark == 0) {
                    return "";
                }
                $image = "";
                if($bgRemoveRequest->business_type == 1) {
                    $image = Storage::url($bgRemoveRequest->business->watermark_image);
                }
                else {
                    $image = Storage::url($bgRemoveRequest->political_business->pb_watermark);
                }
                $img = '<img src="'.$image.'" height="100" width="100">';
                return $img;
            })
            ->editColumn('remove_logo_dark', function ($bgRemoveRequest) {
                if($bgRemoveRequest->remove_logo_dark == 0) {
                    return "";
                }
                $image = "";
                if($bgRemoveRequest->business_type == 1) {
                    $image = Storage::url($bgRemoveRequest->business->busi_logo_dark);
                }
                else {
                    $image = Storage::url($bgRemoveRequest->political_business->pb_party_logo_dark);
                }
                $img = '<img src="'.$image.'" height="100" width="100">';
                return $img;
            })
            ->editColumn('remove_watermark_dark', function ($bgRemoveRequest) {
                if($bgRemoveRequest->remove_watermark_dark == 0) {
                    return "";
                }
                $image = "";
                if($bgRemoveRequest->business_type == 1) {
                    $image = Storage::url($bgRemoveRequest->business->watermark_image_dark);
                }
                else {
                    $image = Storage::url($bgRemoveRequest->political_business->pb_watermark_dark);
                }
                $img = '<img src="'.$image.'" height="100" width="100">';
                return $img;
            })
            ->editColumn('remove_left_image', function ($bgRemoveRequest) {
                if($bgRemoveRequest->remove_left_image == 0) {
                    return "";
                }
                $image = "";
                $image = Storage::url($bgRemoveRequest->political_business->pb_left_image);
                $img = '<img src="'.$image.'" height="100" width="100">';
                return $img;
            })
            ->editColumn('remove_right_image', function ($bgRemoveRequest) {
                if($bgRemoveRequest->remove_right_image == 0) {
                    return "";
                }
                $image = "";
                $image = Storage::url($bgRemoveRequest->political_business->pb_right_image);
                $img = '<img src="'.$image.'" height="100" width="100">';
                return $img;
            })
            ->addColumn('action', function ($bgRemoveRequest) {
                $button = "";
                $button .= '<button onclick="editImages(this)" class="btn btn-xs btn-success btn-edit mb-2" data-id="'.$bgRemoveRequest->id.'">Edit</button>';
                $button .= '<button onclick="removeRequest(this)" class="btn btn-xs btn-primary btn-delet" data-id="'.$bgRemoveRequest->id.'">Delete</button>';
                return $button;
            })
            ->rawColumns(['action', 'mobile', 'remove_logo', 'remove_watermark', 'remove_logo_dark', 'remove_watermark_dark', 'remove_left_image', 'remove_right_image'])
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

    public function edit(Request $request) {
        $id = $request->id;
        $checkRequest = BackgroundRemoveRequest::where('id', $id)->with('business', 'politicalBusiness')->first();
        if(empty($checkRequest)) {
            return response()->json([
                'status' => false,
                'message' => "Request not found"
            ]);
        }
        $checkRequest->business->busi_logo = Storage::url($checkRequest->business->busi_logo);
        $checkRequest->business->watermark_image = Storage::url($checkRequest->business->watermark_image);
        $checkRequest->business->busi_logo_dark = Storage::url($checkRequest->business->busi_logo_dark);
        $checkRequest->business->watermark_image_dark = Storage::url($checkRequest->business->watermark_image_dark);
        return response()->json([
            'status' => true,
            'message' => "Date found",
            "data" => $checkRequest
        ]);

    }

    public function updateNormalBusiness(Request $request) {
        $id = $request->id;
        $updateData = [];
        if($request->hasFile('logo')) {
            $logo = $this->uploadFile($request, null, 'logo', 'business-img');
            $updateData['busi_logo'] = $logo;
        }
        if($request->hasFile('logodark')) {
            $logodark = $this->uploadFile($request, null, 'logodark', 'business-img');
            $updateData['busi_logo_dark'] = $logodark;
        }
        if($request->hasFile('watermark')) {
            $watermark = $this->uploadFile($request, null, 'watermark', 'business-img');
            $updateData['watermark_image'] = $watermark;
        }
        if($request->hasFile('watermarkdark')) {
            $watermarkdark = $this->uploadFile($request, null, 'watermarkdark', 'business-img');
            $updateData['watermark_image_dark'] = $watermarkdark;
        }

        if(!empty($updateData)) {
            DB::table('business')->where('busi_id', $id)->update($updateData);
        }

        return response()->json([
            'status' => true,
            'message' => "Data updated successfully"
        ]);
    }

    public function updatePoliticalBusiness(Request $request) {
        $id = $request->id;
        $updateData = [];
        if($request->hasFile('politicallogo')) {
            $politicallogo = $this->uploadFile($request, null, 'politicallogo', 'business-img');
            $updateData['pb_party_logo'] = $politicallogo;
        }
        if($request->hasFile('politicallogodark')) {
            $politicallogo = $this->uploadFile($request, null, 'politicallogo', 'business-img');
            $updateData['pb_party_logo_dark'] = $politicallogo;
        }
        if($request->hasFile('politicalwatermark')) {
            $politicalwatermark = $this->uploadFile($request, null, 'politicalwatermark', 'business-img');
            $updateData['pb_watermark'] = $politicalwatermark;
        }
        if($request->hasFile('politicalwatermarkdark')) {
            $politicalwatermarkdark = $this->uploadFile($request, null, 'politicalwatermarkdark', 'business-img');
            $updateData['pb_watermark_dark'] = $politicalwatermarkdark;
        }
        if($request->hasFile('politicalleftimage')) {
            $politicalleftimage = $this->uploadFile($request, null, 'politicalleftimage', 'business-img');
            $updateData['pb_left_image'] = $politicalleftimage;
        }
        if($request->hasFile('politicalrightimage')) {
            $politicalrightimage = $this->uploadFile($request, null, 'politicalrightimage', 'business-img');
            $updateData['pb_right_image'] = $politicalrightimage;
        }

        if(!empty($updateData)) {
            DB::table('business')->where('busi_id', $id)->update($updateData);
        }

        return response()->json([
            'status' => true,
            'message' => "Data updated successfully"
        ]);
    }
}
