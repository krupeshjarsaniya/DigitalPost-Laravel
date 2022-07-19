<?php

namespace App\Http\Controllers\Distributors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DataTables;
use App\DistributorChannel;
use App\DistributorTransaction;
use App\PoliticalBusiness;
use App\Purchase;
use App\Plan;
use App\DistributorBusinessUser;
use App\DistributorBusinessFrame;
use App\User;
use App\PoliticalBusinessApprovalList;
use Illuminate\Support\Facades\Storage;
use DB;

class PoliticalBusinessController extends Controller
{

    public function index()
    {
        return view('distributor.politicalBusiness');
    }

    public function politicalBusinessList(Request $request)
    {
        $businesses = PoliticalBusiness::where('user_id', Auth::user()->id)->where('is_distributor_business', 1)->with('category');
        return DataTables::of($businesses)
            ->addIndexColumn()
            ->editColumn('pb_mobile', function ($row) {
                $mobile = array();
                if (!empty($row->pb_mobile)) {
                    array_push($mobile, $row->pb_mobile);
                }
                if (!empty($row->pb_mobile_second)) {
                    array_push($mobile, $row->pb_mobile_second);
                }

                return implode("<br />", $mobile);
            })
            ->editColumn('pb_party_logo', function ($row) {
                $image = "";
                if (!empty($row->pb_party_logo)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_party_logo) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_watermark', function ($row) {
                $image = "";
                if (!empty($row->pb_watermark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_watermark) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_party_logo_dark', function ($row) {
                $image = "";
                if (!empty($row->pb_party_logo_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_party_logo_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_watermark_dark', function ($row) {
                $image = "";
                if (!empty($row->pb_watermark_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_watermark_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_left_image', function ($row) {
                $image = "";
                if (!empty($row->pb_left_image)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_left_image) . "' />";
                }
                return $image;
            })
            ->editColumn('pb_right_image', function ($row) {
                $image = "";
                if (!empty($row->pb_right_image)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->pb_right_image) . "' />";
                }
                return $image;
            })
            ->editColumn('is_premium', function ($row) {
                $is_premium = "<span class='badge badge-danger'>false</span>";

                $checkPurchase = Purchase::where('purc_business_type', 2)->where('purc_business_id', $row->pb_id)->where('purc_plan_id', '!=', 3)->first();
                if (!empty($checkPurchase)) {
                    $plan = Plan::where('plan_id', $checkPurchase->purc_plan_id)->first();
                    $is_premium = "<span class='badge badge-success'>true</span><br />";
                    $is_premium .= "<span >Plan: ".$plan->plan_or_name."</span><br />";
                    $is_premium .= "<span >Active Date: ".$checkPurchase->purc_start_date."</span><br />";
                    $is_premium .= "<span >Expiry Date: ".$checkPurchase->purc_end_date."</span><br />";
                }
                return $is_premium;
            })
            ->addColumn('action', function ($row) {
                $url = route('distributors.politicalBusinessView', $row->pb_id);
                $button = "";
                $button .= '<a href="' . $url . '" class="btn btn-primary btn-sm mb-2">View</a>';
                return $button;
            })
            ->rawColumns(['pb_mobile', 'pb_party_logo', 'pb_watermark', 'pb_party_logo_dark', 'pb_watermark_dark', 'pb_left_image', 'pb_right_image', 'is_premium', 'action'])
            ->make(true);
    }

    public function politicalBusinessAdd(Request $request)
    {
        $busi_cats = DB::table('political_category')->where('pc_is_deleted', 0)->get();

        return view('distributor.politicalBusinessAdd', compact('busi_cats'));
    }

    public function politicalBusinessInsert(Request $request)
    {
        $distributor = Auth::user()->distributor;

        $user_id  = auth()->user()->id;
        $validator = Validator::make(
            $request->all(),
            [
                'pb_name' => 'required',
            ],
            [
                'pb_name' => 'Please Enter Name',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $new_balance = $distributor->balance;
        $plan_rate = 0;
        $purc_plan_id = $request->purc_plan_id;
        if ($purc_plan_id == Plan::$start_up_plan_id) {
            $plan_rate = $distributor->start_up_plan_rate;
        }
        if ($purc_plan_id == Plan::$custom_plan_id) {
            $plan_rate = $distributor->custom_plan_rate;
        }
        if ($distributor->balance < $plan_rate) {
            return response()->json(['status' => false, 'message' => "insufficient balance"]);
        }
        $new_balance -= $plan_rate;

        $newBusiness = new PoliticalBusiness();
        $newBusiness->user_id = $user_id;
        $newBusiness->is_distributor_business = 1;
        $newBusiness->pb_name = $request->pb_name;
        $newBusiness->pb_designation = $request->pb_designation;
        $newBusiness->pb_mobile = $request->pb_mobile;
        $newBusiness->pb_mobile_second = $request->pb_mobile_second;
        $newBusiness->pb_pc_id = $request->pb_pc_id;
        $newBusiness->hashtag = $request->hashtag;
        $newBusiness->pb_facebook = $request->pb_facebook;
        $newBusiness->pb_twitter = $request->pb_twitter;
        $newBusiness->pb_instagram = $request->pb_instagram;
        $newBusiness->pb_linkedin = $request->pb_linkedin;
        $newBusiness->pb_youtube = $request->pb_youtube;

        if ($request->hasFile('pb_party_logo')) {
            $pb_party_logo = $this->uploadFile($request, null, 'pb_party_logo', 'political-business-img');
            $newBusiness->pb_party_logo = $pb_party_logo;
        }
        if ($request->hasFile('pb_watermark')) {
            $pb_watermark = $this->uploadFile($request, null, 'pb_watermark', 'political-business-img');
            $newBusiness->pb_watermark = $pb_watermark;
        }
        if ($request->hasFile('pb_party_logo_dark')) {
            $pb_party_logo_dark = $this->uploadFile($request, null, 'pb_party_logo_dark', 'political-business-img');
            $newBusiness->pb_party_logo_dark = $pb_party_logo_dark;
        }
        if ($request->hasFile('pb_watermark_dark')) {
            $pb_watermark_dark = $this->uploadFile($request, null, 'pb_watermark_dark', 'political-business-img');
            $newBusiness->pb_watermark_dark = $pb_watermark_dark;
        }
        if ($request->hasFile('pb_left_image')) {
            $pb_left_image = $this->uploadFile($request, null, 'pb_left_image', 'political-business-img');
            $newBusiness->pb_left_image = $pb_left_image;
        }
        if ($request->hasFile('pb_right_image')) {
            $pb_right_image = $this->uploadFile($request, null, 'pb_right_image', 'political-business-img');
            $newBusiness->pb_right_image = $pb_right_image;
        }

        $newBusiness->save();

        $purc_business_id = $newBusiness->pb_id;

        $plan = Plan::where('plan_id', $purc_plan_id)->first();
        $start_date = date('Y-m-d', time());
        $end_date = date('Y-m-d', strtotime($start_date . '+ ' . $plan->plan_validity . ' days'));

        $purchase = new Purchase;
        $purchase->purc_user_id = $user_id;
        $purchase->purc_business_id = $purc_business_id;
        $purchase->purc_business_type = 2;
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
        $transaction->description = 'Create Business : ' . $request->pb_name;
        $transaction->business_id = $purc_business_id;
        $transaction->business_type = 2;
        $transaction->save();

        $this->addPurchasePlanHistory($purc_business_id, 2, $start_date);
        return response()->json(['status' => true, 'message' => "Business Insert successfully"]);
    }

    public function politicalBusinessView($id)
    {
        $busi_cats = DB::table('political_category')->where('pc_is_deleted', 0)->get();
        $business = PoliticalBusiness::where('pb_id', $id)->where('user_id', Auth::user()->id)->where('pb_is_deleted', 0)->first();
        if (empty($business)) {
            return redirect()->back()->with('message', 'Business Not Found');
        }
        return view('distributor.politicalBusinessView', compact('busi_cats', 'business'));
    }

    public function politicalBusinessUpdate(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'pb_name' => 'required',
            ],
            [
                'pb_name' => 'Please Enter Name',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $newBusiness = PoliticalBusiness::where('pb_id', $id)->first();
        // $newBusiness->pb_name = $request->pb_name;
        $newBusiness->pb_designation = $request->pb_designation;
        $newBusiness->pb_mobile = $request->pb_mobile;
        $newBusiness->pb_mobile_second = $request->pb_mobile_second;
        $newBusiness->pb_pc_id = $request->pb_pc_id;
        $newBusiness->hashtag = $request->hashtag;
        $newBusiness->pb_facebook = $request->pb_facebook;
        $newBusiness->pb_twitter = $request->pb_twitter;
        $newBusiness->pb_instagram = $request->pb_instagram;
        $newBusiness->pb_linkedin = $request->pb_linkedin;
        $newBusiness->pb_youtube = $request->pb_youtube;

        if ($request->hasFile('pb_party_logo')) {
            $pb_party_logo = $this->uploadFile($request, null, 'pb_party_logo', 'political-business-img');
            $newBusiness->pb_party_logo = $pb_party_logo;
        }
        if ($request->hasFile('pb_watermark')) {
            $pb_watermark = $this->uploadFile($request, null, 'pb_watermark', 'political-business-img');
            $newBusiness->pb_watermark = $pb_watermark;
        }
        if ($request->hasFile('pb_party_logo_dark')) {
            $pb_party_logo_dark = $this->uploadFile($request, null, 'pb_party_logo_dark', 'political-business-img');
            $newBusiness->pb_party_logo_dark = $pb_party_logo_dark;
        }
        if ($request->hasFile('pb_watermark_dark')) {
            $pb_watermark_dark = $this->uploadFile($request, null, 'pb_watermark_dark', 'political-business-img');
            $newBusiness->pb_watermark_dark = $pb_watermark_dark;
        }
        if ($request->hasFile('pb_left_image')) {
            $pb_left_image = $this->uploadFile($request, null, 'pb_left_image', 'political-business-img');
            $newBusiness->pb_left_image = $pb_left_image;
        }
        if ($request->hasFile('pb_right_image')) {
            $pb_right_image = $this->uploadFile($request, null, 'pb_right_image', 'political-business-img');
            $newBusiness->pb_right_image = $pb_right_image;
        }

        $message = "Business Updated successfully";

        if ($newBusiness->pb_name != $request->pb_name) {
            PoliticalBusinessApprovalList::updateOrCreate(
                ['pb_id' => $newBusiness->pb_id],
                [
                    'pbal_name' => $request->pb_name,
                    'user_id' => Auth::user()->id,
                    'pbal_pc_id' => $request->pb_pc_id
                ]
            );
            $message = "Business Updated Request Sent To Admin successfully";
        }

        $newBusiness->save();
        return response()->json(['status' => true, 'message' => $message]);
    }

    public function politicalBusinessUserList(Request $request)
    {
        $businesses = DistributorBusinessUser::with('user')
            ->where('business_id', $request->id)
            ->where('business_id', $request->id)
            ->where('business_type', 2);
        return DataTables::of($businesses)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $button = "";
                $button .= '<button onclick="removeUserFromBusiness(this)" data-id="' . $row->user_id . '" class="btn btn-danger btn-sm">Delete</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function politicalBusinessUserAdd(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_id' => 'required',
                'users' => 'required',
            ],
            [
                'business_id.required' => 'Business ID is required',
                'users.required' => 'Users number is required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $mobiles = explode(',', $request->users);
        $user_ids = array();
        foreach ($mobiles as $mobile) {
            $user = User::where('mobile', trim($mobile))->first();
            if (!empty($user)) {
                if (!in_array($user->id, $user_ids)) {
                    array_push($user_ids, $user->id);
                }
            }
        }
        if (count($user_ids) == 0) {
            $error = ['users' => 'Invalid numbers'];
            return response()->json(['status' => 401, 'error1' => $error]);
        }
        foreach ($user_ids as $user_id) {
            $newBusinessUser = DistributorBusinessUser::where('business_id', $request->business_id)
                ->where('user_id', $user_id)
                ->where('business_type', 2)
                ->first();
            if (empty($newBusinessUser)) {
                $newBusinessUser = new DistributorBusinessUser;
            }
            $newBusinessUser->business_id = $request->business_id;
            $newBusinessUser->business_type = 2;
            $newBusinessUser->user_id = $user_id;
            $newBusinessUser->save();
        }

        return response()->json(['status' => true, 'message' => "Users added successfully"]);
    }

    public function politicalBusinessUserDelete(Request $request)
    {
        $user_id = $request->id;
        $business_id = $request->business_id;

        $newBusinessUser = DistributorBusinessUser::where('business_id', $business_id)
            ->where('user_id', $user_id)
            ->where('business_type', 2)
            ->first();
        if (!empty($newBusinessUser)) {
            $newBusinessUser->delete();
        }
        return response()->json(['status' => true, 'message' => "Users removed successfully"]);
    }

    public function politicalBusinessFrameList(Request $request)
    {
        $frames = DB::table('user_frames')
            ->where('business_id', $request->id)
            ->where('business_type', 2)
            ->whereNotNull('frame_url')
            ->where('frame_url', '!=', '')
            ->where('is_deleted', 0);
        return DataTables::of($frames)
            ->addIndexColumn()
            ->addColumn('frame_url', function ($row) {
                $image = "";
                if (!empty($row->frame_url)) {
                    $image = "<img width='150px' height='150px' src='" . Storage::url($row->frame_url) . "' />";
                }
                return $image;
            })
            ->rawColumns(['frame_url'])
            ->make(true);
    }

    public function politicalBusinessFrameAdd(Request $request)
    {

        if (!Auth::user()->distributor->allow_add_frames) {
            return response()->json(['status' => false, 'message' => "You are not allowed to add frames"]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'business_id' => 'required',
                'frames' => 'required',
            ],
            [
                'business_id.required' => 'Business ID is required',
                'frames.required' => 'frame is required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        foreach ($request->file('frames') as $key => $image) {
            $image = $this->multipleUploadFile($image, 'Political-logo');
            $newBusinessUser = new DistributorBusinessFrame;
            $newBusinessUser->user_id = Auth::user()->id;
            $newBusinessUser->distributor_id = Auth::user()->distributor->id;
            $newBusinessUser->business_id = $request->business_id;
            $newBusinessUser->business_type = 2;
            $newBusinessUser->frame_url = $image;
            $newBusinessUser->save();
        }

        return response()->json(['status' => true, 'message' => "Request sent to admin"]);
    }
}
