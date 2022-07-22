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
use DB;

class DashboardController extends Controller
{

    public function index()
    {
        $totalBusiness = Business::where('user_id',Auth::user()->id)->where('is_distributor_business',1)->count();
        $politicalBusiness = PoliticalBusiness::where('user_id',Auth::user()->id)->where('is_distributor_business',1)->count();
        $getBusinessExpiredplan =  DB::table('purchase_plan')
        ->leftJoin('business','business.busi_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('business.user_id','=',Auth::user()->id)
        ->where('business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',1)
        ->where('purchase_plan.purc_plan_id',3)
        ->count();

        $getPoliticalExpiredplan =  DB::table('purchase_plan')
        ->leftJoin('political_business','political_business.pb_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('political_business.user_id','=',Auth::user()->id)
        ->where('political_business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',2)
        ->where('purchase_plan.purc_plan_id',3)
        ->count();

        $totalExpirePlan = $getBusinessExpiredplan +  $getPoliticalExpiredplan;

        $days = DB::table('setting')->value('renewal_days');
        $current_date = Carbon::now()->addDays($days);
        $getUpcomingBusinessExpiredPlan =  DB::table('purchase_plan')
        ->leftJoin('business','business.busi_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('business.user_id','=',Auth::user()->id)
        ->where('business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',1)
        ->where('purchase_plan.purc_plan_id', '!=',3)
        ->where('purchase_plan.purc_end_date','<=',$current_date)
        ->count();

        $getUpcomingPoliticalExpiredplan =  DB::table('purchase_plan')
        ->leftJoin('political_business','political_business.pb_id','=','purchase_plan.purc_business_id')
        ->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
        ->where('political_business.user_id','=',Auth::user()->id)
        ->where('political_business.is_distributor_business',1)
        ->where('purchase_plan.purc_business_type',2)
        ->where('purchase_plan.purc_plan_id', '!=',3)
        ->where('purchase_plan.purc_end_date','<=',$current_date)
        ->count();
        $totalUpcomingExpiredPlan = $getUpcomingPoliticalExpiredplan + $getUpcomingBusinessExpiredPlan;


        return view('distributor.dashboard', compact('totalBusiness','politicalBusiness','totalExpirePlan','totalUpcomingExpiredPlan'));
    }

    public function profile()
    {
        $distributor = DistributorChannel::find(Auth::user()->distributor->id);
        if(empty($distributor)) {
            return redirect()->back();
        }
        return view('distributor.profile', compact('distributor'));
    }

    public function updateProfile(Request $request) {
        $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required',
                'contact_number' => 'required',
                'area' => 'required',
                'city' => 'required',
                'state' => 'required',
                'current_work' => 'required',
                'work_experience' => 'required',
                'skills' => 'required',
            ],
            [
                'full_name.required' => 'Full Name Is Required',
                'email.required' => 'Email Is Required',
                'contact_number.required' => 'Contact Number Is Required',
                'area.required' => 'Area Is Required',
                'city.required' => 'City Is Required',
                'state.required' => 'State Is Required',
                'current_work.required' => 'Current work Is Required',
                'work_experience.required' => 'Work experience Is Required',
                'skills.required' => 'Skills Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkEmail = DistributorChannel::where('email', $request->email)->where('id', '!=', Auth::user()->distributor->id)->first();
        if(!empty($checkEmail)) {
            return response()->json([
                'status' => false,
                'message' => "Email already exists"
            ]);
        }

        $checkNumber = DistributorChannel::where('contact_number', $request->contact_number)->where('id', '!=', Auth::user()->distributor->id)->first();
        if(!empty($checkNumber)) {
            return response()->json([
                'status' => false,
                'message' => "Contact number already exists"
            ]);
        }

        $distributor = DistributorChannel::where('id', Auth::user()->distributor->id)->first();
        if(empty($distributor)) {
            return response()->json([
                'status' => false,
                'message' => "Distributor not found"
            ]);
        }

        $distributor->full_name = $request->full_name;
        $distributor->email = $request->email;
        $distributor->contact_number = $request->contact_number;
        $distributor->area = $request->area;
        $distributor->city = $request->city;
        $distributor->state = $request->state;
        $distributor->current_work = $request->current_work;
        $distributor->work_experience = $request->work_experience;
        $distributor->skills = $request->skills;

        if($request->hasFile('aadhar_card_photo')) {
            $aadhar_card_photo = $this->uploadFile($request, null, 'aadhar_card_photo', 'distributor-image');
            $distributor->aadhar_card_photo = $aadhar_card_photo;
        }

        if($request->hasFile('user_photo')) {
            $user_photo = $this->uploadFile($request, null, 'user_photo', 'distributor-image');
            $distributor->user_photo = $user_photo;
        }

        $distributor->save();

        return response()->json([
            'status' => true,
            'message' => "Profile updated successfully",
            'data' => $distributor
        ]);
    }

    public function transaction()
    {
        return view('distributor.transaction');
    }

    public function transactionList(Request $request, $id) {
        $transactions = DistributorTransaction::where('distributor_id', $id);
        return DataTables::of($transactions)
        ->editColumn('type', function ($transaction) {
            if($transaction->type == 'deposit' || $transaction->type == 'user_referral') {
                return "<span style='font-size: 12px; text-transform: uppercase;' class='badge badge-success'>$transaction->type</span>";
            }
            else {
                return "<span style='font-size: 12px; text-transform: uppercase;' class='badge badge-danger'>$transaction->type</span>";
            }
        })
        ->editColumn('created_at', function ($transaction) {
            return Carbon::parse($transaction->created_at)->format("d-m-Y h:i A");
        })
        ->rawColumns(['created_at', 'type'])
        ->make(true);
    }
}
