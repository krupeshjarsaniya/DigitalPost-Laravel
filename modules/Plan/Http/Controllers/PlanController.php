<?php

namespace Modules\Plan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;
use DataTables;
use App\Plan;
use DB;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $plan = Plan::where('plan_id', '!=', 3)->get();

        /*foreach ($plan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
            // echo gettype($value->information), "\n";
        }*/
        // echo "<pre>";
        // print_r($plan);
        // die();
        return view('plan::index', ['plans' => $plan]);
    }

    public function getdetailforedit(Request $req)
    {
        $id = $req->id;
        $plan = Plan::where('plan_id', '=', $id)->first();
        $plan['plan_information'] = unserialize($plan['plan_information']);
        return $plan;
    }

    public function updateplan(Request $request)
    {

        if ($request->planid == "") {
            $validator = Validator::make(
                $request->all(),
                [
                    'planname' => 'required',
                    'validity' => 'required',
                    'price' => 'required',
                    'orderno' => 'required',
                    'image' => 'required',
                ],
                [
                    'planname.required' => 'Name Required',
                    'validity.required' => 'Validity Required',
                    'price.required' => 'Price Required',
                    'orderno.required' => 'Order No Required',
                    'image.required' => 'Image Required',
                ]
            );

            if ($validator->fails()) {
                $error = json_decode($validator->errors());

                return response()->json(['status' => 401, 'error1' => $error]);
                exit();
            }

            $image = $request->image;

            $path = $this->uploadFile($request, null, 'image', 'plan-image');

            $insert = new Plan;
            $insert->plan_name = 'Premium';
            $insert->plan_or_name = $request->planname;
            $insert->plan_actual_price = $request->price;
            $insert->plan_validity = $request->validity;
            $insert->plan_validity_type = $request->validitytime;
            $insert->order_no = $request->orderno;
            $insert->plan_type = $request->plantype;
            $insert->bg_credit = $request->bg_credit;
            $insert->new_or_renewal = $request->new_or_renewal;
            $insert->image = $path;
            $insert->save();
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'planname' => 'required',
                    'validity' => 'required',
                    'price' => 'required',
                    'orderno' => 'required',
                ],
                [
                    'planname.required' => 'Name Required',
                    'validity.required' => 'Validity Required',
                    'price.required' => 'Price Required',
                    'orderno.required' => 'Order No Required',
                ]
            );

            if ($validator->fails()) {
                $error = json_decode($validator->errors());

                return response()->json(['status' => 401, 'error1' => $error]);
                exit();
            }

            $image = (isset($request->image)) ? $request->image : 'undefined';
            if ($image != 'undefined') {
                $path = $this->uploadFile($request, null, 'image', 'plan-image');
            } else {
                $path = "";
            }

            if ($image != 'undefined') {
                Plan::where('plan_id', $request->planid)->update(array(
                    'plan_or_name' => $request->planname,
                    'plan_actual_price' => $request->price,
                    'plan_validity' => $request->validity,
                    'plan_validity_type' => $request->validitytime,
                    'order_no' => $request->orderno,
                    'plan_type' => $request->plantype,
                    'new_or_renewal' => $request->new_or_renewal,
                    'bg_credit' => $request->bg_credit,
                    'image' => $path,
                ));
            } else {
                Plan::where('plan_id', $request->planid)->update(array(
                    'plan_or_name' => $request->planname,
                    'plan_actual_price' => $request->price,
                    'plan_validity' => $request->validity,
                    'plan_validity_type' => $request->validitytime,
                    'order_no' => $request->orderno,
                    'plan_type' => $request->plantype,
                    'new_or_renewal' => $request->new_or_renewal,
                    'bg_credit' => $request->bg_credit,
                ));
            }
        }
        return response()->json(['status' => 1, 'data' => 'Data Successfully upadate']);
    }

    public function BlockPlan(Request $request)
    {
        $Plan_id = $request->id;
        Plan::where('plan_id', $Plan_id)->update(['status' => 1]);

        return response()->json(['status' => 1, 'data' => ""]);
    }

    public function UnBlockPlan(Request $request)
    {
        $Plan_id = $request->id;
        Plan::where('plan_id', $Plan_id)->update(['status' => 0]);

        return response()->json(['status' => 1, 'data' => ""]);
    }
}
