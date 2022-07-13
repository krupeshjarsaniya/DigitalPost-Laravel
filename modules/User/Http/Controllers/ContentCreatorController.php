<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContentCreator;
use DataTables;

class ContentCreatorController extends Controller
{
    public function index() {
        return view('user::contentCreator');
    }

    public function list() {
        $contentCreators = ContentCreator::select('*');
        return DataTables::of($contentCreators)
            ->addColumn('action', function ($contentCreator) {
                $button = "";
                if($contentCreator->status != 'APPROVED') {
                    $button .= '<button onclick="approveRequest(this)" class="btn btn-xs btn-success btn-edit mb-2 mr-2" data-id="'.$contentCreator->id.'">Approve</button>';
                }
                if($contentCreator->status != 'REJECTED') {
                    $button .= '<button onclick="rejectRequest(this)" class="btn btn-xs btn-danger btn-delet mb-2" data-id="'.$contentCreator->id.'">Reject</button>';
                }
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function approve(Request $request) {
        $id = $request->id;
        $checkRequest = ContentCreator::find($id);
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
        $checkRequest = ContentCreator::find($id);
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
