<?php

namespace Modules\Plan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;
use DataTables;
use App\Plan;
use DB;
use Illuminate\Support\Facades\Storage;

class PlanApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
       
        $plans = Plan::where('status','!=',1)->where('plan_id','!=',3)->orderBy('order_no','asc')->get();
        $plan = array();

        foreach ($plans as $key => $value) 
        {
            $data['id'] = strval($value->plan_id);
            $data['plan_name'] = !empty($value->name)?$value->name:"";
            $data['price'] = !empty($value->plan_actual_price)?$value->plan_actual_price:"";
            $data['plan_validity'] = !empty($value->plan_validity)?$value->plan_validity:"";
            $data['plan_validity_type'] = !empty($value->plan_validity_type)?$value->plan_validity_type:"";
            $data['order_no'] = !empty($value->order_no)?$value->order_no:"";
            $data['image'] = !empty($value->image)?Storage::url($value->image):"";
            array_push($plan, $data);
        }
         return response()->json(['data'=> $plan, 'status'=>true,'message'=>'List of Plan']); 
    }


}
