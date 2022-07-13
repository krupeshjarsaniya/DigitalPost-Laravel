<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Distributor;
use DataTables;

class DistributorController extends Controller
{
    public function index() {
        return view('user::distributor');
    }

    public function list() {
        $distributors = Distributor::select('*');
        return DataTables::of($distributors)
            ->addColumn('action', function ($distributor) {
                $button = "";
                if($distributor->status != 'APPROVED') {
                    $button .= '<button onclick="approveRequest(this)" class="btn btn-xs btn-success btn-edit mb-2 mr-2" data-id="'.$distributor->id.'">Approve</button>';
                }
                if($distributor->status != 'REJECTED') {
                    $button .= '<button onclick="rejectRequest(this)" class="btn btn-xs btn-danger btn-delet mb-2" data-id="'.$distributor->id.'">Reject</button>';
                }
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function approve(Request $request) {
        $id = $request->id;
        $checkRequest = Distributor::find($id);
        if(!empty($checkRequest)) {
            $checkRequest->status = 'APPROVED';
        }
        $checkRequest->save();

        return response()->json([
            'status' => true,
            'message' => "Request approved successfully"
        ]);
    }

    public function reject(Request $request) {
        $id = $request->id;
        $checkRequest = Distributor::find($id);
        if(!empty($checkRequest)) {
            $checkRequest->status = 'REJECTED';
        }
        $checkRequest->save();

        return response()->json([
            'status' => true,
            'message' => "Request rejected successfully"
        ]);
    }
}
