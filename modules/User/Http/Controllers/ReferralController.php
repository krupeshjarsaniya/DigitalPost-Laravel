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
use App\WithdrawRequest;
use App\User;
use App\Helper;
use App\PaymentDetail;
class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::withdraw-request');
    }

    public function getPendingRequest(Request $request)
    {
        $WithdrawRequests = WithdrawRequest::where('withdraw_request.status', 'Pending')->with('user');
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($WithdrawRequests)
            ->addIndexColumn()
            ->editColumn('created_at', function($row) {
                return Carbon::parse($row->created_at)->format('d-m-Y H:i:s');
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm" data-id="'.$row->id.'" onclick="completePayment(this)">Create Payment</button';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getCompletedRequest(Request $request)
    {
        $WithdrawRequests = WithdrawRequest::where('withdraw_request.status', 'Done')->with('user');
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($WithdrawRequests)
            ->editColumn('created_at', function($row) {
                return Carbon::parse($row->created_at)->format('d-m-Y H:i:s');
            })
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function completePayment(Request $request) {
        $id = $request->id;
        $checkRequest = WithdrawRequest::find($id);
        if(empty($checkRequest) || $checkRequest->status == 'Done') {
            return response()->json(['status'=>false,'message' => 'Withdraw Request not found']);
        }
        $paymentDetail = PaymentDetail::where('user_id', $checkRequest->user_id)->first();
        if(empty($paymentDetail)) {
            return response()->json(['status'=>false,'message' => 'Payment Detail not found']);
        }
        $paymentData = Helper::payoutByFundAccount($paymentDetail->fund_id, $checkRequest->amount);
        if(!$paymentData['status']) {
            return response()->json(['status' => false,'message'=>$data['error']]);
        }
        $checkRequest->payment_id = $paymentData['payment_id'];
        $checkRequest->status = 'Done';
        $checkRequest->save();
        return response()->json(['status'=>true,'message' => 'Withdraw Request Completed Successfully']);
    }

}
