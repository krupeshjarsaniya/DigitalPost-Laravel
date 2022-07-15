<?php

namespace App\Http\Controllers\Distributors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DataTables;
use Carbon\Carbon;
use App\DistributorChannel;
use App\DistributorTransaction;
use App\Business;
use App\Purchase;
use Illuminate\Support\Facades\Storage;
use DB;

class BusinessController extends Controller
{

    public function index()
    {
        return view('distributor.business');
    }

    public function businessList(Request $request) {
        $businesses = Business::where('user_id', Auth::user()->id)->where('is_distributor_business', 1);
        return DataTables::of($businesses)
        ->addIndexColumn()
        ->editColumn('busi_logo', function($row) {
            $image = "";
            if(!empty($row->busi_logo)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->busi_logo) ."' />";
            }
            return $image;
        })
        ->editColumn('watermark_image', function($row) {
            $image = "";
            if(!empty($row->watermark_image)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->watermark_image) ."' />";
            }
            return $image;
        })
        ->editColumn('busi_logo_dark', function($row) {
            $image = "";
            if(!empty($row->busi_logo_dark)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->busi_logo_dark) ."' />";
            }
            return $image;
        })
        ->editColumn('watermark_image_dark', function($row) {
            $image = "";
            if(!empty($row->watermark_image_dark)) {
                $image = "<img height='100' width='100' src='". Storage::url($row->watermark_image_dark) ."' />";
            }
            return $image;
        })
        ->editColumn('is_premium', function($row) {
            $is_premium = "<span class='badge badge-danger'>false</span>";

            $checkPurchase = Purchase::where('purc_business_type', 1)->where('purc_business_id', $row->busi_id)->where('purc_plan_id', '!=', 3)->first();
            if(!empty($checkPurchase)) {
                $is_premium = "<span class='badge badge-success'>true</span>";
                // $is_premium = true;
            }
            return $is_premium;
        })
        ->rawColumns(['busi_logo', 'watermark_image', 'busi_logo_dark', 'watermark_image_dark', 'is_premium'])
        ->make(true);
    }

    public function businessAdd(Request $request)
    {
        $busi_cats = DB::table('business_category')->where('is_delete',0)->get();
        
        return view('distributor.businessAdd', compact('busi_cats'));
    }
    
    public function businessInsert(Request $request)
    {

       
        $user_id  = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'busi_name' => 'required',
        ],
        [
            'busi_name' => 'Please Enter Name',
        ]
    );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $plan = $request->select_plan;

        

        $newBusiness = New Business;
        $newBusiness->user_id = $user_id;
        $newBusiness->is_distributor_business = 1;
        $newBusiness->busi_name = $request->busi_name;
        $newBusiness->busi_email = $request->busi_email;
        $newBusiness->busi_mobile = $request->busi_mobile;
        $newBusiness->busi_mobile_second = $request->busi_mobile_second;
        $newBusiness->busi_website = $request->busi_website;
        $newBusiness->busi_address = $request->busi_address;
        $newBusiness->hashtag = $request->hashtag;
        $newBusiness->busi_facebook = $request->busi_facebook;
        $newBusiness->busi_twitter = $request->busi_twitter;
        $newBusiness->busi_instagram = $request->busi_instagram;
        $newBusiness->busi_linkedin = $request->busi_linkedin;
        $newBusiness->busi_youtube = $request->busi_youtube;

        if($request->hasFile('busi_logo')) {
            $busi_logo = $this->uploadFile($request, null, 'busi_logo', 'business-img');
            $newBusiness->busi_logo = $busi_logo;
        }
        if($request->hasFile('busi_logo_dark')) {
            $busi_logo_dark = $this->uploadFile($request, null, 'busi_logo_dark', 'business-img');
            $newBusiness->busi_logo_dark = $busi_logo_dark;
        }
        if($request->hasFile('watermark_image')) {
            $watermark_image = $this->uploadFile($request, null, 'watermark_image', 'business-img');
            $newBusiness->watermark_image = $watermark_image;
        }
        if($request->hasFile('watermark_image_dark')) {
            $watermark_image_dark = $this->uploadFile($request, null, 'watermark_image_dark', 'business-img');
            $newBusiness->watermark_image_dark = $watermark_image_dark;
        }

        $newBusiness->business_category = $request->business_category;
        $newBusiness->save();

        $purc_business_id = $newBusiness->id;

        $purchase = New Purchase;
        $purchase->purc_user_id = $user_id;
        $purchase->purc_business_id = $purc_business_id;
        $purchase->purc_plan_id = 3;
        $purchase->purc_start_date = date('Y-m-d', time()) ;
        $purchase->save();

        return response()->json(['status' => true,'message' => "Business Insert successfully"]);
               
    }


}
