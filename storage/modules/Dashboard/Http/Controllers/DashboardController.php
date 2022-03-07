<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;
use App\User;
use App\Photos;
use DataTables;
use Carbon\Carbon;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      ini_set('memory_limit', -1);
      /* $activeplan = DB::table('purchase_plan')->where('purc_is_cencal','=',0)->Where('purc_is_expire','=',0)->rightJoin('users','purchase_plan.purc_user_id','=','users.id')->leftjoin('business','purchase_plan.purc_business_id','=','business.busi_id')->leftjoin('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->orderBy('purchase_plan.purc_id', 'DESC')->get();*/
      //dd($activeplan);
       //$activeplan = DB::table('users')->where('purchase_plan.purc_is_cencal','=',0)->Where('purchase_plan.purc_is_expire','=',0)->Join('purchase_plan','purchase_plan.purc_user_id','=','users.id')->join('business','purchase_plan.purc_business_id','=','business.busi_id')->join('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->select('users.*','business.busi_name','plan.plan_name','purchase_plan.purc_start_date')->orderBy('purchase_plan.purc_id', 'DESC')->get();
       $activeplan = "";
     
        //$users = User::where('id', '!=', 1)->get();
        // $users = User::all();
        // $totalusers = $users->count(); 

        $todayusers = User::whereDate('created_at', Carbon::now())->count();
        $totalusers = User::count();

        $todayPostDownload = Photos::whereDate('date_added', Carbon::now())->count();
        $totalPostDownload = Photos::count();

        $activePremimumPackages = DB::table('purchase_plan')->where('purc_is_cencal','=',0)->Where('purc_is_expire','=',0)->where('purc_plan_id', '!=',3)->count();
        $expiredPackages = DB::table('purchase_plan')->where('purc_is_expire','=',1)->count();
        $todayNewPackages = DB::table('purchase_plan')->where('purc_plan_id', '!=', 3)->whereDate('purc_start_date','=', Carbon::now())->count();
        $upcomingRenewal = 0;

        //$totalusers = 10;
        return view('dashboard::index',[ 'activeplans' => $activeplan,'todayPostDownload'=>$todayPostDownload,'totalPostDownload'=>$totalPostDownload,'todayusers'=>$todayusers,'totalusers'=>$totalusers,'activePremimumPackages'=>$activePremimumPackages,'expiredPackages'=>$expiredPackages,'todayNewPackages'=>$todayNewPackages,'upcomingRenewal'=>$upcomingRenewal]);
    }

    public function userpurchaseTable(Request $request)
    {
      ini_set('memory_limit', -1);
      if($request->type == "free") {
        $activeplan = DB::table('users')->where('purchase_plan.purc_is_cencal','=',0)->Where('purchase_plan.purc_is_expire','=',0)->where('purchase_plan.purc_plan_id', 3)->Join('purchase_plan','purchase_plan.purc_user_id','=','users.id')->join('business','purchase_plan.purc_business_id','=','business.busi_id')->join('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->select('users.name','users.mobile','business.busi_name','plan.plan_name','purchase_plan.purc_start_date')->orderBy('purchase_plan.purc_start_date', 'DESC');
      }
      else {
        $activeplan = DB::table('users')->where('purchase_plan.purc_is_cencal','=',0)->Where('purchase_plan.purc_is_expire','=',0)->where('purchase_plan.purc_plan_id', '!=', 3)->Join('purchase_plan','purchase_plan.purc_user_id','=','users.id')->join('business','purchase_plan.purc_business_id','=','business.busi_id')->join('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->select('users.name','users.mobile','business.busi_name','plan.plan_name','purchase_plan.purc_start_date')->orderBy('purchase_plan.purc_start_date', 'DESC');
      }

      if ($request->ajax())
      {
        return DataTables::of($activeplan)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->input('search.value'))) {
                  $instance->where(function($w) use($request){
                  $search = $request->input('search.value');
                  $w->orWhere('name', 'LIKE', "%$search%")
                  ->orWhere('plan_name', 'LIKE', "%$search%")
                  ->orWhere('mobile', 'LIKE', "%$search%")
                  ->orWhere('purc_start_date', 'LIKE', "%$search%");
              });
          }
        })
        ->addIndexColumn()
        ->make(true);
      }
    }

    public function Setting()
    {
        $credit = DB::table('setting')->where('setting_id','=',1)->select('credit','setting_id','privacy_policy','terms_condition','whatsapp')->first();
         return view('dashboard::setting',[ 'credit' => $credit]);
    }

    public function updateCredit(Request $request)
    {
        $id = $request->id;
     
       
        DB::table('setting')
          ->where('setting_id', 1)
          ->update(['credit' => $request->amount]);

        return response()->json(['status'=>true,'message'=>'Credit update successfully']);
    }

    public function saveprivacy(Request $request){
         DB::table('setting')
          ->where('setting_id', 1)
          ->update(['privacy_policy' => $request->privacy]);

        return response()->json(['status'=>true,'message'=>'Privacy update successfully']);
    }

    public function saveterms(Request $request){
         DB::table('setting')
          ->where('setting_id', 1)
          ->update(['terms_condition' => $request->termconditions]);

        return response()->json(['status'=>true,'message'=>'terms and condition update successfully']);
    }
    public function updateWhatapp(Request $request){
        DB::table('setting')
        ->where('setting_id', 1)
        ->update(['whatsapp' => $request->whatsapp]);

      return response()->json(['status'=>true,'message'=>'terms and condition update successfully']);
    }


}