<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Validator;
use DataTables;
use App\User;
use App\UserComment;
use DB;
use Auth;
use Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ini_set('memory_limit', -1);
        $user = User::where('id', '!=', auth()->id())->where('user_role', '!=',0)->where('status','!=',2)->select('id','name','email','mobile','status', 'user_role')->orderBy('id','ASC')->get();
       
        if ($request->ajax())
        {
            return DataTables::of($user)
            ->addIndexColumn()
            ->editColumn('user_role',function($row) {
                $user_role = "";
                if($row->user_role == 1) {
                    $user_role = "Master Admin";
                }
                if($row->user_role == 2) {
                    $user_role = "Telecaller";
                }
                if($row->user_role == 3) {
                    $user_role = "Manager";
                }
                if($row->user_role == 4) {
                    $user_role = "Designer";
                }
                return $user_role;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm" id="viewdetail" onclick="viewDetail('.$row->id.')">View Detail</button>';
                    if($row->status == 0){
                        $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="user-block" onclick="blockUser('.$row->id.')">Block</button>';
                    } else {
                         $btn .= '&nbsp;&nbsp;<button class="btn btn-success btn-sm" id="user-unblock" onclick="unblockUser('.$row->id.')">Unblock</button>';
                    }
                $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeUser" onclick="removeUser('.$row->id.')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getUsersList(Request $request)
    {
        $status = $request->status ? $request->status : 0;
        ini_set('memory_limit', -1);
        $date = $request->date ? $request->date : null;
        if($date != null) {
            $user = User::where('id', '!=', auth()->id())->where('user_role',0)->where('tel_status', $status)->where('tel_user', '!=', 0)->where('follow_up_date', $date)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user','follow_up_date')->orderBy('follow_up_date','ASC');
            if(Auth::user()->user_role == 2)
            {
                 $user = User::where('id', '!=', auth()->id())->where('tel_user', auth()->id())->where('user_role',0)->where('tel_status',$status)->where('follow_up_date', $date)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user','follow_up_date')->orderBy('follow_up_date','ASC');
            }
        }
        else {
            $user = User::where('id', '!=', auth()->id())->where('user_role',0)->where('tel_status', $status)->where('tel_user', '!=', 0)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user','follow_up_date')->orderBy('follow_up_date','ASC');
            if(Auth::user()->user_role == 2)
            {
                 $user = User::where('id', '!=', auth()->id())->where('tel_user', auth()->id())->where('user_role',0)->where('tel_status',$status)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user','follow_up_date')->orderBy('follow_up_date','ASC');
            }
        }

        $usersList = User::select('id','name','status')->where('status', '!=', 2)->where('user_role',2)->orderBy('name','ASC')->get();
        if ($request->ajax())
        {
            return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm" id="viewdetail" onclick="viewDetail('.$row->id.')">View Detail</button>';
                return $btn;
            })
            ->addColumn('userlist',function($row) use($usersList) {
                if (Auth::user()->user_role == 1) 
                {
                    
                   $sel ='<select class="form-control" data-id="'.$row->id.'" id="tel_user" onchange="ChangeUser(this)">';
                    $sel .= '<option value="0" selected="selected" disabled>Select User</option>';
                    foreach ($usersList as $key => $value) 
                    {
                       if ($row->tel_user == $value->id) 
                        {
                            $sel .= '<option selected="selected" value="'.$value->id.'">'.$value->name.'</option>';
                        }
                        else
                        {
                            $sel .= '<option value="'.$value->id.'">'.$value->name.'</option>';
                        } 
                        
                    }
                    $sel .= '</select>';

                    return $sel;
                }
                else
                {
                    $sel = "";
                    return $sel;
                }
            })
            ->addColumn('commentlist',function($row) {

                $comment = DB::table('user_comment')->where('is_delete',0)->where('user_id',$row->id)->orderBy('id', 'desc')->first();
                if (empty($comment)) 
                {
                    $comment = '';
                    return $comment;
                }
                return $comment->comment;

            })
            ->editColumn('follow_up_date',function($row) {
                $date = "";
                if($row->follow_up_date )
                {

                    $date = date('d-m-Y',strtotime($row->follow_up_date));
                }
                return $date;

            })

            ->rawColumns(['action','userlist','commentlist'])
            ->make(true);
        }
    }
    
    public function HoldgetUsersList(Request $request)
    {
        ini_set('memory_limit', -1);
        $user = User::where('id', '!=', auth()->id())->where('user_role',0)->where('tel_status',1)->where('tel_user', '!=', 0)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user','follow_up_date')->orderBy('follow_up_date','ASC');
       if(Auth::user()->user_role == 2)
        {
             $user = User::where('id', '!=', auth()->id())->where('tel_user', auth()->id())->where('user_role',0)->where('tel_status',1)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user')->orderBy('follow_up_date','ASC');
        }
        $usersList = User::select('id','name','status')->where('status', '!=', 2)->where('user_role',2)->orderBy('name','ASC')->get();

        if ($request->ajax())
        {
            return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm" id="viewdetail" onclick="viewDetail('.$row->id.')">View Detail</button>';
                return $btn;
            })
            ->addColumn('userlist',function($row) use($usersList) {
                if (Auth::user()->user_role == 1) 
                {
                    
                   $sel ='<select class="form-control" data-id="'.$row->id.'" id="tel_user" onchange="ChangeUser(this)">';
                    $sel .= '<option value="0" selected="selected" disabled>Select User</option>';
                    foreach ($usersList as $key => $value) 
                    {
                        if ($row->tel_user == $value->id) 
                        {
                            $sel .= '<option selected="selected" value="'.$value->id.'">'.$value->name.'</option>';
                        }
                        else
                        {
                            $sel .= '<option value="'.$value->id.'">'.$value->name.'</option>';
                        } 
                        
                    }
                    $sel .= '</select>';

                    return $sel;
                }
                else
                {
                    $sel = "";
                    return $sel;
                }
            })
            ->addColumn('commentlist',function($row) {

            $comment = DB::table('user_comment')->where('is_delete',0)->where('user_id',$row->id)->orderBy('id', 'desc')->first();
            if (empty($comment)) 
            {
                $comment = '';
                return $comment;
            }
            return $comment->comment;

            })
            ->editColumn('follow_up_date',function($row) {

                $date = "";
                if($row->follow_up_date )
                {

                    $date = date('d-m-Y',strtotime($row->follow_up_date));
                }
                return $date;

            })

        
            ->rawColumns(['action','commentlist','userlist'])
            ->make(true);
        }
    }


    public function CompletegetUsersList(Request $request)
    {
        ini_set('memory_limit', -1);
        $user = User::where('id', '!=', auth()->id())->where('user_role',0)->where('tel_status',2)->where('tel_user', '!=', 0)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user','follow_up_date')->orderBy('follow_up_date','ASC');
       if(Auth::user()->user_role == 2)
        {
             $user = User::where('id', '!=', auth()->id())->where('tel_user', auth()->id())->where('user_role',0)->where('tel_status',2)->where('status','!=',2)->select('id','name','email','mobile','status','tel_user')->orderBy('follow_up_date','ASC');
        }
        $usersList = User::select('id','name','status')->where('status', '!=', 2)->where('user_role',2)->orderBy('name','ASC')->get();
        if ($request->ajax())
        {
            return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm" id="viewdetail" onclick="viewDetail('.$row->id.')">View Detail</button>';
                return $btn;
            })
            ->addColumn('userlist',function($row) use($usersList) {
                if (Auth::user()->user_role == 1) 
                {
                    
                   $sel ='<select class="form-control" data-id="'.$row->id.'" id="tel_user" onchange="ChangeUser(this)">';
                    $sel .= '<option value="0" selected="selected" disabled>Select User</option>';
                    foreach ($usersList as $key => $value) 
                    {
                       if ($row->tel_user == $value->id) 
                        {
                            $sel .= '<option selected="selected" value="'.$value->id.'">'.$value->name.'</option>';
                        }
                        else
                        {
                            $sel .= '<option value="'.$value->id.'">'.$value->name.'</option>';
                        } 
                        
                    }
                    $sel .= '</select>';

                    return $sel;
                }
                else
                {
                    $sel = "";
                    return $sel;
                }
            })
            ->addColumn('commentlist',function($row) {

                $comment = DB::table('user_comment')->where('is_delete',0)->where('user_id',$row->id)->orderBy('id', 'desc')->first();
                if (empty($comment)) 
                {
                    $comment = '';
                    return $comment;
                }
                return $comment->comment;
                
            })
            ->editColumn('follow_up_date',function($row) {

                $date = "";
                if($row->follow_up_date )
                {

                    $date = date('d-m-Y',strtotime($row->follow_up_date));
                }
                return $date;

            })
            ->rawColumns(['action','commentlist','userlist'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mobile = 000;

        if($request->userid == "")
        {

            $validator = Validator::make($request->all(), [
                    'user_role' => 'required',      
                    'fullname' => 'required',      
                    'email' => 'required|email|unique:users',      
                    /*'mobile' => 'required|unique:users',*/      
                    /*'userimage' => 'required', */     
                    'userpassword' => 'required|min:8',      
                    'con_password' => 'same:userpassword',      
                    
                          
                ],
                [
                    'user_role.required' => 'User Role Required',
                    'fullname.required' => 'Name Required',
                    'email.required' => 'Email Required',
                    'email.email' => 'Email Not Fotmated',
                    /*'mobile.required' => 'Phone Required',*/
                    /*'userimage.required' => 'Image Required',*/
                    'userpassword.required' => 'Password Required',
                    'userpassword.min' => 'Password Length Minimum 8',
                    'con_password.same' => 'Password or Conform Password Not Match',
                ]
            );

            if ($validator->fails()) 
            {  
                $error=json_decode($validator->errors());          

                return response()->json(['status' => 401,'error1' => $error]);
                exit();

            }


            /*$image = $request->userimage;
            $filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('admin/images'), $filename);
            $path = '/public/admin/images/'.$filename;*/

            $insert = new User;
            $insert->name = $request->fullname; 
            $insert->email = $request->email; 
            /*$insert->image = $path; */
            $insert->user_role = $request->user_role; 
            $insert->mobile = $mobile; 
            $insert->password = Hash::make($request->userpassword);
            $insert->save();
        }
        else
        {
           $validator = Validator::make($request->all(), [
                    'fullname' => 'required',      
                    'user_role' => 'required',      
                    'email' => 'required|email',      
                    /*'mobile' => 'required',*/ 
                    'con_password' => 'same:userpassword',      
                    
                          
                ],
                [
                    'fullname.required' => 'Name Required',
                    'user_role.required' => 'User Role Required',
                    'email.required' => 'Email Required',
                    'email.email' => 'Email Not Fotmated',
                    /*'mobile.required' => 'Phone Required',*/
                    'con_password.same' => 'Password or Conform Password Not Match',
                    
                ]
            );

            if ($validator->fails()) 
            {  
                $error=json_decode($validator->errors());          

                return response()->json(['status' => 401,'error1' => $error]);
                exit();

            } 

            $user = User::where('id', '!=', $request->userid)->where('email',$request->email)->first();

            if (!empty($user)) 
            {
                $error=['email' => 'Email already exists'];
                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }
            /*$user2 = User::where('id', '!=', $request->userid)->where('mobile',$request->mobile)->first();

            if (!empty($user2)) 
            {
                $error=['mobile' => 'Mobile already exists'];
                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }*/
            if(strlen($request->userpassword) < 8 || empty($request->userpassword)) {
                $error=['userpassword' => 'Password Length Minimum 8'];
                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }
            if(!empty($request->userpassword)) {
                $password = Hash::make($request->userpassword);
                User::where('id',$request->userid)->update([
                        'name' => $request->fullname,
                        'email' => $request->email,
                        'user_role' => $request->user_role,
                        'mobile' => $mobile,
                        'password' => $password,
                    ]);
            }
            else {
                User::where('id',$request->userid)->update([
                        'name' => $request->fullname,
                        'email' => $request->email,
                        'user_role' => $request->user_role,
                        'mobile' => $mobile,
                    ]);
            }
        }

        return response()->json(['status' => 1,'data' => "" ]);

    }

    public function BlockUser(Request $request)
    {
        $user_id = $request->id;
        User::where('id',$user_id)->update(['status'=> 1]);

        return response()->json(['status'=>1,'data'=>""]);
    }

    public function UnBlockUser(Request $request)
    {
        $user_id = $request->id;
        User::where('id',$user_id)->update(['status'=> 0]);

        return response()->json(['status'=>1,'data'=>""]);
    }


    public function ChangeStatus(Request $request)
    {
        $id = $request->id;
        //dd($request);
        User::where('id',$id)->update([
                    'tel_status' => $request->tel_status,
                ]);
        return response()->json(['status'=>1,'data'=>""]);
    }

    public function ChangeUser(Request $request)
    {
        $id = $request->id;
        //dd($request);
        User::where('id',$id)->update([
                    'tel_user' => $request->tel_user,
                ]);
        return response()->json(['status'=>1,'data'=>""]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AddUserComment(Request $request)
    {
        $insert_comment = New UserComment;
        $insert_comment->user_id = $request->id;
        $insert_comment->tel_user_id = auth()->user()->id;
        $insert_comment->comment = $request->comment;
        $insert_comment->save();

        $update = User::find($request->id);
        $update->follow_up_date = $request->date ? $request->date : null;
        $update->save();

    }

    public function getComment(Request $request,$id)
    {

        
        $comment = UserComment::where('user_id',$id)->where('is_delete',0)->orderBy('created_at','DESC')->get();
       
        if ($request->ajax())
        {
            return DataTables::of($comment)
            ->addIndexColumn()
            /*->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm" id="viewdetail" onclick="viewDetail('.$row->id.')">View Detail</button>';
                    if($row->status == 0){
                        $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="user-block" onclick="blockUser('.$row->id.')">Block</button>';
                    } else {
                         $btn .= '&nbsp;&nbsp;<button class="btn btn-success btn-sm" id="user-unblock" onclick="unblockUser('.$row->id.')">Unblock</button>';
                    }
                $btn .= '&nbsp;&nbsp;<button class="btn btn-danger btn-sm" id="removeUser" onclick="removeUser('.$row->id.')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })*/
            ->addColumn('date',function($row) {
               $date = date("d-m-Y", strtotime($row->created_at));
                return $date;
            })
            ->rawColumns(['date'])
            ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
         $user = User::find($request->id);

        return response()->json(['status'=>1,'data'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id = $request->id;
        User::where('id',$user_id)->update(['status'=> 2]);

        return response()->json(['status'=>1,'data'=>""]);
    }
}
