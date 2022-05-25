<?php

namespace Modules\Plan\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\BGCreditPlan;

class BGPlanController extends Controller
{
    public function index() {
        return view('plan::bg_credit_plan');
    }

    public function getBGRemovePlanList(Request $request) {
        $plans = BGCreditPlan::all();
        return DataTables::of($plans)
                ->addColumn('action', function($row) {
                    $btn = "";
                    $btn .= '<button class="btn btn-primary btn-sm mb-2 mt-2 mr-3" data-id="'.$row->id.'" onclick="editBGRemovePlan(this)">Edit</button>';
                    if($row->status === "BLOCK") {
                        $btn .= '<button class="btn btn-success btn-sm mb-2 mt-2 mr-3" data-id="'.$row->id.'" data-status="UNBLOCK" onclick="changeStatusBGRemovePlan(this)">Unblock</button>';
                    }
                    else {
                        $btn .= '<button class="btn btn-success btn-sm mb-2 mt-2 mr-3" data-id="'.$row->id.'" data-status="BLOCK" onclick="changeStatusBGRemovePlan(this)">Block</button>';
                    }
                    return $btn;
                })
                ->make();
    }

    public function addBGRemovePlan(Request $request) {
        $rule = [
            'name' => 'required',
            'price' => 'required|integer',
            'bg_credit' => 'required|integer',
            'status' => 'required',
        ];
        $message = [
            'name.required' => "Name is Required",
            'price.required' => "Price is Required",
            'price.integer' => "Enter valid price",
            'bg_credit.required' => "BG Remove Credit is Required",
            'bg_credit.integer' => "Enter valid credit",
            'status.required' => "Status is Required",
        ];

        $validator = Validator::make($request->all(), $rule, $message);

        if($validator->fails()) {
            $error = json_decode($validator->errors());
            return response()->json(['status' => 401, 'error1' => $error]);
        }

        $newPlan = new BGCreditPlan;
        $newPlan->name = $request->name;
        $newPlan->price = $request->price;
        $newPlan->bg_credit = $request->bg_credit;
        $newPlan->status = $request->status;
        if(isset($request->order_number) && $request->order_number != '' && $request->order_number > 0) {
            $newPlan->order_number = $request->order_number;
        }
        $newPlan->save();

        return response()->json(['status' => true, 'message' => 'Plan Addedd Successfully']);
    }

    public function getBGRemovePlanById(Request $request) {
        $plan = BGCreditPlan::find($request->id);
        if(empty($plan)) {
            return response()->json(['status' => false, 'message' => 'Plan not found']);
        }
        return response()->json(['status' => true, 'data' => $plan, 'message' => 'Plan fetched successfully']);
    }

    public function updateBGRemovePlan(Request $request) {
        $rule = [
            'name' => 'required',
            'price' => 'required|integer',
            'bg_credit' => 'required|integer',
        ];
        $message = [
            'name.required' => "Name is Required",
            'price.required' => "Price is Required",
            'price.integer' => "Enter valid price",
            'bg_credit.required' => "BG Remove Credit is Required",
            'bg_credit.integer' => "Enter valid credit",
        ];

        $validator = Validator::make($request->all(), $rule, $message);

        if($validator->fails()) {
            $error = json_decode($validator->errors());
            return response()->json(['status' => 401, 'error1' => $error]);
        }

        $plan = BGCreditPlan::find($request->id);

        if(empty($plan)) {
            return response()->json(['status' => false, 'message' => 'Plan not found']);
        }

        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->bg_credit = $request->bg_credit;
        if(isset($request->order_number) && $request->order_number != '' && $request->order_number > 0) {
            $plan->order_number = $request->order_number;
        }
        else {
            $plan->order_number = null;
        }
        $plan->save();

        return response()->json(['status' => true, 'message' => 'Plan updated successfully']);
    }

    public function updateStatusBGRemovePlan(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $plan = BGCreditPlan::find($id);
        if(empty($plan)) {
            return response()->json(['status' => false, 'message' => 'Plan not found']);
        }
        $plan->status = $request->status;
        $plan->save();
        return response()->json(['status' => true, 'message' => 'Plan sucessfully ' . $status]);
    }
}
