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
use App\Distributor;
use App\Purchase;
use App\Plan;
use App\DistributorBusinessUser;
use App\User;
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
        ->editColumn('busi_mobile', function($row) {
            $mobile = array();
            if(!empty($row->busi_mobile)) {
                array_push($mobile, $row->busi_mobile);
            }
            if(!empty($row->busi_mobile_second)) {
                array_push($mobile, $row->busi_mobile_second);
            }

            return implode("<br />", $mobile);
        })
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
            }
            return $is_premium;
        })
        ->addColumn('action', function($row) {
            $url = route('distributors.businessView', $row->busi_id);
            $button = "";
            $button .= '<a href="' . $url . '" class="btn btn-primary btn-sm mb-2">View</a>';
            return $button;
        })
        ->rawColumns([ 'busi_mobile' ,'busi_logo', 'watermark_image', 'busi_logo_dark', 'watermark_image_dark', 'is_premium', 'action'])
        ->make(true);
    }

    public function businessAdd(Request $request)
    {
        $busi_cats = DB::table('business_category')->where('is_delete',0)->get();

        return view('distributor.businessAdd', compact('busi_cats'));
    }

    public function businessInsert(Request $request)
    {
        $distributor = Auth::user()->distributor;

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

        $new_balance = $distributor->balance;
        $plan_rate = 0;
        $purc_plan_id = $request->purc_plan_id;
        if($purc_plan_id == 7) {
            $plan_rate = $distributor->start_up_plan_rate;
        }
        if($purc_plan_id == 8) {
            $plan_rate = $distributor->custom_plan_rate;
        }
        if($distributor->balance < $plan_rate) {
            return response()->json(['status' => false,'message' => "insufficient balance"]);
        }
        $new_balance -= $plan_rate;

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

        $plan = Plan::where('plan_id',$purc_plan_id)->first();
        $start_date = date('Y-m-d', time());
        $end_date = date('Y-m-d', strtotime($start_date . '+ ' . $plan->plan_validity . ' days'));

        $purchase = New Purchase;
        $purchase->purc_user_id = $user_id;
        $purchase->purc_business_id = $purc_business_id;
        $purchase->purc_plan_id = $purc_plan_id;
        $purchase->purc_start_date = $start_date;
        $purchase->purc_end_date = $end_date;
        $purchase->save();

        $distributorBalance = DistributorChannel::find($distributor->id);
        $distributorBalance->balance = $new_balance;
        $distributorBalance->save();

        $transaction = new DistributorTransaction;
        $transaction->distributor_id = $distributor->id;
        $transaction->amount = $plan_rate;
        $transaction->type = 'create_business';
        $transaction->description = 'Create Business : ' . $request->busi_name;
        $transaction->business_id = $purc_business_id;
        $transaction->business_type = 1;
        $transaction->save();

        $this->addPurchasePlanHistory($purc_business_id, 1, $start_date);
        return response()->json(['status' => true,'message' => "Business Insert successfully"]);
    }

    public function businessView($id) {
        $busi_cats = DB::table('business_category')->where('is_delete',0)->get();
        $business = Business::where('busi_id', $id)->where('user_id', Auth::user()->id)->where('busi_delete', 0)->first();
        if(empty($business)) {
            return redirect()->back()->with('message', 'Business Not Found');
        }
        return view('distributor.businessView', compact('busi_cats', 'business'));
    }

    public function businessUpdate(Request $request, $id)
    {

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



        $newBusiness = Business::where('busi_id',$id)->first();
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

        return response()->json(['status' => true,'message' => "Business Updated successfully"]);
    }

    public function businessUserList(Request $request) {
        $businesses = DistributorBusinessUser::with('user')
        ->where('business_id', $request->id)
        ->where('business_id', $request->id)
        ->where('business_type', 1);
        return DataTables::of($businesses)
        ->addIndexColumn()
        ->addColumn('action', function($row) {
            $button = "";
            $button .= '<button onclick="removeUserFromBusiness(this)" data-id="'.$row->user_id.'" class="btn btn-danger btn-sm">Delete</button>';
            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function businessUserAdd(Request $request) {
        $validator = Validator::make($request->all(), [
                'business_id' => 'required',
                'users' => 'required',
            ],
            [
                'business_id.required' => 'Business ID is required',
                'users.required' => 'Users number is required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $mobiles = explode(',', $request->users);
        $user_ids = array();
        foreach($mobiles as $mobile) {
            $user = User::where('mobile', trim($mobile))->first();
            if(!empty($user)) {
                if(!in_array($user->id, $user_ids)) {
                    array_push($user_ids, $user->id);
                }
            }
        }
        if(count($user_ids) == 0) {
            $error = ['users' => 'Invalid numbers'];
            return response()->json(['status' => 401,'error1' => $error]);
        }
        foreach($user_ids as $user_id) {
            $newBusinessUser = DistributorBusinessUser::where('business_id', $request->business_id)
            ->where('user_id', $user_id)
            ->where('business_type', 1)
            ->first();
            if(empty($newBusinessUser)) {
                $newBusinessUser = new DistributorBusinessUser;
            }
            $newBusinessUser->business_id = $request->business_id;
            $newBusinessUser->business_type = 1;
            $newBusinessUser->user_id = $user_id;
            $newBusinessUser->save();
        }

        return response()->json(['status' => true,'message' => "Users added successfully"]);
    }

    public function businessUserDelete(Request $request) {
        $user_id = $request->id;
        $business_id = $request->business_id;

        $newBusinessUser = DistributorBusinessUser::where('business_id', $business_id)
        ->where('user_id', $user_id)
        ->where('business_type', 1)
        ->first();
        if(!empty($newBusinessUser)) {
            $newBusinessUser->delete();
        }
        return response()->json(['status' => true,'message' => "Users removed successfully"]);
    }
}
