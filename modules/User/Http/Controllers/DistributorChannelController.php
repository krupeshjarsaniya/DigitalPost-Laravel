<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DistributorChannel;
use App\DistributorTransaction;
use DataTables;
use Validator;
use Carbon\Carbon;

class DistributorChannelController extends Controller
{
    public function index() {
        return view('user::distributor_channel');
    }

    public function list(Request $request) {
        $distributors = DistributorChannel::select('*');
        return DataTables::of($distributors)
            ->editColumn('created_at', function ($transaction) {
                return Carbon::parse($transaction->created_at)->format("d-m-Y h:i A");
            })
            ->addColumn('action', function ($distributor) {
                $button = "";
                if($distributor->status != 'approved') {
                    $button .= '<button onclick="approveRequest(this)" class="btn btn-xs btn-success btn-edit mb-2 ml-2" data-id="'.$distributor->id.'">Approve</button>';
                }
                if($distributor->status != 'rejected') {
                    $button .= '<button onclick="rejectRequest(this)" class="btn btn-xs btn-danger btn-delet mb-2 ml-2" data-id="'.$distributor->id.'">Reject</button>';
                }
                $view_url = route('distributor_channel.view', ['id' => $distributor->id]);
                $button .= '<a href="'.$view_url.'" class="btn btn-xs btn-primary btn-edit mb-2 ml-2" data-id="'.$distributor->id.'">View</button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function get(Request $request) {
        $id = $request->id;
        $data = DistributorChannel::find($id);
        if(empty($data)) {
            return response()->json([
                'status' => false,
                'message' => "Request not found"
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => "Data fetched successfully",
            'data' => $data
        ]);
    }

    public function approve(Request $request) {

        $validator = Validator::make($request->all(), [
                'id' => 'required',
                'referral_benefits' => 'required',
                'start_up_plan_rate' => 'required',
                'custom_plan_rate' => 'required',
            ],
            [
                'id.required' => 'ID Is required',
                'referral_benefits.required' => 'Referral Benefits Is Required',
                'start_up_plan_rate.required' => 'Start Up Plan Rate Is Required',
                'custom_plan_rate.required' => 'Custom Plan Rate Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $id = $request->id;
        $checkRequest = DistributorChannel::find($id);
        if(!empty($checkRequest)) {
            $checkRequest->referral_benefits = $request->referral_benefits;
            $checkRequest->start_up_plan_rate = $request->start_up_plan_rate;
            $checkRequest->custom_plan_rate = $request->custom_plan_rate;
            $checkRequest->status = 'approved';
        }
        $checkRequest->save();

        return response()->json([
            'status' => true,
            'message' => "Request approved successfully"
        ]);
    }

    public function reject(Request $request) {
        $id = $request->id;
        $checkRequest = DistributorChannel::find($id);
        if(!empty($checkRequest)) {
            $checkRequest->status = 'rejected';
        }
        $checkRequest->save();

        return response()->json([
            'status' => true,
            'message' => "Request rejected successfully"
        ]);
    }

    public function view($id) {
        $distributor = DistributorChannel::find($id);
        if(empty($distributor)) {
            return redirect()->back();
        }
        return view('user::distributor_channel_detail', compact('distributor'));
    }

    public function transactionList(Request $request, $id) {
        $transactions = DistributorTransaction::where('distributor_id', $id);
        return DataTables::of($transactions)
        ->editColumn('type', function ($transaction) {
            if($transaction->type == 'deposit') {
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

    public function addTransaction(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'type' => 'required|in:deposit,withdrawal',
            ],
            [
                'amount.required' => 'Amount Is Required',
                'type.required' => 'Type Is Required',
                'type.in' => 'Type Is Invalid',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $distributor = DistributorChannel::find($id);
        if(empty($distributor)) {
            return response()->json([
                'status' => false,
                'message' => "Distributor not found"
            ]);
        }

        if($distributor->status != 'approved') {
            return response()->json([
                'status' => false,
                'message' => "Distributor not approved"
            ]);
        }

        $newAmount = $distributor->balance;
        if($request->type == 'deposit') {
            $newAmount = $newAmount + $request->amount;
        }
        else {
            if($request->amount > $newAmount) {
                return response()->json([
                    'status' => false,
                    'message' => "insufficient balance"
                ]);
            }
            $newAmount = $newAmount - $request->amount;
        }

        $distributor->balance = $newAmount;
        $distributor->save();

        $transaction = new DistributorTransaction;
        $transaction->distributor_id = $id;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->description = $request->description;
        $transaction->save();

        $data = [
            'balance' => $newAmount
        ];

        return response()->json([
            'status' => true,
            'message' => "Transaction added successfully",
            'data' => $data
        ]);
    }

    public function updateDistributor(Request $request, $id) {
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
                'referral_benefits' => 'required',
                'custom_plan_rate' => 'required',
                'start_up_plan_rate' => 'required',
                'status' => 'required',
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
                'referral_benefits.required' => 'Referral Benefits Is Required',
                'custom_plan_rate.required' => 'Custom plan rate Is Required',
                'start_up_plan_rate.required' => 'Start up plan rate Is Required',
                'status.required' => 'Status Is Required',
            ]
        );

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $distributor = DistributorChannel::find($id);
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
        $distributor->referral_benefits = $request->referral_benefits;
        $distributor->custom_plan_rate = $request->custom_plan_rate;
        $distributor->start_up_plan_rate = $request->start_up_plan_rate;
        $distributor->status = $request->status;
        $distributor->save();

        return response()->json([
            'status' => true,
            'message' => "Distributor added successfully",
            'data' => $distributor
        ]);
    }

}
