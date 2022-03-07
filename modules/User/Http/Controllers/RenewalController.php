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
use Auth;
use App\User;
use View;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $telecallers = User::where('status', '!=', 2)->where('user_role', 2)->get();
        return view('user::renewal', ['telecallers' => $telecallers]);
    }

    public function list(Request $request) {
        $days = 5;
        $credit = DB::table('setting')->where('setting_id','=',1)->select('credit','setting_id','privacy_policy','terms_condition','whatsapp', 'renewal_days', 'renewal_image')->first();
        if(!empty($credit)) {
            $days = $credit->renewal_days;
        }
        if($request->type == 1) {
            if(Auth::user()->user_role == 1) {
                $plans = DB::table('purchase_plan')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->whereDate('purc_end_date', '<', Carbon::now()->addDays($days))->join('users', 'users.id' ,'=', 'purchase_plan.purc_user_id')->whereDate('purc_end_date', '>', Carbon::now())->where('users.status', '!=', 2)->select('purchase_plan.*', 'users.name', 'users.mobile', 'users.tel_user', 'plan.plan_name', 'plan.plan_or_name');
            }
            else {
                $plans = DB::table('purchase_plan')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->whereDate('purc_end_date', '<', Carbon::now()->addDays($days))->join('users', 'users.id' ,'=', 'purchase_plan.purc_user_id')->where('users.tel_user', Auth::user()->id)->where('users.status', '!=', 2)->whereDate('purc_end_date', '>', Carbon::now())->select('purchase_plan.*', 'users.name', 'users.mobile', 'users.tel_user', 'plan.plan_name', 'plan.plan_or_name');
            }
        }
        else {
            if(Auth::user()->user_role == 1) {
                $plans = DB::table('purchase_plan')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->where(function($q) {
                    $q->where('purc_is_expire','=',1)->orWhereDate('purc_end_date', '<', Carbon::now());
                })->join('users', 'users.id' ,'=', 'purchase_plan.purc_user_id')->where('users.status', '!=', 2)->select('purchase_plan.*', 'users.name', 'users.mobile', 'users.tel_user', 'plan.plan_name', 'plan.plan_or_name');
            }
            else {
                $plans = DB::table('purchase_plan')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->where(function($q) {
                    $q->where('purc_is_expire','=',1)->orWhereDate('purc_end_date', '<', Carbon::now());
                })->join('users', 'users.id' ,'=', 'purchase_plan.purc_user_id')->where('users.tel_user', Auth::user()->id)->where('users.status', '!=', 2)->select('purchase_plan.*', 'users.name', 'users.mobile', 'users.tel_user', 'plan.plan_name', 'plan.plan_or_name');
            }
        }
        if($request->status != "") {
            $plans->where('purc_tel_status', $request->status);
        }
        if(!empty($request->follow_up_date)) {
            $plans->whereDate('purc_follow_up_date', $request->follow_up_date);
        }
        return DataTables::of($plans)
        ->addIndexColumn()
        ->addColumn('name', function($row) {
            return $row->name;
        })
        ->addColumn('business_name', function($row) {
            $name = "";
            if($row->purc_business_type == 1) {
                $business = DB::table('business')->where('busi_id', $row->purc_business_id)->first();
                if($business) {
                    $name = $business->busi_name;
                }
            }
            else {
                $business = DB::table('political_business')->where('pb_id', $row->purc_business_id)->first();
                if($business) {
                    $name = $business->pb_name;
                }
            }
            return $name;
        })
        ->addColumn('business_type', function($row) {
            if($row->purc_business_type == 1) {
                return "Normal Business";
            }
            else {
                return "Political Business";
            }
        })
        ->addColumn('start_date', function($row) {
            if($row->purc_start_date) {
                return Carbon::parse($row->purc_start_date)->format('d-m-Y');
            }
            return "";
        })
        ->addColumn('end_date', function($row) {
            $history = DB::table('purchase_plan_history')->where('pph_purc_business_id', $row->purc_business_id)->where('pph_purc_business_type', $row->purc_business_type)->leftJoin('plan','plan.plan_id','=','purchase_plan_history.pph_purc_plan_id')->orderby('purchase_plan_history.pph_purc_createdat', 'DESC')->select('purchase_plan_history.*','plan.plan_or_name')->first();
            if(!empty($history)) {
                return $history->pph_purc_end_date;
            }
            if($row->purc_end_date) {
                return Carbon::parse($row->purc_end_date)->format('d-m-Y');
            }
            return "";
        })
        ->addColumn('follow_up_date', function($row) {

            if(!empty($row->purc_follow_up_date)) {
                return Carbon::parse($row->purc_follow_up_date)->format('d-m-Y');
            }
            return "";
        })
        ->addColumn('telecaller_status', function($row) {
            if($row->purc_tel_status == 0) {
                return "New Lead";
            }
            if($row->purc_tel_status == 1) {
                return "Hold";
            }
            if($row->purc_tel_status == 2) {
                return "Intersted but not now";
            }
            if($row->purc_tel_status == 3) {
                return "Payment Details shared";
            }
            if($row->purc_tel_status == 4) {
                return "Call Back";
            }
            if($row->purc_tel_status == 5) {
                return "Trail Request";
            }
            if($row->purc_tel_status == 6) {
                return "Not Intersted";
            }
            if($row->purc_tel_status == 7) {
                return "Complete";
            }
            if($row->purc_tel_status == 8) {
                return "Expired";
            }
            if($row->purc_tel_status == 9) {
                return "Cancelled";
            }
        })
        ->addColumn('plan_name', function($row) use ($request) {
            if($request->type == 1) {
                return $row->plan_or_name;
            }
            $history = DB::table('purchase_plan_history')->where('pph_is_latest', 1)->where('pph_purc_business_id', $row->purc_business_id)->where('pph_purc_business_type', $row->purc_business_type)->leftJoin('plan','plan.plan_id','=','purchase_plan_history.pph_purc_plan_id')->first();
            if(!empty($history)) {
                return $history->plan_or_name;
            }
            return $row->plan_or_name;
        })
        ->addColumn('telecaller', function($row) {
            $user = User::find($row->tel_user);
            if($user) {
                return $user->name;
            }
            return "<button class='btn btn-sm btn-primary' onclick='assigneTelecaller(this)' data-id='".$row->purc_user_id."'>Assign</button>";
        })
        ->addColumn('action', function($row) {
            return "<button class='btn btn-sm btn-primary' onclick='viewDetails(this)' data-id='".$row->purc_id."'>View</button>";
        })
        ->rawColumns(['action', 'telecaller'])
        ->make(true);

    }

    public function getBusinessComment(Request $request) {
        $purc_id = $request->purc_id;
        $purchaseData = DB::table('purchase_plan')->where('purc_id', $purc_id)->first();
        $business_type = $purchaseData->purc_business_type;
        $business_id = $purchaseData->purc_business_id;
        $status = $purchaseData->purc_tel_status;
        $business_comments = DB::table('user_business_comment')->where('business_type', $business_type)->where('business_id', $business_id)->orderBy('id', 'DESC')->get();
        $commentData = (string)View::make('user::viewBusinessComments')->with('business_comments',$business_comments);
        
        return response()->json(['status'=>true, 'commentData'=> $commentData, 'purc_id' => $purc_id, 'business_type' => $business_type, 'business_id' => $business_id, 'status' => $status ]);
    }

    public function addBusinessComment(Request $request) {
        $validator = Validator::make($request->all(), [
            'purc_id' => 'required',      
            'business_type' => 'required',      
            'business_id' => 'required',      
        ],
        [
            'purc_id.required'=> "Something goes wrong",
            'business_type.required'=> "Something goes wrong",
            'business_id.required'=> "Something goes wrong",
        ]);

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

         if($request->business_follow_up_date) {
            $business_data  = array(
                'purc_tel_status' => $request->status ? $request->status : "",
                'purc_follow_up_date' => $request->business_follow_up_date,
            );
            DB::table('purchase_plan')->where('purc_id', $request->purc_id)->update($business_data);
        }
        else {
            $business_data  = array(
                'purc_tel_status' => $request->status ? $request->status : "",
                'purc_follow_up_date' => null,
            );
            DB::table('purchase_plan')->where('purc_id', $request->purc_id)->update($business_data);
        }
        if(!empty($request->comment)) {
            $commentData = array(
                'tel_user_id' => Auth::user()->id,
                'purc_id' => $request->purc_id,
                'business_type' => $request->business_type,
                'business_id' => $request->business_id,
                'comment' => $request->comment,
            );
            DB::table('user_business_comment')->insert($commentData);
        }
        return response()->json(['status'=>1]);
    }

    public function getPurchaseHistory(Request $request) {
        $history = DB::table('purchase_plan_history')->where('pph_purc_business_id', $request->business_id)->where('pph_purc_business_type', $request->business_type)->leftJoin('plan','plan.plan_id','=','purchase_plan_history.pph_purc_plan_id')->orderby('purchase_plan_history.pph_purc_createdat', 'DESC')->select('purchase_plan_history.*','plan.plan_or_name');
        return DataTables::of($history)
        ->editColumn('pph_purc_createdat', function($row) {
            return Carbon::parse($row->pph_purc_createdat)->format('Y-m-d');
        })
        ->editColumn('pph_cencal_date', function($row) {
            if($row->pph_cencal_date) {
                return Carbon::parse($row->pph_cencal_date)->format('Y-m-d');
            }
            return "-";
        })
        ->addIndexColumn()
        ->make(true);
    }

}
