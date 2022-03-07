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
use App\User;

class TelecallerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $telecallers = User::where('user_role', 2)->get();
        return view('user::telecaller', ['telecallers' => $telecallers]);
    }

    public function getTelecallerList(Request $request)
    {
        $telecallers = User::where('status', 0)->where('user_role', 2);
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($telecallers)
            ->editColumn('assigned_users',function($row) {
                $assigned_users = User::where('status', 0)->where('tel_user', $row->id)->count();
                return $assigned_users;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="assigneUser(this)"><i class="fa fa-eye"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getAssignedUser(Request $request)
    {
        if($request->change_status != "")
        {

            $users = User::where('status', 0)->where('tel_user', $request->id)->where('tel_status',$request->change_status);
        }
        else{

            $users = User::where('status', 0)->where('tel_user', $request->id);
        }
        
        if ($request->ajax())
        {
            
            return DataTables::of($users)
            ->editColumn('follow_up_date',function($row) {
                $date = "";
                if($row->follow_up_date) {
                    $date = Carbon::parse($row->follow_up_date)->format('d-m-Y');
                }
                return $date;
            })
            ->addColumn('status',function($row) {
                $btn = "";
                if($row->tel_status == 0)
                {
                    $btn = 'New Lead';
                }
                else if($row->tel_status == 1)
                {
                    $btn = 'Hold';
                }
                else if($row->tel_status == 2)
                {
                    $btn = 'Intersted but not now';
                }
                else if($row->tel_status == 3)
                {
                    $btn = 'Payment Details shared';
                }
                else if($row->tel_status == 4)
                {
                    $btn = 'Call Back';
                }
                else if($row->tel_status == 5)
                {
                    $btn = 'Trail Request';
                }
                else if($row->tel_status == 6)
                {
                    $btn = 'Not Intersted';
                }
                else if($row->tel_status == 7)
                {
                    $btn = 'Complete';
                }

                return $btn;
            })
            ->make(true);
        }
    }

    public function getUserByDate(Request $request) {
        $date = $request->date;
        $total_users = User::where('status', 0)->where('tel_user', 0)->where('user_role', 0)->whereDate('created_at', $date)->count();
        if(empty($request->limit)) {
            $users = User::where('status', 0)->where('tel_user', 0)->where('user_role', 0)->whereDate('created_at', $date)->get();
        }
        else {
            $users = User::where('status', 0)->where('tel_user', 0)->where('user_role', 0)->whereDate('created_at', $date)->limit($request->limit)->get();
        }
        return response()->json(['status' => 1,'users' => $users, 'count' => $total_users, 'message' => 'User found' ]);
    }

    public function assigneUserAdd(Request $request) {
        $validator = Validator::make($request->all(), [
            'users' => 'required',      
            'telecaller_id' => 'required',      
            'follow_up_date' => 'required',      
        ],
        [
            'users.required'=> "User Is Required",
            'telecaller_id.required'=> "Telecaller Is Required",
            'follow_up_date.required'=> "Date Is Required",
        ]);

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $users = User::whereIn('id', $request->users)->update(['tel_user'=>$request->telecaller_id, 'follow_up_date' => $request->follow_up_date]);

        return response()->json(['status' => 1,'data' => "", 'message' => 'Telecaller added' ]);
    }

    public function transferUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'from_telecaller' => 'required',      
            'to_telecaller' => 'required',      
        ],
        [
            'from_telecaller.required'=> "Select Telecaller",
            'to_telecaller.required'=> "Select Telecaller",
        ]);

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        if($request->from_telecaller == $request->to_telecaller) {
            return response()->json(['status' => 0,'data' => "", 'message' => 'Please select different telecaller' ]);
        }

        $users = User::where('tel_user', $request->from_telecaller)->update(['tel_user'=>$request->to_telecaller]);

        return response()->json(['status' => 1,'data' => "", 'message' => 'Telecaller changes' ]);
    }

}
