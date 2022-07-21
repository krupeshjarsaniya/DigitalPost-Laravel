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
use App\PoliticalBusiness;
use App\Purchase;
use App\Plan;
use App\DistributorBusinessUser;
use App\DistributorBusinessFrame;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{

    public function index()
    {
        return view('distributor.business');
    }

    public function businessList(Request $request)
    {
        $businesses = Business::where('user_id', Auth::user()->id)->where('is_distributor_business', 1);
        return DataTables::of($businesses)
            ->addIndexColumn()
            ->editColumn('busi_mobile', function ($row) {
                $mobile = array();
                if (!empty($row->busi_mobile)) {
                    array_push($mobile, $row->busi_mobile);
                }
                if (!empty($row->busi_mobile_second)) {
                    array_push($mobile, $row->busi_mobile_second);
                }

                return implode("<br />", $mobile);
            })
            ->editColumn('busi_logo', function ($row) {
                $image = "";
                if (!empty($row->busi_logo)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->busi_logo) . "' />";
                }
                return $image;
            })
            ->editColumn('watermark_image', function ($row) {
                $image = "";
                if (!empty($row->watermark_image)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->watermark_image) . "' />";
                }
                return $image;
            })
            ->editColumn('busi_logo_dark', function ($row) {
                $image = "";
                if (!empty($row->busi_logo_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->busi_logo_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('watermark_image_dark', function ($row) {
                $image = "";
                if (!empty($row->watermark_image_dark)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->watermark_image_dark) . "' />";
                }
                return $image;
            })
            ->editColumn('is_premium', function ($row) {
                $is_premium = "<span class='badge badge-danger'>false</span>";

                $checkPurchase = Purchase::where('purc_business_type', 1)->where('purc_business_id', $row->busi_id)->where('purc_plan_id', '!=', 3)->first();
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
                $url = route('distributors.businessView', $row->busi_id);
                $button = "";
                $button .= '<a href="' . $url . '" class="btn btn-primary btn-sm mb-2">View</a>';
                return $button;
            })
            ->rawColumns(['busi_mobile', 'busi_logo', 'watermark_image', 'busi_logo_dark', 'watermark_image_dark', 'is_premium', 'action'])
            ->make(true);
    }

    public function businessAdd(Request $request)
    {
        $busi_cats = DB::table('business_category')->where('is_delete', 0)->get();
        return view('distributor.businessAdd', compact('busi_cats'));
    }

    public function businessInsert(Request $request)
    {
        $distributor = Auth::user()->distributor;
        $user_id  = auth()->user()->id;
        $validator = Validator::make(
            $request->all(),
            [
                'busi_name' => 'required',
            ],
            [
                'busi_name' => 'Please Enter Name',
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
        if ($purc_plan_id == Plan::$combo_plan_id) {
            $plan_rate = $distributor->combo_plan_rate;
        }
        if ($distributor->balance < $plan_rate) {
            return response()->json(['status' => false, 'message' => "insufficient balance"]);
        }
        $new_balance -= $plan_rate;

        $newBusiness = new Business;
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

        if ($request->hasFile('busi_logo')) {
            $busi_logo = $this->uploadFile($request, null, 'busi_logo', 'business-img');
            $newBusiness->busi_logo = $busi_logo;
        }
        if ($request->hasFile('busi_logo_dark')) {
            $busi_logo_dark = $this->uploadFile($request, null, 'busi_logo_dark', 'business-img');
            $newBusiness->busi_logo_dark = $busi_logo_dark;
        }
        if ($request->hasFile('watermark_image')) {
            $watermark_image = $this->uploadFile($request, null, 'watermark_image', 'business-img');
            $newBusiness->watermark_image = $watermark_image;
        }
        if ($request->hasFile('watermark_image_dark')) {
            $watermark_image_dark = $this->uploadFile($request, null, 'watermark_image_dark', 'business-img');
            $newBusiness->watermark_image_dark = $watermark_image_dark;
        }

        $newBusiness->business_category = $request->business_category;
        $newBusiness->save();

        $purc_business_id = $newBusiness->busi_id;

        $plan = Plan::where('plan_id', $purc_plan_id)->first();
        $start_date = date('Y-m-d', time());
        $end_date = date('Y-m-d', strtotime($start_date . '+ ' . $plan->plan_validity . ' days'));

        $purchase = new Purchase;
        $purchase->purc_user_id = $user_id;
        $purchase->purc_business_id = $purc_business_id;
        $purchase->purc_plan_id = $purc_plan_id;
        $purchase->purc_start_date = $start_date;
        $purchase->purc_end_date = $end_date;
        $purchase->save();

        $this->addPurchasePlanHistory($purc_business_id, 1, $start_date);

        if ($purc_plan_id == Plan::$combo_plan_id) {

            $busi_cats = DB::table('political_category')->where('pc_is_deleted', 0)->first();

            $newPoliticalBusiness = new PoliticalBusiness();
            $newPoliticalBusiness->user_id = $user_id;
            $newPoliticalBusiness->is_distributor_business = 1;
            $newPoliticalBusiness->pb_name = $request->busi_name;
            $newPoliticalBusiness->pb_designation = "";
            $newPoliticalBusiness->pb_mobile = $request->busi_mobile;
            $newPoliticalBusiness->pb_mobile_second = $request->busi_mobile_second;
            $newPoliticalBusiness->pb_pc_id = $busi_cats ? $busi_cats->pc_id : 0;
            $newPoliticalBusiness->hashtag = $request->hashtag;
            $newPoliticalBusiness->pb_facebook = $request->busi_facebook;
            $newPoliticalBusiness->pb_twitter = $request->busi_twitter;
            $newPoliticalBusiness->pb_instagram = $request->busi_instagram;
            $newPoliticalBusiness->pb_linkedin = $request->busi_linkedin;
            $newPoliticalBusiness->pb_youtube = $request->busi_youtube;

            $newPoliticalBusiness->save();

            $purc_political_business_id = $newPoliticalBusiness->pb_id;

            $purchase = new Purchase;
            $purchase->purc_user_id = $user_id;
            $purchase->purc_business_id = $purc_political_business_id;
            $purchase->purc_business_type = 2;
            $purchase->purc_plan_id = $purc_plan_id;
            $purchase->purc_start_date = $start_date;
            $purchase->purc_end_date = $end_date;
            $purchase->save();

            $this->addPurchasePlanHistory($purc_political_business_id, 2, $start_date);
        }

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

        return response()->json(['status' => true, 'message' => "Business Insert successfully"]);
    }

    public function businessView($id)
    {
        $busi_cats = DB::table('business_category')->where('is_delete', 0)->get();
        $business = Business::where('busi_id', $id)->where('user_id', Auth::user()->id)->where('busi_delete', 0)->first();
        if (empty($business)) {
            return redirect()->back()->with('message', 'Business Not Found');
        }
        return view('distributor.businessView', compact('busi_cats', 'business'));
    }

    public function businessUpdate(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'busi_name' => 'required',
            ],
            [
                'busi_name' => 'Please Enter Name',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $message = "";
        $newBusiness = Business::where('busi_id', $id)->first();
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

        if ($request->hasFile('busi_logo')) {
            $busi_logo = $this->uploadFile($request, null, 'busi_logo', 'business-img');
            $newBusiness->busi_logo = $busi_logo;
        }
        if ($request->hasFile('busi_logo_dark')) {
            $busi_logo_dark = $this->uploadFile($request, null, 'busi_logo_dark', 'business-img');
            $newBusiness->busi_logo_dark = $busi_logo_dark;
        }
        if ($request->hasFile('watermark_image')) {
            $watermark_image = $this->uploadFile($request, null, 'watermark_image', 'business-img');
            $newBusiness->watermark_image = $watermark_image;
        }
        if ($request->hasFile('watermark_image_dark')) {
            $watermark_image_dark = $this->uploadFile($request, null, 'watermark_image_dark', 'business-img');
            $newBusiness->watermark_image_dark = $watermark_image_dark;
        }

        $newBusiness->business_category = $request->business_category;

        $message = "Business Updated successfully";
        if ($newBusiness->busi_name != $request->busi_name) {

            $checkOldEntry = DB::table('business_new')->where('busi_id_old', $newBusiness->busi_id)->first();
            if (!empty($checkOldEntry)) {
                DB::table('business_new')
                    ->where('busi_id_old', $newBusiness->busi_id)
                    ->update([
                        'busi_name_new' => $request->busi_name,
                        'busi_id_old' => $newBusiness->busi_id,
                        'user_id_new' => Auth::user()->id,
                        'busi_is_approved_new' => 0
                    ]);
            } else {
                DB::table('business_new')
                    ->insert([
                        'busi_id_old' => $newBusiness->busi_id,
                        'busi_name_new' => $request->busi_name,
                        'user_id_new' => Auth::user()->id,
                        'busi_is_approved_new' => 0
                    ]);
            }
            $newBusiness->busi_is_approved = 0;
            $message = "Business Updated Request Sent To Admin successfully";
        }
        $newBusiness->save();

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function businessUserList(Request $request)
    {
        $businesses = DistributorBusinessUser::with('user')
            ->where('business_id', $request->id)
            ->where('business_type', 1);
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

    public function businessPurchaseList(Request $request)
    {
        $businesses = DB::table('purchase_plan_history')->where('pph_purc_business_id', $request->id)
            ->where('pph_purc_business_type', 1);
        return DataTables::of($businesses)
            ->addIndexColumn()
            ->addColumn('plan', function ($row) {
                $plan_name = "Premium";
                $plan = Plan::where('plan_id', $row->pph_purc_plan_id)->first();
                if(!empty($plan)) {
                    $plan_name = $plan->plan_or_name;
                }
                return $plan_name;
            })
            ->make(true);
    }

    public function getPendingFrameList(Request $request)
    {
        $businesses = DistributorBusinessFrame::where('business_id', $request->id)
            ->where('business_type', 1);
        return DataTables::of($businesses)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = "";
                if ($row->status == "PENDING") {
                    $status = '<span class="badge badge-primary">' . $row->status . '</span>';
                } else {
                    $status = '<span class="badge badge-danger">' . $row->status . '</span>';
                }
                return $status;
            })
            ->addColumn('frame_url', function ($row) {
                $image = "";
                if (!empty($row->frame_url)) {
                    $image = "<img height='100' width='100' src='" . Storage::url($row->frame_url) . "' />";
                }
                return $image;
            })
            ->rawColumns(['frame_url', 'status'])
            ->make(true);
    }


    public function businessUserAdd(Request $request)
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
                ->where('business_type', 1)
                ->first();
            if (empty($newBusinessUser)) {
                $newBusinessUser = new DistributorBusinessUser;
            }
            $newBusinessUser->business_id = $request->business_id;
            $newBusinessUser->business_type = 1;
            $newBusinessUser->user_id = $user_id;
            $newBusinessUser->save();
        }

        return response()->json(['status' => true, 'message' => "Users added successfully"]);
    }

    public function businessUserDelete(Request $request)
    {
        $user_id = $request->id;
        $business_id = $request->business_id;

        $newBusinessUser = DistributorBusinessUser::where('business_id', $business_id)
            ->where('user_id', $user_id)
            ->where('business_type', 1)
            ->first();
        if (!empty($newBusinessUser)) {
            $newBusinessUser->delete();
        }
        return response()->json(['status' => true, 'message' => "Users removed successfully"]);
    }

    public function businessFrameList(Request $request)
    {
        $frames = DB::table('user_frames')
            ->where('business_id', $request->id)
            ->where('business_type', 1)
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

    public function businessFrameAdd(Request $request)
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
            $newBusinessUser->business_type = 1;
            $newBusinessUser->frame_url = $image;
            $newBusinessUser->save();
        }

        return response()->json(['status' => true, 'message' => "Request sent to admin"]);
    }

    public function upcomingRenewals(Request $request)
    {
        return view('distributor.upcomingRenewals');
    }

    public function normalBusinessExpirePlan (Request $request)
    {
        $getexpiredplan =  DB::table('purchase_plan')
        ->leftJoin('business','business.busi_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('business.user_id','=',Auth::user()->id)
        ->where('business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',1)
        ->where('purchase_plan.purc_plan_id',3)
        ->get();

        if ($request->ajax())
        {
            return DataTables::of($getexpiredplan)
            ->addIndexColumn()
            ->addColumn('purc_start_date',function($row) {
                $date = date('d-m-Y',strtotime($row->purc_start_date));
                return $date;
            })
            ->addColumn('purc_end_date',function($row) {
                $date1 = date('d-m-Y',strtotime($row->purc_end_date));
                return $date1;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary" id="purchaseplans" data-id="'.$row->busi_id.'" data-type="'.$row->purc_business_type.'" onclick="purchaseplans(this)">Purchase Plan</button>';
                return $btn;
            })
            ->rawColumns(['action','purc_end_date','purc_start_date'])
            ->make(true);
        }
    }
    public function politicalBusinessExpirePlan (Request $request)
    {
        $getexpiredplan =  DB::table('purchase_plan')
        ->leftJoin('political_business','political_business.pb_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('political_business.user_id','=',Auth::user()->id)
        ->where('political_business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',2)
        ->where('purchase_plan.purc_plan_id',3)
        ->get();

        if ($request->ajax())
        {
            return DataTables::of($getexpiredplan)
            ->addIndexColumn()
            ->addColumn('purc_start_date',function($row) {
                $date = date('d-m-Y',strtotime($row->purc_start_date));
                return $date;
            })
            ->addColumn('purc_end_date',function($row) {
                $date1 = date('d-m-Y',strtotime($row->purc_end_date));
                return $date1;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary" id="purchaseplans" data-id="'.$row->pb_id.'" data-type="'.$row->purc_business_type.'" onclick="purchaseplans(this)">Purchase Plan</button>';
                return $btn;
            })
            ->rawColumns(['action','purc_end_date','purc_start_date'])
            ->make(true);
        }
    }

    public function normalBusinessUpcomingExpirePlan (Request $request)
    {
        $days = DB::table('setting')->value('renewal_days');
        $current_date = Carbon::now()->addDays($days);
        $getexpiredplan =  DB::table('purchase_plan')
        ->leftJoin('business','business.busi_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('business.user_id','=',Auth::user()->id)
        ->where('business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',1)
        ->where('purchase_plan.purc_plan_id', '!=',3)
        ->where('purchase_plan.purc_end_date','<=',$current_date)
        ->get();

        if ($request->ajax())
        {
            return DataTables::of($getexpiredplan)
            ->addIndexColumn()
            ->addColumn('purc_start_date',function($row) {
                $date = date('d-m-Y',strtotime($row->purc_start_date));
                return $date;
            })
            ->addColumn('purc_end_date',function($row) {
                $date1 = date('d-m-Y',strtotime($row->purc_end_date));
                return $date1;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary" id="purchaseplans" data-id="'.$row->busi_id.'" data-type="'.$row->purc_business_type.'" onclick="purchaseplans(this)">Purchase Plan</button>';
                return $btn;
            })
            ->rawColumns(['action','purc_end_date','purc_start_date'])
            ->make(true);
        }
    }
    public function politicalBusinessUpcomingExpirePlan (Request $request)
    {
        $days = DB::table('setting')->value('renewal_days');
        $current_date = Carbon::now()->addDays($days);
        $getexpiredplan =  DB::table('purchase_plan')
        ->leftJoin('political_business','political_business.pb_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('political_business.user_id','=',Auth::user()->id)
        ->where('political_business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',2)
        ->where('purchase_plan.purc_plan_id', '!=',3)
        ->where('purchase_plan.purc_end_date','<=',$current_date)
        ->get();

        if ($request->ajax())
        {
            return DataTables::of($getexpiredplan)
            ->addIndexColumn()
            ->addColumn('purc_start_date',function($row) {
                $date = date('d-m-Y',strtotime($row->purc_start_date));
                return $date;
            })
            ->addColumn('purc_end_date',function($row) {
                $date1 = date('d-m-Y',strtotime($row->purc_end_date));
                return $date1;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary" id="purchaseplans" data-id="'.$row->pb_id.'" data-type="'.$row->purc_business_type.'" onclick="purchaseplans(this)">Purchase Plan</button>';
                return $btn;
            })
            ->rawColumns(['action','purc_end_date','purc_start_date'])
            ->make(true);
        }
    }

    public function purchasePlan(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'purc_plan_id' => 'required',
                'business_id' => 'required',
                'business_type' => 'required',
            ],
            [
                'purc_plan_id.required' => 'Plan is required',
                'business_id.required' => 'Business ID is required',
                'business_type.required' => 'Business Type is required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $plan = Plan::where('plan_id', $request->purc_plan_id)->first();

        $distributor = Auth::user()->distributor;

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

        $checkPurchase = Purchase::where('purc_business_id', $request->business_id)
        ->where('purc_business_type', $request->business_type)->first();
        $start_date = date('Y-m-d', time());
        if(empty($checkPurchase)) {
            $end_date = date('Y-m-d', strtotime($start_date . '+ ' . $plan->plan_validity . ' days'));
            $purchase = new Purchase;
            $purchase->purc_user_id = Auth::user()->id;
            $purchase->purc_business_id = $request->business_id;
            $purchase->purc_plan_id = $request->purc_plan_id;
            $purchase->purc_start_date = $start_date;
            $purchase->purc_end_date = $end_date;
            $purchase->save();
        }
        else {

            if($checkPurchase->purc_plan_id == 3 || empty($checkPurchase->purc_end_date)) {
                $end_date = date('Y-m-d', strtotime($start_date . '+ ' . $plan->plan_validity . ' days'));
            }
            else {
                $end_date = date('Y-m-d', strtotime($start_date . '+ ' . $plan->plan_validity . ' days'));
                $end_date = Carbon::parse($end_date);
                $tmp_end_date = Carbon::parse($checkPurchase->purc_end_date);
                $tmp_start_date = Carbon::now();
                $diff = $tmp_end_date->diffInDays($tmp_start_date);
                $start_date = $tmp_start_date->addDays($diff);
                $end_date = $end_date->addDays($diff);
            }

            Purchase::where('purc_business_id', $request->business_id)->where('purc_business_type', $request->business_type)->update([
                'purc_plan_id' => $request->purc_plan_id,
                'purc_start_date' => date('Y-m-d', time()),
                'purc_end_date' => $end_date,
                'purc_order_id' => "",
                'purchase_id' => "",
                'device' => "",
                'purc_is_cencal' => 0,
                'purc_tel_status' => 7,
                'purc_follow_up_date' => null,
                'purc_is_expire' => 0,
            ]);

        }

        $distributorBalance = DistributorChannel::find($distributor->id);
        $distributorBalance->balance = $new_balance;
        $distributorBalance->save();

        $transaction = new DistributorTransaction;
        $transaction->distributor_id = $distributor->id;
        $transaction->amount = $plan_rate;
        $transaction->type = 'purchase_business';
        $transaction->description = 'Purchase Plan : ' . $plan->plan_or_name;
        $transaction->business_id = $request->business_id;
        $transaction->business_type = $request->business_type;
        $transaction->save();

        $this->addPurchasePlanHistory($request->business_id, $request->business_type, $start_date);
        return response()->json(['status' => true, 'message' => "Business Purchase successfully"]);

    }


}
