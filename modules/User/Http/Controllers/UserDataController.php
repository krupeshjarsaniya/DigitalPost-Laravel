<?php

namespace Modules\User\Http\Controllers;

use App\BGCreditPlan;
use App\BGCreditPlanHistory;
use App\User;
use App\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Plan;
use App\Photos;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\PoliticalBusiness;
use App\CustomFrame;
use App\UserReferral;
use App\PushNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class UserDataController extends Controller
{

    public function index(Request $request)
    {
        ini_set('memory_limit', -1);
       // $user = User::all();
        $user = User::where('id', '!=', auth()->id())->where('status','!=',2)->select('id', 'status','name','email','mobile','user_credit', 'bg_credit');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('remaining_referral_amount',function($row) {
                $remaining_referral_amount = 0;
                $referral_data = UserReferral::where('user_id', $row->id)->first();
                if(!empty($referral_data)) {
                    $remaining_referral_amount = $referral_data->current_balance;
                }
                return $remaining_referral_amount;
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
        //$user = DB::table('photos')->get();
        // return view('user::userlist');
    }

    public function customFrame() {
        return view('user::customFrame');
    }

    public function getCustomFrameData(Request $request) {
        $custom_frame = CustomFrame::where('custom_frams.designer_id', '=', auth()->id())->where('custom_frams.business_type', 1)->where('custom_frams.status', 'Pending')->leftJoin('business', 'business.busi_id', '=', 'custom_frams.business_id')->leftJoin('users', 'users.id', '=', 'business.user_id')->select('custom_frams.*', 'users.name', 'users.mobile','business.busi_name', 'users.country_code')->orderBy('custom_frams.priority','DESC');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($custom_frame)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('users.name', 'LIKE', "%$search%")
                        ->orWhere('business.busi_name', 'LIKE', "%$search%")
                        ->orWhere('users.mobile', 'LIKE', "%$search%");
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('user',function($row) {
                $username = "";
                $business = Business::where('busi_id', $row->business_id)->first();

                if($business) {
                    $user = User::find($business->user_id);
                    $username = $user->name;
                    $username .= "<br /><a target='_blank' href='https://api.whatsapp.com/send?phone=".$user->country_code.$user->mobile."'>" . $user->mobile.'</a>';
                }
                return $username;
            })
            ->addColumn('business',function($row) {
                $business_name = "";
                $business = Business::where('busi_id', $row->business_id)->first();
                if($business) {
                    $business_name = $business->busi_name;
                }
                return $business_name;
            })
            ->editColumn('priority',function($row) {
                $priority = "";
                if($row->priority == 0) {
                    $priority = "<b>Normal</b>";
                }
                else{
                    $priority = "<b>High</b>";
                }
                $priority .= "<br />" . \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i');
                return $priority;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm mr-3" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="addFrame(this,'.$row->id.')">Add Frame</button>';
                $btn .= '<button class="btn btn-info btn-sm" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="viewBusinessDetail(this,'.$row->id.')">View Business Detail</button>';
                return $btn;
            })
            ->rawColumns(['action', 'user', 'priority'])
            ->make(true);
        }
    }

    public function getCustomFrameDataPolitical(Request $request) {
        $custom_frame = CustomFrame::where('custom_frams.designer_id', '=', auth()->id())->where('custom_frams.business_type', 2)->where('custom_frams.status', 'Pending')->leftJoin('political_business', 'political_business.pb_id', '=', 'custom_frams.business_id')->leftJoin('users', 'users.id', '=', 'political_business.user_id')->select('custom_frams.*', 'users.name', 'users.mobile','political_business.pb_name','users.country_code')->orderBy('custom_frams.priority','DESC');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($custom_frame)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('users.name', 'LIKE', "%$search%")
                        ->orWhere('political_business.pb_name', 'LIKE', "%$search%")
                        ->orWhere('users.mobile', 'LIKE', "%$search%");
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('user',function($row) {
                $username = "";
                $business = PoliticalBusiness::where('pb_id', $row->business_id)->first();
                if($business) {
                    $user = User::find($business->user_id);
                    $username = $user->name;
                    $username .= "<br /><a target='_blank' href='https://api.whatsapp.com/send?phone=".$user->country_code.$user->mobile."'>" . $user->mobile.'</a>';
                }
                return $username;
            })
            ->addColumn('business',function($row) {
                $business_name = "";
                $business = PoliticalBusiness::where('pb_id', $row->business_id)->first();
                if($business) {
                    $business_name = $business->pb_name;
                }
                return $business_name;
            })
            ->editColumn('priority',function($row) {
                $priority = "";
                if($row->priority == 0) {
                    $priority = "<b>Normal</b>";
                }
                else{
                    $priority = "<b>High</b>";
                }
                $priority .= "<br />" . \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i');
                return $priority;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm mr-3" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="addFrame(this,'.$row->id.')">Add Frame</button>';
                $btn .= '<button class="btn btn-info btn-sm" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="viewBusinessDetail(this,'.$row->id.')">View Business Detail</button>';
                return $btn;
            })
            ->rawColumns(['action', 'user', 'priority'])
            ->make(true);
        }
    }

    public function getCustomFrameCompletedData(Request $request) {
        $custom_frame = CustomFrame::where('custom_frams.designer_id', '=', auth()->id())->where('custom_frams.business_type', 1)->where('custom_frams.status', 'Completed')->leftJoin('business', 'business.busi_id', '=', 'custom_frams.business_id')->leftJoin('users', 'users.id', '=', 'business.user_id')->select('custom_frams.*', 'users.name', 'users.mobile','business.busi_name')->orderBy('custom_frams.priority','DESC');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($custom_frame)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('users.name', 'LIKE', "%$search%")
                        ->orWhere('business.busi_name', 'LIKE', "%$search%")
                        ->orWhere('users.mobile', 'LIKE', "%$search%");
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('user',function($row) {
                $username = "";
                $business = Business::where('busi_id', $row->business_id)->first();
                if($business) {
                    $user = User::find($business->user_id);
                    $username = $user->name;
                    $username .= "<br /><a target='_blank' href='https://api.whatsapp.com/send?phone=".$user->country_code.$user->mobile."'>" . $user->mobile.'</a>';
                }
                return $username;
            })
            ->addColumn('business',function($row) {
                $business_name = "";
                $business = Business::where('busi_id', $row->business_id)->first();
                if($business) {
                    $business_name = $business->busi_name;
                }
                return $business_name;
            })
            ->editColumn('priority',function($row) {
                $priority = "";
                if($row->priority == 0) {
                    $priority = "<b>Normal</b>";
                }
                else{
                    $priority = "<b>High</b>";
                }
                $priority .= "<br />" . \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i');
                return $priority;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm mr-3" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="addFrame(this,'.$row->id.')">Add Frame</button>';
                $btn .= '<button class="btn btn-info btn-sm" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="viewBusinessDetail(this,'.$row->id.')">View Business Detail</button>';
                return $btn;
            })
            ->rawColumns(['action', 'user', 'priority'])
            ->make(true);
        }
    }

    public function getCustomFrameCompletedDataPolitical(Request $request) {
        $custom_frame = CustomFrame::where('custom_frams.designer_id', '=', auth()->id())->where('custom_frams.business_type', 2)->where('custom_frams.status', 'Completed')->leftJoin('political_business', 'political_business.pb_id', '=', 'custom_frams.business_id')->leftJoin('users', 'users.id', '=', 'political_business.user_id')->select('custom_frams.*', 'users.name', 'users.mobile','political_business.pb_name')->orderBy('custom_frams.priority','DESC');

        if ($request->ajax())
        {
            # code...
            return DataTables::of($custom_frame)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('users.name', 'LIKE', "%$search%")
                        ->orWhere('political_business.pb_name', 'LIKE', "%$search%")
                        ->orWhere('users.mobile', 'LIKE', "%$search%");
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('user',function($row) {
                $username = "";
                $business = PoliticalBusiness::where('pb_id', $row->business_id)->first();
                if($business) {
                    $user = User::find($business->user_id);
                    $username = $user->name;
                    $username .= "<br /><a target='_blank' href='https://api.whatsapp.com/send?phone=".$user->country_code.$user->mobile."'>" . $user->mobile.'</a>';
                }
                return $username;
            })
            ->addColumn('business',function($row) {
                $business_name = "";
                $business = PoliticalBusiness::where('pb_id', $row->business_id)->first();
                if($business) {
                    $business_name = $business->pb_name;
                }
                return $business_name;
            })
            ->editColumn('priority',function($row) {
                $priority = "";
                if($row->priority == 0) {
                    $priority = "<b>Normal</b>";
                }
                else{
                    $priority = "<b>High</b>";
                }
                $priority .= "<br />" . \Carbon\Carbon::parse($row->created_at)->format('Y-m-d H:i');
                return $priority;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-info btn-sm mr-3" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="addFrame(this,'.$row->id.')">Add Frame</button>';
                $btn .= '<button class="btn btn-info btn-sm" data-type="'.$row->business_type.'" data-id="'.$row->business_id.'" onclick="viewBusinessDetail(this,'.$row->id.')">View Business Detail</button>';
                return $btn;
            })
            ->rawColumns(['action', 'user', 'priority'])
            ->make(true);
        }
    }

    public function add_custom_frame(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'business_type' => 'required',
            'business_id' => 'required',
            'files' => 'required',
        ],
        [
            'id.required'=> "Something goes wrong",
            'business_type.required'=> "Something goes wrong",
            'business_id.required'=> "Something goes wrong",
            'files.required'=> "Select files",
        ]);

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        $checkFrame = CustomFrame::where('id', $request->id)->where('business_type', $request->business_type)->where('business_id', $request->business_id)->first();
        if(empty($checkFrame)) {
            $error=['files'=> "Something goes wrong!"];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        // if($checkFrame->quantity <= $checkFrame->completed) {
        //     $error=['files'=> "There is no pening frames!"];
        //     $checkFrame->status = 'Completed';
        //     $checkFrame->save();
        //     return response()->json(['status' => 401,'error1' => $error]);
        //     exit();
        // }
        $completed = 0;
        $userid = 0;
        $business_id = $request->business_id;
        $business_type = $request->business_type;
        if($business_type == 1) {
            $business = Business::where('busi_id', $business_id)->where('busi_delete', 0)->first();
        }
        else {
            $business = PoliticalBusiness::where('pb_id', $business_id)->where('pb_is_deleted', 0)->first();
        }
        if(empty($business)) {
            $error=['files'=> "Business Not found!"];
            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        $userid = $business->user_id;
        foreach ($request->file('files') as $key => $image) {
            $image = (isset($image)) ? $image : 'undefined';

            if($image != 'undefined'){
               $path = $this->multipleUploadFile($image,'frame-img');
            } else {
               $path = '';
            }

            DB::table('user_frames')->insert(
                ['frame_url' => $path, 'user_id' => $userid, 'business_id' => $business_id, 'business_type' => $business_type, 'custom_frame_id' => $checkFrame->id, 'designer_id'=>  Auth::user()->id]
            );
            $completed++;
        }
        $completed = $checkFrame->completed + $completed;
        $checkFrame->completed = $completed;
        if($checkFrame->quantity <= $completed) {
            $checkFrame->status = 'Completed';
        }
        $checkFrame->save();
        return response()->json(['status'=>1,'message'=>"Frame Added Succesfully"]);
    }

    public function getBusiness(Request $request) {
        $business_id = $request->business_id;
        $business_type = $request->business_type;
        if($business_type == 1) {
            $business = Business::where('busi_id', $business_id)->first();
        }
        else {
            $business = PoliticalBusiness::where('pb_id', $business_id)->first();
        }
        if(empty($business)) {
            return response()->json(['status'=>false,'data'=>""]);
        }
        $plan_or_name = "";
        $purchase_plan = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', $business_type)->first();
        if(!empty($purchase_plan)) {
            $plan = Plan::where('plan_id', $purchase_plan->purc_plan_id)->first();
            if(!empty($plan)) {
                $plan_or_name = $plan->plan_or_name;
            }
        }
        $business->plan = $plan_or_name;
        return response()->json(['status'=>true,'data'=>$business]);
    }

    public function getCustomFrames(Request $request) {
        $business_id = $request->business_id;
        $business_type = $request->business_type;
        $frames = DB::table('user_frames')->where('business_id', $business_id)->where('business_type', $business_type)->where('is_deleted', 0)->orderBy('user_frames_id', 'DESC')->get();
        foreach ($frames as &$frame) {
            $frame->frame_url = Storage::url($frame->frame_url);
        }
        $frameData = (string)View::make('user::viewFramesModal')->with('frames',$frames);
        return response()->json(['status'=>true,'data'=>$frames, 'frames'=> $frameData]);
    }

    public function editBusinessFromFrame(Request $request) {
        $business_id = $request->edit_business_id;
        $business_type = $request->edit_business_type;
        $temp = $request->all();
        $logo = (isset($temp['logo'])) ? $temp['logo'] : 'undefined';
        $watermark = (isset($temp['watermark'])) ? $temp['watermark'] : 'undefined';
        $leftimage = (isset($temp['leftimage'])) ? $temp['leftimage'] : 'undefined';
        $rightimage = (isset($temp['rightimage'])) ? $temp['rightimage'] : 'undefined';
        if($business_type == 1) {
            if($logo != 'undefined'){
               $logo_path = $this->uploadFile($request, null, 'logo', 'business-img');
                Business::where('busi_id',$business_id)->update([
                    'busi_logo' => $logo_path,
                ]);
            }
            if($watermark != 'undefined'){
               $watermark_path = $this->uploadFile($request, null, 'watermark', 'business-img');
               Business::where('busi_id',$business_id)->update([
                    'watermark_image' => $watermark_path,
                ]);
            }
        }
        else {
            if($logo != 'undefined'){
               $logo_path = $this->uploadFile($request, null, 'logo', 'political-business-img');
               PoliticalBusiness::where('pb_id','=',$business_id)->update([
                'pb_party_logo' => $logo_path,
                ]);
               $logo_path;
            }
            if($watermark != 'undefined'){
               $watermark_path = $this->uploadFile($request, null, 'watermark', 'political-business-img');
               PoliticalBusiness::where('pb_id','=',$business_id)->update([
                'pb_watermark' => $watermark_path,
                ]);
            }
            if($leftimage != 'undefined'){
               $leftimage_path = $this->uploadFile($request, null, 'leftimage', 'political-business-img');
               PoliticalBusiness::where('pb_id','=',$business_id)->update([
                'pb_left_image' => $leftimage_path,
                ]);
            }
            if($rightimage != 'undefined'){
               $rightimage_path = $this->uploadFile($request, null, 'rightimage', 'political-business-img');
               PoliticalBusiness::where('pb_id','=',$business_id)->update([
                'pb_right_image' => $rightimage_path,
                ]);
            }
        }
        return response()->json(['status'=>1, 'message'=> "Business updated successfully",'data'=>[]]);
    }

    public function blockuser(Request $request)
    {

        $user_id = $request->id;
        User::where('id',$user_id)->update(['status'=>1]);
        DB::table('user_device')->where('user_id', $user_id)->update(['remember_token' => ""]);

        return response()->json(['status'=>1,'data'=>""]);
    }

    public function unblockuser(Request $request)
    {
        $user_id = $request->id;
        User::where('id',$user_id)->update(['status'=>0]);

        return response()->json(['status'=>1,'data'=>""]);
    }

    public function removeUser(Request $request)
    {
        $user_id = $request->id;
        User::where('id',$user_id)->update(['status'=>2]);

        return response()->json(['status'=>1,'data'=>""]);
    }

    public function viewUserDetail(Request $request){
         $user_id = $request->id;

         $user_details = User::where('id','=',$user_id)->first();
         $user_details->mobile = "<a target='_blank' href='https://api.whatsapp.com/send?phone=".$user_details->country_code.$user_details->mobile."'>" . $user_details->mobile.'</a>';
        //  $business_detail = Business::where('user_id','=',$user_id)->get();

         $business_detail = DB::table('business')->where('busi_delete','=','0')->where('user_id','=',$user_id)->leftJoin('purchase_plan','business.busi_id','=','purchase_plan.purc_business_id')->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('business.busi_id','business.busi_name','business.busi_email','business.busi_address','business.busi_mobile', 'business.busi_mobile_second','business.busi_logo','business.watermark_image','business.busi_logo_dark','business.watermark_image_dark','business.busi_website','purchase_plan.purc_plan_id','purchase_plan.purc_order_id','purchase_plan.purc_end_date','plan.plan_or_name')->get()->toArray();
         $business_data = array();
         foreach($business_detail as $business) {
            $checkDesigner = CustomFrame::where('business_id', $business->busi_id)->where('business_type', 1)->where('status', 'Pending')->first();
            if($checkDesigner) {
                $business->is_designer = true;
            }
            array_push($business_data, $business);
         }
        $frameList = DB::table('user_frames')->where('user_frames.user_id','=',$user_id)->where('user_frames.is_deleted','=',0)->where('user_frames.business_type','=',1)->leftJoin('business','user_frames.business_id','=','business.busi_id')->select('business.busi_id','business.busi_name','user_frames.frame_url', 'user_frames.user_frames_id')->get();

        // foreach ($frameList as &$frame) {
        //     $frame->frame_url = $frame->frame_url;
        // }

        $plan_history = BGCreditPlanHistory::where('user_id','=',$user_id)->with('plan')->orderBy('created_at','desc')->get();

        $business_category = DB::table('business_category')->where('is_delete',0)->get();


        return response()->json([
            'status'=>true,
            'user_detail'=>$user_details,
            'business_detail'=>$business_data,
            'frameList' => $frameList,
            'auth'=> Auth::user()->user_role,
            'business_category'=>$business_category,
            'plan_history'=>$plan_history
        ]);
    }

    function addDesigner(Request $request) {
        $validator = Validator::make($request->all(), [
            'designer' => 'required',
            'priority' => 'required',
            'quantity' => 'required',
            'business_id' => 'required',
            'business_type' => 'required',
        ],
        [
            'designer.required'=> "Select Designer",
            'priority.required'=> "Select Priority",
            'quantity.required'=> "Add Quantity",
            'business_id.required'=> "Select Business",
            'business_type.required'=> "Select Business Type",
        ]);

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();

        }
        $customFrame = CustomFrame::where('business_id', $request->business_id)->where('business_type', $request->business_type)->where('status', 'Pending')->first();
        if(empty($customFrame)) {
            $customFrame = new CustomFrame;
        }
        $customFrame->business_id = $request->business_id;
        $customFrame->quantity = $request->quantity;
        $customFrame->remark = $request->remark;
        $customFrame->designer_id = $request->designer;
        $customFrame->business_type = $request->business_type;
        $customFrame->priority = $request->priority;
        $customFrame->save();
        return response()->json(['status'=>true,'data'=>$customFrame]);
    }

    function getRefUserList(Request $request){
        $user_id = $request->id;
        $user_details = User::where('id','=',$user_id)->first();
        $user_list = array();
        if(!is_null($user_details->ref_users)){
            $refferal_users = unserialize($user_details->ref_users);
            if(!empty($refferal_users)){
                foreach($refferal_users as $user){
                    $tmp = User::where('id','=',$user)->first();
                    array_push($user_list,$tmp);
                }
            }
        } else {
            return response()->json(['status'=>false,'user_list'=>$user_list]);
        }

        return response()->json(['status'=>true,'user_list'=>$user_list]);
    }
    // -------------------------- Business Data

    public function ListofAllBusiness(Request $request){
        ini_set('memory_limit', -1);

       $business_detail = DB::table('business')
                            ->where('busi_delete','=','0')
                            ->rightJoin('purchase_plan','business.busi_id','=','purchase_plan.purc_business_id')
                            ->join('users','users.id','=','business.user_id')
                            ->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
                            ->select('business.busi_id','business.busi_name','business.busi_logo_dark','business.watermark_image_dark','business.busi_email','business.busi_mobile','business.busi_logo','business.watermark_image', 'business.busi_mobile_second','purchase_plan.purc_plan_id','purchase_plan.purc_order_id','purchase_plan.purc_start_date','plan.plan_or_name','users.mobile')->orderBy('purchase_plan.purc_start_date', 'DESC');
       //$business_detail = DB::table('business')->where('busi_delete','=','0')->rightJoin('purchase_plan','business.busi_id','=','purchase_plan.purc_business_id')->join('users','users.id','=','business.user_id')->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('business.busi_id','business.busi_name','business.busi_email','business.busi_mobile','business.busi_logo', 'business.busi_mobile_second','purchase_plan.purc_plan_id','purchase_plan.purc_order_id','purchase_plan.purc_start_date','plan.plan_or_name','users.mobile')->orderBy('business.busi_id', 'DESC');

       if ($request->ajax())
       {

           return DataTables::of($business_detail)
           ->filter(function ($instance) use ($request) {
                if ($request->get('filter') == 'By Admin') {
                    $instance->where(function($w) use($request){
                        $w->where('purc_plan_id','!=', 1)
                        ->where('purc_plan_id','!=', 3)
                        ->where('purc_plan_id','!=', 0)
                        ->where('purc_plan_id','!=', '')
                        ->where('purc_order_id','FromAdmin');
                    });
                }
                elseif($request->get('filter') == 'By User')
                {
                    $instance->where(function($w) use($request){
                        $w->where('purc_plan_id','!=', 1)
                        ->where('purc_plan_id','!=', 3)
                        ->where('purc_plan_id','!=', 0)
                        ->where('purc_plan_id','!=', '')
                        ->where('purc_order_id','!=','FromAdmin');
                    });
                }
                elseif($request->get('filter') == 'Not Purchase')
                {
                    $instance->where(function($w) use($request){
                        $w->orWhere('purc_plan_id', 1)
                        ->orWhere('purc_plan_id', 3)
                        ->orWhere('purc_plan_id', 0)
                        ->orWhere('purc_plan_id', '');

                    });
                }

                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('busi_name', 'LIKE', "%$search%")
                        ->orWhere('busi_email', 'LIKE', "%$search%")
                        ->orWhere('busi_mobile', 'LIKE', "%$search%")
                        ->orWhere('busi_mobile_second', 'LIKE', "%$search%")
                        ->orWhere('mobile', 'LIKE', "%$search%")
                        ->orWhere('plan_or_name', 'LIKE', "%$search%")
                        ->orWhere('purc_start_date', 'LIKE', "%$search%");
                    });
                }

            })
           ->addIndexColumn()
           ->addColumn('busi_mobile',function($row) {
               $second_mobile = '';
               if($row->busi_mobile_second){
                   $second_mobile = '<br>'.$row->busi_mobile_second;
                } else {
                    $second_mobile = '';
                }

                $mobile = $row->mobile.'<br>'.$row->busi_mobile.$second_mobile;


                return $mobile;
            })
            ->addColumn('busi_logo',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->busi_logo))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->busi_logo;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('watermark_image',function($row) {

                $img = '';
                //if($row->watermark_image != '' || !is_null($row->watermark_image))
                if(!empty($row->watermark_image))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->watermark_image;


                    //$img = '<img src="'.$row->watermark_image.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('busi_logo_dark',function($row) {

                $img = '';
                //if($row->busi_logo_dark != '' || !is_null($row->busi_logo_dark))
                if(!empty($row->busi_logo_dark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->busi_logo_dark;


                    //$img = '<img src="'.$row->busi_logo_dark.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('watermark_image_dark',function($row) {

                $img = '';
                //if($row->watermark_image_dark != '' || !is_null($row->watermark_image_dark))
                if(!empty($row->watermark_image_dark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->watermark_image_dark;


                    //$img = '<img src="'.$row->watermark_image_dark.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('PurchaseDate',function($row){
                $date= "free";
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3 || $row->purc_plan_id == ""){
                    $date = 'free';
                }
                else
                {
                    $date = date('d-m-Y',strtotime($row->purc_start_date)).' / '.$row->plan_or_name;
                }
                return $date;
            })
            ->addColumn('PurchasePlan',function($row) {

                $source = '';
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 0 || $row->purc_plan_id == ""){
                    $source = '<br>Not Purchase';
                }
                elseif($row->purc_order_id == 'FromAdmin'){
                    $source = '<br>By Admin';
                }
                elseif($row->purc_order_id != 'FromAdmin'){
                    $source = '<br>By User';
                }

                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3)
                {

                    $btn = '<button class="btn btn-primary" onclick="purchaseplan('.$row->busi_id.')">Purchase</button>';
                    $btn .= $source;
                }
                else
                {
                   $btn = "Purchased";
                   $btn .= '<br><button class="btn btn-danger" onclick="cancelplan('.$row->busi_id.')">Cencal</button>';
                   $btn .= $source;
                }

                return $btn;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary" onclick="EditBusiness('.$row->busi_id.')"><i class="flaticon-pencil"></i></button>';
                return $btn;
            })
            ->rawColumns(['PurchasePlan','action','busi_logo', 'watermark_image','busi_mobile', 'busi_logo_dark', 'watermark_image_dark'])
            ->make(true);
        }

    }

    public function ListofBusinessApproval(){

        $listofbusiness = DB::table('business')->where('busi_is_approved','=','0')->where('busi_delete','=','0')->join('business_new','business.busi_id','=','business_new.busi_id_old')->join('users','business.user_id','=','users.id')->orderBy('business_new.busi_id_new', 'ASC')->get()->toArray();

        return view('user::approval',['businesses' => $listofbusiness]);
    }

    public function approvBusiness(Request $request){
         $busi_id = $request->id;
         $listofbusiness = DB::table('business_new')->where('busi_id_old','=',$busi_id)->first();

        Business::where('busi_id',$busi_id)->update([
            'busi_is_approved'=>1,
            'busi_name' => $listofbusiness->busi_name_new,
        ]);


        $data = array(
            'route' => 'business_approval',
            'id' => $busi_id,
            'name' => $listofbusiness->busi_name_new,
            'click_action' => "com.app.activity.RegisterActivity",
        );

        $title = 'Business Detail Change Approval';
        $message = 'Your Business Detail Change for '.$listofbusiness->busi_name_new.' is Approved';
        $type = 'general';


        $message_payload = array (
            'message' => $message,
            'type' => $type,
            'title' => $title,
            'data' => $data,
        );

        PushNotification::sendPushNotification($listofbusiness->user_id_new,$message_payload);

        DB::delete('delete from business_new where busi_id_old = ?',[$busi_id]);

        return response()->json(['status'=>true,'data'=>""]);
    }

    public function declineBusiness(Request $request){
        $busi_id = $request->id;
        $listofbusiness = DB::table('business_new')->where('busi_id_old','=',$busi_id)->first();
        Business::where('busi_id',$busi_id)->update(['busi_is_approved'=>2]);
        DB::delete('delete from business_new where busi_id_old = ?',[$busi_id]);

        $data = array(
            'route' => 'business_decline',
            'id' => $busi_id,
            'name' => $listofbusiness->busi_name_new,
            'click_action' => "com.app.activity.RegisterActivity",
        );

        $title = 'Business Detail Change Decline';
        $message = 'Your Business Detail Change for '.$listofbusiness->busi_name_new.' is Declined';
        $type = 'general';


        $message_payload = array (
            'message' => $message,
            'type' => $type,
            'title' => $title,
            'data' => $data,
        );

        PushNotification::sendPushNotification($listofbusiness->user_id_new,$message_payload);

        return response()->json(['status'=>true,'data'=>""]);
    }

    public function purchasePlan(Request $request){


        $business_id = $request->id;

        if(empty($request->plan_id)) {
            return response()->json(['status' => false, 'message' => 'Plan not found']);
        }

        $user_id = Business::where('busi_id','=',$business_id)->select('user_id')->first();

         $is_purchasebeforee = DB::table('purchase_plan')->where('purc_user_id','=',$user_id->user_id)->where('purc_plan_id','=',2)->select('purc_user_id')->first();

         $purchasebeforeedata = DB::table('purchase_plan')->where('purc_user_id','=',$user_id->user_id)->where('purc_business_id','=',$business_id)->where('purc_business_type', 1)->first();

        if(is_null($is_purchasebeforee)){

            $results = DB::table('refferal_data')->where('ref_user_id','=',$user_id->user_id)->select('ref_by_user_id')->first();
          	if(!is_null($results)){
              $credit = DB::table('setting')->where('setting_id','=',1)->select('credit')->first();

              $usercredit = DB::table('users')->where('id', '=', $results->ref_by_user_id)->select('user_credit','id')->first();

              $newcredit = intval($usercredit->user_credit) + intval($credit->credit);

              User::where('id','=', $results->ref_by_user_id)->update(array(
                  'user_credit'=>$newcredit,
              ));
            }

        }
        $userData = User::find($user_id->user_id);

        if($userData->referral_by != 0 && $userData->referral_premium == 0) {
            $settingData = DB::table('setting')->first();
            $referral_subscription_amount = 0;
            if(!empty($settingData)) {
                $referral_subscription_amount = $settingData->referral_subscription_amount;
            }

            $userReferralData = UserReferral::where('user_id', $userData->referral_by)->first();
            $total_earning = $userReferralData->total_earning + $referral_subscription_amount;
            $current_balance = $userReferralData->current_balance + $referral_subscription_amount;
            $userReferralData->total_earning = $total_earning;
            $userReferralData->current_balance = $current_balance;
            $userReferralData->save();

            $userData->referral_premium = 1;
            $userData->save();
        }

        $start_date = date('Y-m-d');
        $plantrial = Plan::where('plan_id','=',$request->plan_id)->select('plan_validity', 'bg_credit')->first();
        $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));

        if(isset($request->from) && $request->from == 'expire_plan_list'){
            Purchase::where('purc_business_id',$business_id)->where('purc_business_type','=',1)->update([
                'purc_plan_id'=>$request->plan_id,
                'purc_start_date' => $start_date,
                'purc_end_date' => $end_date,
                'purc_order_id' => 'FromUser',
                'purchase_id' => 'User',
                'device' => 'User',
                'purc_is_cencal' => 0,
                'purc_tel_status' => 7,
                'purc_follow_up_date' => null,
                'purc_is_expire' => 0
            ]);
        }
        else
        {
            Purchase::where('purc_business_id',$business_id)->where('purc_business_type','=',1)->update([
                'purc_plan_id'=>$request->plan_id,
                'purc_start_date' => $start_date,
                'purc_end_date' => $end_date,
                'purc_order_id' => 'FromAdmin',
                'purchase_id' => 'admin',
                'device' => 'admin',
                'purc_is_cencal' => 0,
                'purc_tel_status' => 7,
                'purc_follow_up_date' => null,
                'purc_is_expire' => 0
            ]);

        }

        DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 1)->delete();

        $this->addPurchasePlanHistory($business_id, 1);

        // $bg_credit = !empty($userData->bg_credit) ? $userData->bg_credit : 0;
        // $plan_bg_credit = !empty($plantrial->bg_credit) ? $plantrial->bg_credit : 0;
        // $userData->bg_credit = $bg_credit + $plan_bg_credit;
        // $userData->save();

        return response()->json(['status'=>true,'message'=>'Purchase Plan successfully Added']);
    }

    public function purchaseBGPlan(Request $request){
        $user_id = $request->user_id;
        $plan_id = $request->plan_id;
        $userData = User::find($user_id);
        if(empty($userData)){
            return response()->json(['status'=>false,'message'=>'User not found']);
        }
        $plan = BGCreditPlan::find($plan_id);
        if(empty($plan)){
            return response()->json(['status'=>false,'message'=>'Plan not found']);
        }

        $old_credit = $userData->bg_credit;
        $new_credit = $old_credit + $plan->bg_credit;

        $userData->bg_credit = $new_credit;
        $userData->save();

        $plan_price = $plan->price;
        $plan_bg_credit = $plan->bg_credit;
        $planHistory = new BGCreditPlanHistory;
        $planHistory->user_id = $user_id;
        $planHistory->plan_id = $plan_id;
        $planHistory->plan_price = $plan_price;
        $planHistory->plan_bg_credit = $plan_bg_credit;
        $planHistory->save();
        return response()->json(['status'=>true,'message'=>'Purchase Plan successfully Added']);

    }

    public function cencalPurchasedPlan(Request $request){

       Purchase::where('purc_business_id', $request->id)->where('purc_business_type', 1)->update(array(
           'purc_plan_id' => 3,
           'purc_end_date' => null,
       ));

       if(isset($request->from) && $request->from == 'expire_plan_list'){
            Purchase::where('purc_business_id', $request->id)->where('purc_business_type', 1)->update(array(
                'purc_is_expire' => 1, 'purc_tel_status' => 8,
            ));
       } else {
            Purchase::where('purc_business_id', $request->id)->where('purc_business_type', 1)->update(array(
                'purc_is_cencal' => 1, 'purc_tel_status' => 9,
            ));

            $this->updateCencalDateInHistoryTable($request->id, 1);
       }



       return response()->json(['status' => true,'message'=>'plan Succesfully cancel']);
    }

    public function addFrame(Request $request) {
       $temp = $request->all();

       $userid = $temp['user_id'];

       $business_id = $temp['business_id'];

       $business_type = $temp['business_type'];

       $image = (isset($temp['frame'])) ? $temp['frame'] : 'undefined';

        if($image != 'undefined'){
           $path = $this->uploadFile($request, null, 'frame', 'frame-img');

        } else {
           $path = '';
        }

        DB::table('user_frames')->insert(
            ['frame_url' => $path, 'user_id' => $userid, 'business_id' => $business_id, 'business_type' => $business_type]
        );

     return response()->json(['status' => true,'message'=>'Frame successfully added']);
    }

    public function removeFrame(Request $request){

        DB::table('user_frames')->where('user_frames_id', $request->id)->update(['is_deleted' => 1]);

        return response()->json(['status' => true,'message'=>'Frame successfully removed']);
    }

    public function AllPost(Request $request) {
        $getallphotos = DB::table('photos')->join('users','photos.photo_user_id','=','users.id')->select('users.name','users.mobile','users.total_post_download', 'users.tel_user','photos.photo_url','photos.photo_id','photos.date_added', 'photos.photo_user_id')->where('photos.photo_is_delete','=',0);

        if($request->ajax()){
            return DataTables::of($getallphotos)
            ->addIndexColumn()
            ->editColumn('photo_url',function($row) {
                $btn = '<img src="'.Storage::url($row->photo_url).'" height="100" width="100" class="popup" onclick="previewimg(this)">';
                return $btn;
            })
            ->addColumn('total',function($row) {
                return $row->total_post_download;
            })
            ->addColumn('telecaller',function($row) {
                $telecaller = "";
                if($row->tel_user == 0) {
                    $telecaller = "<button class='btn btn-sm btn-primary' onclick='assigneTelecaller(this)' data-id='".$row->photo_user_id."'>Assign</button>";
                }
                else {
                    $user = User::find($row->tel_user);
                    if($user) {
                        $telecaller = $user->name;
                    }
                    else {
                        $telecaller = "<button class='btn btn-sm btn-primary' onclick='assigneTelecaller(this)' data-id='".$row->photo_user_id."'>Assign</button>";
                    }
                }
                return $telecaller;
            })
            ->editColumn('date_added',function($row) {
                $date = date("d-m-Y", strtotime($row->date_added));
                return $date;
            })
            ->rawColumns(['date_added','photo_url', 'telecaller'])
            ->make(true);
        }
    }

    public function assigneTelecallerAdd(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'telecaller_id' => 'required',
            'follow_up_date' => 'required',
        ],
        [
            'user_id.required'=> "User Is Required",
            'telecaller_id.required'=> "Telecaller Is Required",
            'follow_up_date.required'=> "Date Is Required",
        ]);

        if ($validator->fails())
        {
            $error=json_decode($validator->errors());

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }
        $users = User::where('id', $request->user_id)->update(['tel_user'=>$request->telecaller_id, 'follow_up_date' => $request->follow_up_date]);

        return response()->json(['status' => 1,'data' => "", 'message' => 'Telecaller added' ]);
    }

    public function getBusinessforEdit(Request $request){
        $id =  $request->id;

        $business_detail = DB::table('business')->where('busi_id','=',$id)->get();

        return response()->json(['status'=>true,'business_detail'=>$business_detail]);

    }

    public function UpdateBusiness(Request $request){
        $temp = $request->all();
        $image = (isset($temp['logo'])) ? $temp['logo'] : 'undefined';
        $watermark = (isset($temp['watermark'])) ? $temp['watermark'] : 'undefined';
        $imagedark = (isset($temp['logodark'])) ? $temp['logodark'] : 'undefined';
        $watermarkdark = (isset($temp['watermarkdark'])) ? $temp['watermarkdark'] : 'undefined';

        if ($temp['business_id'] != '')
        {
            if($image != 'undefined'){
               $path = $this->uploadFile($request, null, 'logo', 'business-img');
            }
            else {
                $path = '';
            }
            if($watermark != 'undefined'){
               $watermark_path = $this->uploadFile($request, null, 'watermark', 'business-img');
            }
            else {
                $watermark_path = '';
            }
            if($imagedark != 'undefined'){
                $pathdark = $this->uploadFile($request, null, 'logodark', 'business-img');
             }
             else {
                $pathdark = '';
             }
             if($watermarkdark != 'undefined'){
                $watermarkdark_path = $this->uploadFile($request, null, 'watermarkdark', 'business-img');
             }
             else {
                $watermarkdark_path = '';
             }
            Business::where('busi_id',$temp['business_id'])->update([
                'busi_is_approved'=>1,
                'busi_name' => $temp['business_name'],
                'busi_email' => $temp['business_email'],
                'busi_website' => $temp['business_website'],
                'busi_mobile' => $temp['business_mobile'],
                'busi_mobile_second' => $temp['business_mobile_second'],
                'busi_address' => $temp['business_address'],
                'business_category' => $temp['business_category'],
            ]);
            if($path != '') {
                Business::where('busi_id',$temp['business_id'])->update([
                    'busi_logo' => $path,
                ]);
            }
            if($watermark_path != '') {
                Business::where('busi_id',$temp['business_id'])->update([
                    'watermark_image' => $watermark_path,
                ]);
            }
            if($pathdark != '') {
                Business::where('busi_id',$temp['business_id'])->update([
                    'busi_logo_dark' => $pathdark,
                ]);
            }
            if($watermarkdark_path != '') {
                Business::where('busi_id',$temp['business_id'])->update([
                    'watermark_image_dark' => $watermarkdark_path,
                ]);
            }

        }
        else
        {
            if($image != 'undefined')
            {
               $path = $this->uploadFile($request, null, 'logo', 'business-img');
           }
           else
           {
                $path = '';
           }
           if($watermark != 'undefined'){
               $watermark_path = $this->uploadFile($request, null, 'watermark', 'business-img');
            }
            else {
                $watermark_path = '';
            }
            if($imagedark != 'undefined'){
                $pathdark = $this->uploadFile($request, null, 'logodark', 'business-img');
             }
             else {
                $pathdark = '';
             }
             if($watermarkdark != 'undefined'){
                $watermarkdark_path = $this->uploadFile($request, null, 'watermarkdark', 'business-img');
             }
             else {
                $watermarkdark_path = '';
             }

                $user_id = $temp['user_id'];
               $business_id = Business::insertGetId([
                                'busi_is_approved'=>1,
                                'busi_name' => $temp['business_name'],
                                'user_id' => $user_id,
                                'busi_email' => $temp['business_email'],
                                'busi_website' => $temp['business_website'],
                                'busi_mobile' => $temp['business_mobile'],
                                'busi_mobile_second' => $temp['business_mobile_second'],
                                'busi_address' => $temp['business_address'],
                                'business_category' => $temp['business_category'],
                                'busi_logo' => $path,
                                'watermark_image' => $watermark_path,
                                'busi_logo_dark' => $pathdark,
                                'watermark_image_dark' => $watermarkdark_path,
                            ]);



                $start_date = date('Y-m-d');

                // $end_date = date('Y-m-d', strtotime($start_date. ' + 3 days'));


                $purchase = new Purchase();
                $purchase->purc_user_id = $user_id;
                $purchase->purc_business_id = $business_id;
                $purchase->purc_plan_id = 3;
                $purchase->purc_start_date = $start_date;
                // $purchase->purc_end_date = $end_date;
                $purchase->save();

                $userdata = User::where('id','=',$user_id)->select('default_business_id')->first();

                if($userdata->default_business_id == 0 || $userdata->default_business_id == ''){
                    User::where('id', $user_id)->update(array(
                        'default_business_id' => $business_id,
                    ));
                }

        }

        return response()->json(['status'=>true,'message'=>'Business successfully updated']);

    }


    public function sendPushNotification(Request $request){
        $formData = $request->all();

        $discription = $formData['discription'];

        $image = (isset($formData['image'])) ? $formData['image'] : 'undefined';

        if($image != 'undefined'){
           $filename = Str::random(7).time().'.'.$image->getClientOriginalExtension();
           $image->move(public_path('images/'), $filename);
           $path = '/public/images/'.$filename;

       } else {
           $path = '';
       }

        DB::table('push_notification')->insert(
            ['user_type' => $formData['usertype'], 'message' => $discription, 'image_path' => $path]
        );

          $msg_payload = array (
            'image' => url('/').$path,
            'message' => $discription,
            'type' => 'accept',
            );

            /*$this->sendMessagePushNotification(array('cVaJ34loT3yRKYyQ89XsNu:APA91bGgUFq_hMPnKBmSC5RVAYOh2D2JvYuW5iC978V72Ad8UZHRcSaNtV6IAqrIFQpqWOlZyOHJKyD0Hq3uLeVJz4qXQQjoTFGmW7A01yk1WHzGWkd2MIjTdLjp4rwBNteXLqJlp5N2'),$msg_payload);*/

            //die;
            if($formData['usertype'] == 'all'){


                $usertokens1 =  DB::table('users')->where('device_token','!=','')->where('device_token','!=','NA')->pluck('device_token')->toArray();
                $usertokens2 =  DB::table('user_device')->where('device_token','!=','')->where('device_token','!=','NA')->pluck('device_token')->toArray();

                $usertokens = array_merge($usertokens1,$usertokens2);
                $parts = array_chunk($usertokens, 1000);
                foreach ($parts as $part){
                    $this->sendMessagePushNotification($part,$msg_payload);
                }
            }


            if($formData['usertype'] == 'premium'){
             DB::statement("SET SQL_MODE=''");
                $usertokens1 = DB::table('purchase_plan')->where('purc_plan_id','=',2)->rightJoin('users','purchase_plan.purc_user_id','=','users.id')->where('users.device_token','!=','')->where('users.device_token','!=','NA')->groupBy('purchase_plan.purc_user_id')->pluck('users.device_token')->toArray();
                $usertokens2 = DB::table('purchase_plan')->where('purc_plan_id','=',2)->rightJoin('user_device','purchase_plan.purc_user_id','=','user_device.user_id')->where('user_device.device_token','!=','')->where('user_device.device_token','!=','NA')->groupBy('purchase_plan.purc_user_id')->pluck('user_device.device_token')->toArray();
            DB::statement("SET SQL_MODE=only_full_group_by");
                $usertokens = array_merge($usertokens1,$usertokens2);
                $parts = array_chunk($usertokens, 1000);
                foreach ($parts as $part){
                    $this->sendMessagePushNotification($part,$msg_payload);
                }

            }

            if($formData['usertype'] == 'free'){
            DB::statement("SET SQL_MODE=''");
                $usertokens1 = DB::table('purchase_plan')->where('purc_plan_id','=',3)->rightJoin('users','purchase_plan.purc_user_id','=','users.id')->where('users.device_token','!=','')->where('users.device_token','!=','NA')->groupBy('purchase_plan.purc_user_id')->pluck('users.device_token')->toArray();
                $usertokens2 = DB::table('purchase_plan')->where('purc_plan_id','=',3)->rightJoin('user_device','purchase_plan.purc_user_id','=','user_device.user_id')->where('user_device.device_token','!=','')->where('user_device.device_token','!=','NA')->groupBy('user_device.user_id')->pluck('user_device.device_token')->toArray();
            DB::statement("SET SQL_MODE=only_full_group_by");
                $usertokens = array_merge($usertokens1,$usertokens2);
                $parts = array_chunk($usertokens, 1000);
                foreach ($parts as $part){
                    $this->sendMessagePushNotification($part,$msg_payload);
                }

            }


        return redirect()->back()->with('message', 'Send Push Notification Successfully to all users');

    }

    private function sendMessagePushNotification($tokens,$payload)
    {

            $url = 'https://fcm.googleapis.com/fcm/send';
            $priority="high";
            $notification=array_merge(array('title' => 'Festival Post','body' => $payload['message']),$payload);
            $android_fields = array(
                 'registration_ids' => $tokens,
                 'data' => $notification,
                 'content_available'=> true,
                 'priority'=>'high'
                );



            $headers = array(
                'Authorization:key=AAAAe1IgXjM:APA91bEfMZWB00W2RM9n4T-_-z9xHQhwyuGA3t1OleWrUE3coSERkDCti-JxNzCDDydGZuD0wzxKl6UBAsxpgN82_9X3Se-F5vG4D0tLy3sUZKdJuALAQ6TN5s59TxTCxlWEbdtW2b4H',
                'Content-Type: application/json'
                );

           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($android_fields));

            // echo json_encode($fields);
           $result = curl_exec($ch);
           //print_r($result);die;
           echo curl_error($ch);
           if ($result === FALSE) {
               die('Curl failed: ' . curl_error($ch));
           }
           curl_close($ch);
           return $result;

    }

    public function DeletePhotos(Request $request)
    {
        $getallphotos = Photos::whereBetween('date_added', [date('Y-m-d',strtotime($request->from))." 00:00:00", date('Y-m-d',strtotime($request->to))." 23:59:59"])->get();
        //$getallphotos = Photos::where('photo_id', '337647')->get(); //storage date wise url
        $files = array();
        foreach ($getallphotos as $key => $value)
        {
             //$img_url=Storage::url($value->photo_url);
            $img_url=$value->photo_url;
            if (Storage::disk('do')->exists($img_url))
            {
                Storage::disk('do')->delete($img_url);
                //echo "dfgdfgdf";
                $value->delete();
            }

            //$value->delete();
            //dd($value->photo_url);
                //$path = explode('/public/',$value->photo_url);
                /*if(File::exists(public_path($path[0])))
                {
                    File::delete(public_path($path[0]));
                }*/
        }

        return response()->json(['status'=>true,'message'=>'photos delete']);

    }

    public function allpostdelete()
    {


        $adv_datas = DB::table('advetisement')->where('is_delete','=',0)->get();
        $advetisement = array();

        foreach ($adv_datas as $key => $value)
        {
            $data = array();
            $data['adv_image'] = !empty($value->adv_image)?Storage::disk('do')->url($value->adv_image):"";

            array_push($advetisement, $data);
        }
        echo "<pre>";
        print_r($advetisement);
        echo "</pre>";

        $getallphotos = Photos::whereBetween('date_added', [date('Y-m-d',strtotime('08-08-2021'))." 00:00:00", date('Y-m-d',strtotime('09-08-2021'))." 23:59:59"])->get();

        //$getallphotos = Photos::where('photo_id', '35153')->get(); //storage date wise url
        //$getallphotos = Photos::limit(10)->get(); //storage date wise url
        echo "dfgdfgdf";
        $files = array();
        foreach ($getallphotos as $key => $value)
        {
             //$img_url=Storage::url($value->photo_url);
            $img_url=$value->photo_url;
            if (Storage::disk('do')->exists($img_url))
            {
                Storage::disk('do')->delete($img_url);
                //echo "dfgdfgdf";
                echo $img_url.'<br>';
                $value->delete();
            }
            else
            {
                echo "No image av";
            }

            //$value->delete();
            //dd($value->photo_url);
                //$path = explode('/public/',$value->photo_url);
                /*if(File::exists(public_path($path[0])))
                {
                    File::delete(public_path($path[0]));
                }*/
        }
        die;
       // return response()->json(['status'=>true,'message'=>'photos delete']);

    }

    public function PlanList(Request $request)
    {
        $plans = Plan::where('status','!=',1)->where('plan_id','!=',3)->orderBy('order_no','asc')->get();
        return response()->json(['data'=> $plans, 'status'=>true]);

    }

    public function RemoveBusiness(Request $request)
    {

        $userdata = User::where('id','=',$request->user_id)->select('default_business_id')->first();

        if($userdata->default_business_id != $request->id)
        {

            Business::where('busi_id', $request->id)->update(array(
                'busi_delete' => 1,
            ));
            Photos::where('photo_business_id', $request->id)->update(array(
                'photo_is_delete' => 1,
            ));

            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        }
        else
        {

            Business::where('busi_id', $request->id)->update(array(
                'busi_delete' => 1,
            ));
            Photos::where('photo_business_id', $request->id)->update(array(
                'photo_is_delete' => 1,
            ));

            $currntbusiness = Business::where('user_id','=',$request->user_id)->where('busi_delete','=',0)->select('busi_id')->first();

            if(!empty($currntbusiness) || !is_null($currntbusiness)){
                User::where('id', $request->user_id)->update(array(
                    'default_business_id' => $currntbusiness->busi_id,
                ));
            } else {
                User::where('id', $request->user_id)->update(array(
                    'default_business_id' => 0,
                ));
            }
            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        }

    }

    public function RemoveBusinessPolitical(Request $request)
    {

        $userdata = User::where('id','=',$request->user_id)->select('default_political_business_id')->first();

        if($userdata->default_political_business_id != $request->id)
        {

            PoliticalBusiness::where('pb_id', $request->id)->update(array(
                'pb_is_deleted' => 1,
            ));
            // Photos::where('photo_business_id', $request->id)->update(array(
            //     'photo_is_delete' => 1,
            // ));

            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        }
        else
        {

            PoliticalBusiness::where('pb_id', $request->id)->update(array(
                'pb_is_deleted' => 1,
            ));
            // Photos::where('photo_business_id', $request->id)->update(array(
            //     'photo_is_delete' => 1,
            // ));

            $currntbusiness = PoliticalBusiness::where('user_id','=',$request->user_id)->where('pb_is_deleted','=',0)->select('pb_id')->first();

            if(!empty($currntbusiness) || !is_null($currntbusiness)){
                User::where('id', $request->user_id)->update(array(
                    'default_political_business_id' => $currntbusiness->pb_id,
                ));
            } else {
                User::where('id', $request->user_id)->update(array(
                    'default_political_business_id' => 0,
                ));
            }
            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        }

    }

    public function getExpiredPlanList(Request $request){
        $getexpiredplan1 = DB::table('purchase_plan')->leftJoin('business','business.busi_id','=','purchase_plan.purc_business_id')->leftJoin('users','users.id','=','business.user_id')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('purchase_plan.purc_id','purchase_plan.purc_start_date','purchase_plan.purc_end_date','business.busi_name','business.busi_id','users.name','users.mobile','users.id','plan.plan_or_name','purchase_plan.purc_is_expire')->whereNotIn('purchase_plan.purc_plan_id',['0','1','3'])->where('purc_is_cencal','=',0)->whereIn('purc_is_expire',[0,1])->whereDate('purchase_plan.purc_end_date', '<', date('Y-m-d'))->get()->toArray();

        $getexpiredplan2 =  DB::table('purchase_plan')->leftJoin('business','business.busi_id','=','purchase_plan.purc_business_id')->leftJoin('users','users.id','=','business.user_id')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('purchase_plan.purc_id','purchase_plan.purc_start_date','purchase_plan.purc_end_date','business.busi_name','business.busi_id','users.name','users.mobile','users.id','plan.plan_or_name','purchase_plan.purc_is_expire')->where('purc_is_cencal','=',0)->where('purc_is_expire',1)->get()->toArray();

        $getexpiredplan = array_merge($getexpiredplan1, $getexpiredplan2);
        //$getexpiredplan = json($array);

        if ($request->ajax())
        {
            return DataTables::of($getexpiredplan)
            ->addIndexColumn()
            ->addColumn('purc_start_date',function($row) {
                $date = date('d-m-Y',strtotime($row->purc_start_date));
                return $date;
            })
            ->addColumn('purc_end_date',function($row) {
                $date1 = date('d-m-Y',strtotime($row->purc_end_date));
                return $date1;
            })
            ->addColumn('action',function($row) {
                if($row->purc_is_expire == 1)
                {
                    $btn = '<button class="btn btn-primary" id="purchaseplans" onclick="purchaseplans('.$row->busi_id.')">Purchase Plan</button>';
                }
                elseif($row->purc_is_expire == 0)
                {
                    $btn = '&nbsp;&nbsp;<button class="btn btn-danger" id="cancelplan" onclick="cancelplan('.$row->busi_id.')">Cancel Plan</button>';
                }
                return $btn;
            })
            ->rawColumns(['action','purc_end_date','purc_start_date'])
            ->make(true);
        }
    }

    // ----------------- Political business

     // -------------------------- Business Data

     public function ListofAllPoliticalBusiness(Request $request){
        ini_set('memory_limit', -1);

       $business_detail = DB::table('political_business')
                            ->rightJoin('purchase_plan','political_business.pb_id','=','purchase_plan.purc_business_id')
                            ->join('users','users.id','=','political_business.user_id')
                            ->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')
                            ->select('political_business.pb_id','political_business.pb_name','political_business.pb_mobile','political_business.pb_designation','political_business.pb_party_logo','political_business.pb_watermark','political_business.pb_party_logo_dark','political_business.pb_watermark_dark','political_business.pb_left_image','political_business.pb_right_image','purchase_plan.purc_plan_id','purchase_plan.purc_order_id','purchase_plan.purc_start_date','plan.plan_or_name','users.mobile')->where('political_business.pb_is_deleted','=','0')->where('purchase_plan.purc_business_type','=',2)->orderBy('purchase_plan.purc_start_date', 'DESC');

       if ($request->ajax())
       {

           return DataTables::of($business_detail)
           ->filter(function ($instance) use ($request) {
                if ($request->get('filter') == 'By Admin') {
                    $instance->where(function($w) use($request){
                        $w->where('purc_plan_id','!=', 1)
                        ->where('purc_plan_id','!=', 3)
                        ->where('purc_plan_id','!=', 0)
                        ->where('purc_plan_id','!=', '')
                        ->where('purc_order_id','FromAdmin');
                    });
                }
                elseif($request->get('filter') == 'By User')
                {
                    $instance->where(function($w) use($request){
                        $w->where('purc_plan_id','!=', 1)
                        ->where('purc_plan_id','!=', 3)
                        ->where('purc_plan_id','!=', 0)
                        ->where('purc_plan_id','!=', '')
                        ->where('purc_order_id','!=','FromAdmin');
                    });
                }
                elseif($request->get('filter') == 'Not Purchase')
                {
                    $instance->where(function($w) use($request){
                        $w->orWhere('purc_plan_id', 1)
                        ->orWhere('purc_plan_id', 3)
                        ->orWhere('purc_plan_id', 0)
                        ->orWhere('purc_plan_id', '');

                    });
                }

                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('pb_name', 'LIKE', "%$search%")
                        ->orWhere('pb_designation', 'LIKE', "%$search%")
                        ->orWhere('pb_mobile', 'LIKE', "%$search%")
                        ->orWhere('plan_or_name', 'LIKE', "%$search%")
                        ->orWhere('purc_start_date', 'LIKE', "%$search%");
                    });
                }

            })
           ->addIndexColumn()
            ->addColumn('pb_party_logo',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_party_logo))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_party_logo;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_watermark',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_watermark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_watermark;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_party_logo_dark',function($row) {

                $img = '';
                //if($row->pb_party_logo_dark != '' || !is_null($row->pb_party_logo_dark))
                if(!empty($row->pb_party_logo_dark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_party_logo_dark;


                    //$img = '<img src="'.$row->pb_party_logo_dark.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_watermark_dark',function($row) {

                $img = '';
                //if($row->pb_watermark_dark != '' || !is_null($row->pb_watermark_dark))
                if(!empty($row->pb_watermark_dark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_watermark_dark;


                    //$img = '<img src="'.$row->pb_watermark_dark.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_left_image',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_left_image))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_left_image;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_right_image',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_right_image))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_right_image;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('PurchaseDate',function($row){
                $date= "free";
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3 || $row->purc_plan_id == ""){
                    $date = 'free';
                }
                else
                {
                    $date = date('d-m-Y',strtotime($row->purc_start_date)).' / '.$row->plan_or_name;
                }
                return $date;
            })
            ->addColumn('PurchasePlan',function($row) {

                $source = '';
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 0 || $row->purc_plan_id == ""){
                    $source = '<br>Not Purchase';
                }
                elseif($row->purc_order_id == 'FromAdmin'){
                    $source = '<br>By Admin';
                }
                elseif($row->purc_order_id != 'FromAdmin'){
                    $source = '<br>By User';
                }


                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3)
                {

                    $btn = '<button class="btn btn-primary" onclick="purchaseplanspolitical('.$row->pb_id.')">Purchase</button>';
                    $btn .= $source;
                }
                else
                {
                   $btn = "Purchased";
                   $btn .= '<br><button class="btn btn-danger" onclick="cancelplanpolitical('.$row->pb_id.')">Cencal</button>';
                   $btn .= $source;
                }

                return $btn;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary" onclick="EditBusinesspolitical('.$row->pb_id.')"><i class="flaticon-pencil"></i></button>';
                return $btn;
            })
            ->rawColumns(['PurchasePlan','action','pb_party_logo','pb_watermark','pb_left_image','pb_right_image', 'pb_party_logo_dark', 'pb_watermark_dark'])
            ->make(true);
        }

    }

    public function ListofUsersAllPoliticalBusiness(Request $request){
        ini_set('memory_limit', -1);

        $user_id = $request->user_id;
       $business_detail = DB::table('political_business')->rightJoin('purchase_plan','political_business.pb_id','=','purchase_plan.purc_business_id')->join('users','users.id','=','political_business.user_id')->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('political_business.pb_id','political_business.user_id','political_business.pb_name','political_business.pb_mobile','political_business.pb_designation','political_business.pb_party_logo','political_business.pb_watermark','political_business.pb_party_logo_dark','political_business.pb_watermark_dark','political_business.pb_left_image','political_business.pb_right_image','purchase_plan.purc_plan_id','purchase_plan.purc_order_id','purchase_plan.purc_start_date','plan.plan_or_name','users.mobile','users.default_political_business_id')->where('political_business.user_id','=',$user_id)->where('political_business.pb_is_deleted','=','0')->where('purchase_plan.purc_business_type','=',2)->orderBy('purchase_plan.purc_start_date', 'DESC');


       if ($request->ajax())
       {

           return DataTables::of($business_detail)
           ->filter(function ($instance) use ($request) {
                if ($request->get('filter') == 'By Admin') {
                    $instance->where(function($w) use($request){
                        $w->where('purc_plan_id','!=', 1)
                        ->where('purc_plan_id','!=', 3)
                        ->where('purc_plan_id','!=', 0)
                        ->where('purc_plan_id','!=', '')
                        ->where('purc_order_id','FromAdmin');
                    });
                }
                elseif($request->get('filter') == 'By User')
                {
                    $instance->where(function($w) use($request){
                        $w->where('purc_plan_id','!=', 1)
                        ->where('purc_plan_id','!=', 3)
                        ->where('purc_plan_id','!=', 0)
                        ->where('purc_plan_id','!=', '')
                        ->where('purc_order_id','!=','FromAdmin');
                    });
                }
                elseif($request->get('filter') == 'Not Purchase')
                {
                    $instance->where(function($w) use($request){
                        $w->orWhere('purc_plan_id', 1)
                        ->orWhere('purc_plan_id', 3)
                        ->orWhere('purc_plan_id', 0)
                        ->orWhere('purc_plan_id', '');

                    });
                }

                if (!empty($request->input('search.value'))) {
                        $instance->where(function($w) use($request){
                        $search = $request->input('search.value');
                        $w->orWhere('pb_name', 'LIKE', "%$search%")
                        ->orWhere('pb_designation', 'LIKE', "%$search%")
                        ->orWhere('pb_mobile', 'LIKE', "%$search%")
                        ->orWhere('plan_or_name', 'LIKE', "%$search%")
                        ->orWhere('purc_start_date', 'LIKE', "%$search%");
                    });
                }

            })
           ->addIndexColumn()
            ->addColumn('pb_party_logo',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_party_logo))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_party_logo;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_watermark',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_watermark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_watermark;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_party_logo_dark',function($row) {

                $img = '';
                //if($row->pb_party_logo_dark != '' || !is_null($row->pb_party_logo_dark))
                if(!empty($row->pb_party_logo_dark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_party_logo_dark;


                    //$img = '<img src="'.$row->pb_party_logo_dark.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_watermark_dark',function($row) {

                $img = '';
                //if($row->pb_watermark_dark != '' || !is_null($row->pb_watermark_dark))
                if(!empty($row->pb_watermark_dark))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_watermark_dark;


                    //$img = '<img src="'.$row->pb_watermark_dark.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_left_image',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_left_image))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_left_image;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('pb_right_image',function($row) {

                $img = '';
                //if($row->busi_logo != '' || !is_null($row->busi_logo))
                if(!empty($row->pb_right_image))
                {
                    $imgurl_create = Storage::url('/');
                    $imgurl = str_replace(".com/",".com/",$imgurl_create).''.$row->pb_right_image;


                    //$img = '<img src="'.$row->busi_logo.'" height="100" width="100">';
                    $img = '<img src="'.$imgurl.'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('PurchaseDate',function($row){
                $date= "free";
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3 || $row->purc_plan_id == ""){
                    $date = 'free';
                }
                else
                {
                    $date = date('d-m-Y',strtotime($row->purc_start_date)).' / '.$row->plan_or_name;
                }
                return $date;
            })
            ->addColumn('PurchasePlan',function($row) {

                $source = '';
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 0 || $row->purc_plan_id == ""){
                    $source = '<br>Not Purchase';
                }
                elseif($row->purc_order_id == 'FromAdmin'){
                    $source = '<br>By Admin';
                }
                elseif($row->purc_order_id != 'FromAdmin'){
                    $source = '<br>By User';
                }


                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3)
                {

                    $btn = '<button class="btn btn-primary" onclick="purchaseplanspolitical('.$row->pb_id.')">Purchase</button>';
                    $btn .= $source;
                }
                else
                {
                   $btn = "Purchased";
                   $btn .= '<br><button class="btn btn-danger" onclick="cancelplanpolitical('.$row->pb_id.')">Cencal</button>';
                   $btn .= $source;
                }

                return $btn;
            })
            ->addColumn('AssignDesigner',function($row) {
                $btn = "";
                if($row->purc_plan_id == 1 || $row->purc_plan_id == 3 || $row->purc_plan_id == 3)
                {
                }
                else {
                    $checkDesigner = CustomFrame::where('business_type', 2)->where('business_id', $row->pb_id)->where('status', 'Pending')->first();
                    if($checkDesigner) {
                        $btn = '<button class="btn btn-primary" onclick="editDesignerPolitical('.$row->pb_id.')">Edit Designer</button>';
                        // $btn .= '<br /><button onclick="viewDesignerPolitical('.$row->pb_id.')" class="btn btn-primary">View</button>';
                    }
                    else {
                        $btn = '<button class="btn btn-primary" onclick="assignDesignerPoliticalBusiness('.$row->pb_id.')">Assign Designer</button>';
                    }
                }

                return $btn;
            })
            ->addColumn('action',function($row) {
                $classs = "";
                if($row->pb_id == $row->default_political_business_id)
                {
                    $classs = "default";
                }

                $btn = '<button class="btn btn-primary '.$classs.'" onclick="EditBusinesspolitical('.$row->pb_id.')"><i class="flaticon-pencil"></i></button><button class="btn btn-danger '.$classs.'" id="removeBusiness" onclick="removeBusinessPolitical('.$row->pb_id.', '.$row->user_id.')"><i class="fa fa-trash" aria-hidden="true"></i></button><script>setdefaultColor();</script>';
                if(Auth::user()->user_role == 1){
                    return $btn;
                } else {
                    return 'No Permission';
                }
            })
            ->rawColumns(['PurchasePlan','AssignDesigner','action','pb_party_logo', 'pb_party_logo_dark','pb_watermark','pb_watermark_dark','pb_left_image','pb_right_image'])
            ->make(true);
        }
    }

    public function viewDesignerPolitical(Request $request) {
        $designer_data = CustomFrame::where('business_type', $request->business_type)->where('business_id', $request->business_id)->where('status', 'Pending')->first();
        if(empty($designer_data)) {
            return response()->json(['status'=>false,'data'=>""]);
        }
        $designer = User::find($designer_data->designer_id);
        $designer_data->designer = $designer;
        return response()->json(['status'=>true,'data'=>$designer_data]);
    }

    public function getPoliticalBusinessforEdit(Request $request){
        $id =  $request->id;

        $business_detail = DB::table('political_business')->where('pb_id','=',$id)->first();

        return response()->json(['status'=>true,'business_detail'=>$business_detail]);

    }

    public function updatePoliticalBusiness(Request $request){
        $getBusiness = PoliticalBusiness::where('pb_id','=',$request->id)->first();
        // print_r($getBusiness);die;
        $name = $request->name;
        $designation = $request->designation;
        $mobile = $request->mobile;
        $party_id = $request->category;

        $logo = $request->file('party_logo');
        $watermark = $request->file('watermark');
        $logodark = $request->file('party_logodark');
        $watermarkdark = $request->file('watermarkdark');
        $left_image = $request->file('left_image');
        $right_image = $request->file('right_image');

        $facebook = $request->facebook;
        $twitter = $request->twitter;
        $instagram = $request->instagram;
        $linkedin = $request->linkedin;
        $youtube = $request->youtube;

        $logo_path = '';
        $watermark_path = '';
        $logodark_path = '';
        $watermarkdark_path = '';
        $left_image_path = '';
        $right_image_path = '';

        // $categoryImage = PoliticalCategory::where('pc_id','=',$party_id)->select('pc_image')->first();

        if($watermark != null){
            $watermark_path  =  $this->uploadFile($request, null,"watermark", 'political-business-img');
        } else {
            $watermark_path = (!empty($getBusiness)) ?  $getBusiness->pb_watermark : "";
        }
        if($watermarkdark != null){
            $watermarkdark_path  =  $this->uploadFile($request, null,"watermarkdark", 'political-business-img');
        } else {
            $watermarkdark_path = (!empty($getBusiness)) ?  $getBusiness->pb_watermark_dark : "";
        }

        if($logo != null){
            $logo_path  =  $this->uploadFile($request, null,"party_logo", 'political-business-img');
        } else {
            $logo_path = (!empty($getBusiness)) ?  $getBusiness->pb_party_logo : "";
        }

        if($logodark != null){
            $logodark_path  =  $this->uploadFile($request, null,"party_logodark", 'political-business-img');
        } else {
            $logodark_path = (!empty($getBusiness)) ?  $getBusiness->pb_party_logodark_dark : "";
        }

        if($left_image != null){
            $left_image_path  =  $this->uploadFile($request, null,"left_image", 'political-business-img');
        } else {
            $left_image_path = (!empty($getBusiness)) ?  $getBusiness->pb_left_image : "";
        }

        if($right_image != null){
            $right_image_path  =  $this->uploadFile($request, null,"right_image", 'political-business-img');
        } else {
            $right_image_path = (!empty($getBusiness)) ?  $getBusiness->pb_right_image : "";
        }

        if(!empty($getBusiness)){
            $business = PoliticalBusiness::where('pb_id','=',$request->id)->update([
                'pb_name' => $name,
                'pb_designation' => $designation,
                'pb_mobile' => $mobile,
                'pb_pc_id' => $party_id,
                'pb_party_logo' => $logo_path,
                'pb_watermark' => $watermark_path,
                'pb_party_logo_dark' => $logodark_path,
                'pb_watermark_dark' => $watermarkdark_path,
                'pb_left_image' => $left_image_path,
                'pb_right_image' => $right_image_path,
                'pb_facebook' => $facebook,
                'pb_twitter' => $twitter,
                'pb_instagram' => $instagram,
                'pb_linkedin' => $linkedin,
                'pb_youtube' => $youtube,
                ]);
        }  else {
            PoliticalBusiness::insert([
                'pb_name' => $name,
                'user_id' => $request->user_id,
                'pb_designation' => $designation,
                'pb_mobile' => $mobile,
                'pb_pc_id' => $party_id,
                'pb_party_logo' => $logo_path,
                'pb_watermark' => $watermark_path,
                'pb_party_logo_dark' => $logodark_path,
                'pb_watermark_dark' => $watermarkdark_path,
                'pb_left_image' => $left_image_path,
                'pb_right_image' => $right_image_path,
                'pb_facebook' => $facebook,
                'pb_twitter' => $twitter,
                'pb_instagram' => $instagram,
                'pb_linkedin' => $linkedin,
                'pb_youtube' => $youtube,
                ]);

                $user_id = $request->user_id;

                $business = PoliticalBusiness::where('user_id','=',$user_id)->select('pb_id')->orderBy('pb_id','DESC')->first();

                $business_id = $business->pb_id;

                $start_date = date('Y-m-d');

                // $end_date = date('Y-m-d', strtotime($start_date. ' + 3 days'));


                $purchase = new Purchase();
                $purchase->purc_user_id = $user_id;
                $purchase->purc_business_id = $business_id;
                $purchase->purc_plan_id = 3;
                $purchase->purc_start_date = $start_date;
                $purchase->purc_business_type = 2;
                $purchase->save();

                $userdata = User::where('id','=',$user_id)->select('default_political_business_id')->first();

                if($userdata->default_political_business_id == 0 || $userdata->default_political_business_id == ''){
                    User::where('id', $user_id)->update(array(
                        'default_political_business_id' => $business_id,
                    ));
                }
        }


        return response()->json(['status'=>true,'data'=>"business successfully updated"]);
    }

    public function purchasePoliticalPlan(Request $request){


        $business_id = $request->id;

        $user_id = PoliticalBusiness::where('pb_id','=',$business_id)->select('user_id')->first();

         $is_purchasebeforee = DB::table('purchase_plan')->where('purc_user_id','=',$user_id->user_id)->where('purc_plan_id','=',2)->select('purc_user_id')->first();

        if(is_null($is_purchasebeforee)){

            $results = DB::table('refferal_data')->where('ref_user_id','=',$user_id->user_id)->select('ref_by_user_id')->first();
          	if(!is_null($results)){
              $credit = DB::table('setting')->where('setting_id','=',1)->select('credit')->first();

              $usercredit = DB::table('users')->where('id', '=', $results->ref_by_user_id)->select('user_credit','id')->first();

              $newcredit = intval($usercredit->user_credit) + intval($credit->credit);

              User::where('id','=', $results->ref_by_user_id)->update(array(
                  'user_credit'=>$newcredit,
              ));
            }

        }

        $userData = User::find($user_id->user_id);

        if($userData->referral_by != 0 && $userData->referral_premium == 0) {
            $settingData = DB::table('setting')->first();
            $referral_subscription_amount = 0;
            if(!empty($settingData)) {
                $referral_subscription_amount = $settingData->referral_subscription_amount;
            }

            $userReferralData = UserReferral::where('user_id', $userData->referral_by)->first();
            $total_earning = $userReferralData->total_earning + $referral_subscription_amount;
            $current_balance = $userReferralData->current_balance + $referral_subscription_amount;
            $userReferralData->total_earning = $total_earning;
            $userReferralData->current_balance = $current_balance;
            $userReferralData->save();

            $userData->referral_premium = 1;
            $userData->save();
        }

        $start_date = date('Y-m-d');
        $plantrial = Plan::where('plan_id','=',$request->plan_id)->select('plan_validity', 'bg_credit')->first();
        $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));

        if(isset($request->from) && $request->from == 'expire_plan_list'){
            Purchase::where('purc_business_id',$business_id)->where('purc_business_type','=',2)->update([
                'purc_plan_id'=>$request->plan_id,
                'purc_start_date' => $start_date,
                'purc_end_date' => $end_date,
                'purc_order_id' => 'FromUser',
                'purchase_id' => 'User',
                'device' => 'User',
                'purc_is_cencal' => 0,
                'purc_tel_status' => 7,
                'purc_follow_up_date' => null,
                'purc_is_expire' => 0
            ]);
        }
        else
        {
            Purchase::where('purc_business_id',$business_id)->where('purc_business_type','=',2)->update([
                'purc_plan_id'=>$request->plan_id,
                'purc_start_date' => $start_date,
                'purc_end_date' => $end_date,
                'purc_order_id' => 'FromAdmin',
                'purchase_id' => 'admin',
                'device' => 'admin',
                'purc_is_cencal' => 0,
                'purc_tel_status' => 7,
                'purc_follow_up_date' => null,
                'purc_is_expire' => 0
            ]);
        }

        DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 2)->delete();

        $this->addPurchasePlanHistory($business_id, 2);

        // $bg_credit = !empty($userData->bg_credit) ? $userData->bg_credit : 0;
        // $plan_bg_credit = !empty($plantrial->bg_credit) ? $plantrial->bg_credit : 0;
        // $userData->bg_credit = $bg_credit + $plan_bg_credit;
        // $userData->save();

        return response()->json(['status'=>true,'message'=>'Purchase Plan successfully Added']);
    }

    public function getPoliticalPlanList(){
        $plans = Plan::where('status','!=',1)->where('plan_id','!=',3)->where('plan_type','!=',1)->orderBy('order_no','asc')->get();
        return response()->json(['data'=> $plans, 'status'=>true]);
    }

    public function getPoliticalCategoryList(){
        $plans = DB::table('political_category')->where('pc_is_deleted','!=',1)->get();
        return response()->json(['data'=> $plans, 'status'=>true]);
    }

    public function cencalPoliticalPurchasedPlan(Request $request){

        // $user_id = PoliticalBusiness::where('pb_id','=',$request->id)->select('user_id')->first();
        // $lastInsertedId = DB::table('purchase_plan')->where('purc_user_id','=',$user_id->user_id)->where('purc_business_id','=',$request->id)->where('purc_business_type','=',2)->select('purc_id')->first();
        // $purchasebeforeedata = DB::table('purchase_plan')->where('purc_user_id','=',$user_id->user_id)->where('purc_business_id','=',$request->id)->where('purc_business_type','=',2)->first();

            // $fromuserOrAdmin = 'FromAdmin';
            // $adminOruser = 'admin';

            // if(isset($request->from) && $request->from == 'expire_plan_list'){
            //     $fromuserOrAdmin = 'FromUser';
            //     $adminOruser = 'user';
            // }

            // $values = array(
            //     'pph_purc_id' => (is_null($purchasebeforeedata)) ? $lastInsertedId->purc_id : $purchasebeforeedata->purc_id,
            //     'pph_purc_user_id' => $user_id->user_id,
            //     'pph_purc_order_id'=>  $fromuserOrAdmin,
            //     'pph_purc_business_id'=>(is_null($purchasebeforeedata)) ? $business_id : $purchasebeforeedata->purc_business_id,
            //     'pph_purc_business_type'=> 2,
            //     'pph_purc_plan_id'=> (is_null($purchasebeforeedata)) ? $request->plan_id : $purchasebeforeedata->purc_plan_id,
            //     'pph_purc_start_date' => (is_null($purchasebeforeedata)) ? $start_date : $purchasebeforeedata->purc_start_date,
            //     'pph_purc_end_date' => (is_null($purchasebeforeedata)) ? $end_date : $purchasebeforeedata->purc_end_date,
            //     'pph_purc_is_cencal' => (is_null($purchasebeforeedata)) ? 1 : $purchasebeforeedata->purc_is_cencal,
            //     'pph_purc_is_expire' => (is_null($purchasebeforeedata)) ? 1 : $purchasebeforeedata->purc_is_expire,
            //     'pph_purchase_id' =>  $adminOruser,
            //     'pph_device' =>  $adminOruser
            // );

            // DB::table('purchase_plan_history')->insert($values);

           Purchase::where('purc_business_id', $request->id)->where('purc_business_type','=',2)->update(array(
               'purc_plan_id' => 3,
               'purc_end_date' => null,
           ));

           if(isset($request->from) && $request->from == 'expire_plan_list'){
                Purchase::where('purc_business_id', $request->id)->where('purc_business_type','=',2)->update(array(
                    'purc_is_expire' => 1, 'purc_tel_status' => 8,
                ));
           } else {
                Purchase::where('purc_business_id', $request->id)->where('purc_business_type','=',2)->update(array(
                    'purc_is_cencal' => 1, 'purc_tel_status' => 8,
                ));
                $this->updateCencalDateInHistoryTable($request->id, 2);
           }

           return response()->json(['status' => true,'message'=>'plan Succesfully cancel']);
    }


    public function getPoliticalUserBusinessFrameList(Request $request){
        $user_id = $request->user_id;
        $business = PoliticalBusiness::select('pb_id','pb_name')->where('user_id','=',$user_id)->where('pb_is_deleted','=',0)->get();

        $frameList = DB::table('user_frames')->leftJoin('political_business','political_business.pb_id','=','user_frames.business_id')->select('user_frames.user_frames_id','user_frames.business_id','user_frames.frame_url','political_business.pb_name')->where('user_frames.user_id','=',$user_id)->where('user_frames.business_type','=',2)->where('user_frames.is_deleted','=',0)->get();

        return response()->json(['data'=> $business, 'status'=>true,'frameList' => $frameList]);
    }

    public function ListofPoliticalBusinessApproval(){

        // $listofbusiness = DB::table('political_business_approval_list')->where('pb_is_approved','=','0')->where('pb_is_deleted','=','0')->join('political_business','political_business.pb_id','=','political_business_approval_list.pb_id')->join('users','political_business.user_id','=','users.id')->orderBy('political_business_approval_list.id', 'ASC')->select('users.name','political_business.pb_name','political_business_approval_list.pbal_name','political_business_approval_list.pbal_party_logo','political_business.pb_party_logo','political_business.pb_id')->get()->toArray();

        $listofbusiness = DB::table('political_business_approval_list')->where('political_business_approval_list.pbal_is_approved','=','0')->where('political_business_approval_list.pbal_is_deleted','=','0')->join('political_business','political_business.pb_id','=','political_business_approval_list.pb_id')->join('users','political_business.user_id','=','users.id')->select('users.name','political_business.pb_name','political_business_approval_list.pbal_name','political_business_approval_list.pbal_party_logo','political_business.pb_party_logo','political_business.pb_id','political_business.pb_left_image','political_business.pb_right_image','political_business_approval_list.pbal_left_image','political_business_approval_list.pbal_right_image')->get()->toArray();
        //   dd($listofbusiness);
        return view('user::politicalApproval',['businesses' => $listofbusiness]);
    }


    public function approvePoliticalbusiness(Request $request){
        $busi_id = $request->id;
        $listofbusiness = DB::table('political_business_approval_list')->where('pb_id','=',$busi_id)->first();

        PoliticalBusiness::where('pb_id',$busi_id)->update([
           'pb_is_approved'=>1,
           'pb_name' => $listofbusiness->pbal_name,
        ]);

        DB::delete('delete from political_business_approval_list where pb_id = ?',[$busi_id]);

        $data = array(
            'route' => 'political_business_approval',
            'id' => $busi_id,
            'name' => $listofbusiness->pbal_name,
            'click_action' => "com.app.activity.RegisterActivity",
        );

        $title = 'Political Business Detail Change Approval';
        $message = 'Your Political Business Detail Change for '.$listofbusiness->pbal_name.' is Approved';
        $type = 'general';


        $message_payload = array (
            'message' => $message,
            'type' => $type,
            'title' => $title,
            'data' => $data,
        );

        PushNotification::sendPushNotification($listofbusiness->user_id,$message_payload);


       return response()->json(['status'=>true,'data'=>""]);
    }

    public function declinePoliticalBusiness(Request $request){
        $busi_id = $request->id;
        $listofbusiness = DB::table('political_business_approval_list')->where('pb_id','=',$busi_id)->first();
        PoliticalBusiness::where('pb_id',$busi_id)->update(['pb_is_approved'=>2]);
        DB::delete('delete from political_business_approval_list where pb_id = ?',[$busi_id]);

        $data = array(
            'route' => 'political_business_decline',
            'id' => $busi_id,
            'name' => $listofbusiness->pbal_name,
            'click_action' => "com.app.activity.RegisterActivity",
        );

        $title = 'Political Business Detail Change Decline';
        $message = 'Your Political Business Detail Change for '.$listofbusiness->pbal_name.' is declined';
        $type = 'general';


        $message_payload = array (
            'message' => $message,
            'type' => $type,
            'title' => $title,
            'data' => $data,
        );

        PushNotification::sendPushNotification($listofbusiness->user_id,$message_payload);

       return response()->json(['status'=>true,'data'=>""]);
    }

    function getBusinessListTypeWise(Request $request){
        $user_id = $request->user_id;
        if($request->b_type == 2){
            $business_detail = DB::table('political_business')->rightJoin('purchase_plan','political_business.pb_id','=','purchase_plan.purc_business_id')->join('users','users.id','=','political_business.user_id')->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('political_business.pb_id','political_business.pb_name')->where('political_business.user_id','=',$user_id)->where('political_business.pb_is_deleted','=','0')->where('purchase_plan.purc_business_type','=',2)->orderBy('purchase_plan.purc_start_date', 'DESC')->get();
        } else {
            $business_detail = DB::table('business')->where('busi_delete','=','0')->where('user_id','=',$user_id)->leftJoin('purchase_plan','business.busi_id','=','purchase_plan.purc_business_id')->join('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->select('business.busi_id','business.busi_name')->get()->toArray();
        }

        return response()->json(['status'=>true,'business_list'=>$business_detail]);
    }
}
