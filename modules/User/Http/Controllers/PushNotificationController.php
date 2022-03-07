<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Jobs\InitPushNotification;
use App\PoliticalCategory;
use App\PushNotificationScheduled;
use App\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DataTables;
use DB;
use Validator;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::push-notification');
    }

    public function changeNotificationType(Request $request) {
        $notification_type = $request->notification_type;
        $data = array();
        if($notification_type == 1){
            $data = DB::table('business_category')->where('is_delete',0)->get()->toArray();
        }
        if($notification_type == 2){
            $data = PoliticalCategory::where('pc_is_deleted', 0)->get()->toArray();
        }
        if($notification_type == 3){
            $data1 = DB::table('festival_data')->whereDate('fest_date', '>=',Carbon::now())->where('fest_is_delete',0)->where('fest_type','festival')->get()->toArray();
            $data2 = DB::table('festival_data')->where('fest_is_delete',0)->where('fest_type','incident')->get()->toArray();
            $data = array_merge($data1, $data2);
        }
        if($notification_type == 4){
            $data = DB::table('custom_cateogry')->get()->toArray();
        }
        if($notification_type == 5){
            $data = array('Normal Business', 'Political Business');
        }
        return response()->json(['status' => true,'data' => $data ]);
    }

    public function schedule_notification(Request $request) {
        $validator = Validator::make($request->all(), [
                'user_type' => 'required',      
                'notification_type' => 'required',      
                'notification_for' => 'required',      
                'title' => 'required',      
                'message' => 'required',      
            ],
            [
                'user_type.required' => 'User Type Required',
                'notification_type.required' => 'Notification Type Required',
                'notification_for.required' => 'Notification For Required',
                'title.required' => 'Title Required',
                'message.required' => 'Message Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        if($request->is_scheduled) {
            $validator = Validator::make($request->all(), [
                    'scheduled_date' => 'required',      
                ],
                [
                    'scheduled_date.required' => 'Scheduled Date Required',
                ]
            );

            if ($validator->fails()) 
            {  
                $error=json_decode($validator->errors());          

                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }
        }

        $notification_type = "NormalCategories";
        if($request->notification_type == 1) {
            $notification_type = "Normal Business Categories";
        }
        if($request->notification_type == 2) {
            $notification_type = "Political Business Categories";
        }
        if($request->notification_type == 3) {
            $notification_type = "Festivals";
        }
        if($request->notification_type == 4) {
            $notification_type = "Greetings";
        }
        if($request->notification_type == 5) {
            $notification_type = "Offer";
        }

        $image_name = "";
        if($request->hasFile('image')) {
            $image_name = $this->uploadFile($request, null, 'image', 'notification-image'); 
        }

        $pushNotification = new PushNotificationScheduled();
        $pushNotification->user_type = $request->user_type;
        $pushNotification->notification_type = $notification_type;
        $pushNotification->notification_for = $request->notification_for;
        $pushNotification->title = $request->title;
        $pushNotification->message = $request->message;
        $pushNotification->image = $image_name;
        $pushNotification->is_scheduled = $request->is_scheduled;
        if(!$request->is_scheduled) {
            $pushNotification->scheduled_date = Carbon::now();
            $pushNotification->status = "Completed";
        }
        else {
            $pushNotification->scheduled_date = Carbon::parse($request->scheduled_date);
        }
        $pushNotification->save();
        if(!$request->is_scheduled) {
            InitPushNotification::dispatch($pushNotification->id);
        }

        return response()->json(['status' => 1,'data' => "", 'message' => 'Notification Scheduled' ]);
    }

    public function getPendingNotification(Request $request) {
        $notifications = PushNotificationScheduled::where('is_delete',0)->where('status','Pending')->orderBy('scheduled_date','ASC');
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($notifications)
            ->addIndexColumn()
            ->editColumn('notification_for',function($row) {
                $notification_for = "";
                if($row->notification_type == "Normal Business Categories") {
                    $notification_for = $row->notification_for;
                }
                if($row->notification_type == "Political Business Categories") {
                    $categoryData = PoliticalCategory::where('pc_id', $row->notification_for)->first();
                    if($categoryData) {
                        $notification_for = $categoryData->pc_name;
                    }
                }
                if($row->notification_type == 'Festivals') {

                    $categoryData = DB::table('festival_data')->where('fest_id', $row->notification_for)->where('fest_is_delete',0)->where('fest_type','festival')->first();
                    if($categoryData) {
                        $notification_for = $categoryData->fest_name;
                    }
                }
                if($row->notification_type == 'Greetings') {
                    $categoryData = DB::table('custom_cateogry')->where('custom_cateogry_id',$row->notification_for)->first();
                    if($categoryData) {
                        $notification_for = $categoryData->name;
                    }
                }
                if($row->notification_type == 'Offer') {
                    $notification_for = $row->notification_for;
                }

                return $notification_for;
            })
            ->editColumn('is_scheduled',function($row) {
                if($row->is_scheduled) {
                    return true;
                }
                return false;
            })
            ->editColumn('image',function($row) {
                $img = "";
                if($row->image != "") {
                    $img = '<img src="'.Storage::url($row->image).'" height="100" width="100">';
                }
                return $img;
            })
            ->addColumn('action',function($row) {
                $btn = '<button class="btn btn-primary btn-sm mb-2 mt-2" data-id="'.$row->id.'" onclick="editNotification(this)"><i class="flaticon-pencil"></i></button><br />';
                $btn .= '<button class="btn btn-danger btn-sm mb-2" data-id="'.$row->id.'" onclick="deleteNotification(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                return $btn;
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
        }
    }

    public function getCompletedNotification(Request $request) {
        $notifications = PushNotificationScheduled::where('is_delete',0)->where('status','Completed')->orderBy('updated_at','DESC');
        
        if ($request->ajax())
        {
            # code...
            return DataTables::of($notifications)
            ->addIndexColumn()
            ->editColumn('notification_for',function($row) {
                $notification_for = "";
                if($row->notification_type == "Normal Business Categories") {
                    $notification_for = $row->notification_for;
                }
                if($row->notification_type == "Political Business Categories") {
                    $categoryData = PoliticalCategory::where('pc_id', $row->notification_for)->first();
                    if($categoryData) {
                        $notification_for = $categoryData->pc_name;
                    }
                }
                if($row->notification_type == 'Festivals') {

                    $categoryData = DB::table('festival_data')->where('fest_id', $row->notification_for)->where('fest_is_delete',0)->where('fest_type','festival')->first();
                    if($categoryData) {
                        $notification_for = $categoryData->fest_name;
                    }
                }
                if($row->notification_type == 'Greetings') {
                    $categoryData = DB::table('custom_cateogry')->where('custom_cateogry_id',$row->notification_for)->first();
                    if($categoryData) {
                        $notification_for = $categoryData->name;
                    }
                }
                if($row->notification_type == 'Offer') {
                    $notification_for = $row->notification_for;
                }
                return $notification_for;
            })
            ->editColumn('is_scheduled',function($row) {
                if($row->is_scheduled) {
                    return true;
                }
                return false;
            })
            ->editColumn('image',function($row) {
                $img = "";
                if($row->image != "") {
                    $img = '<img src="'.Storage::url($row->image).'" height="100" width="100">';
                }
                return $img;
            })
            ->rawColumns(['image'])
            ->make(true);
        }
    }

    public function deletePushNotification(Request $request) {
        $notification_id = $request->id;
        $PushNotificationScheduled = PushNotificationScheduled::find($notification_id);
        if($PushNotificationScheduled) {
            $PushNotificationScheduled->is_delete = 1;
        }
        $PushNotificationScheduled->save();
        return response()->json(['status' => true,'data' => "", 'message' => 'Scheduled Notification Deleted' ]);
    }

    public function editPushNotification(Request $request) {
        $data = PushNotificationScheduled::find($request->id);
        if(empty($data)) {
            return response()->json(['status' => false,'message' => "Data Not Found"]);
        }
        if($data->notification_type == "Normal Business Categories") {
            $data->notification_type = 1;
        }
        if($data->notification_type == "Political Business Categories") {
            $data->notification_type = 2;
        }
        if($data->notification_type == "Festivals") {
            $data->notification_type = 3;
        }
        if($data->notification_type == "Greetings") {
            $data->notification_type = 4;
        }
        if($data->notification_type == "Offer") {
            $data->notification_type = 5;
        }

        $notification_for = array();
        if($data->notification_type == 1){
            $notification_for = DB::table('business_category')->where('is_delete',0)->get()->toArray();
        }
        if($data->notification_type == 2){
            $notification_for = PoliticalCategory::where('pc_is_deleted', 0)->get()->toArray();
        }
        if($data->notification_type == 3){
            $notification_for = DB::table('festival_data')->whereDate('fest_date', '>=',Carbon::now())->where('fest_is_delete',0)->where('fest_type','festival')->get()->toArray();
        }
        if($data->notification_type == 4){
            $notification_for = DB::table('custom_cateogry')->get()->toArray();
        }
        if($data->notification_type == 5){
            $notification_for = array('Normal Business', 'Political Business');
        }

        $data->scheduled_date = Carbon::parse($data->scheduled_date)->format('Y-m-d') . 'T'.Carbon::parse($data->scheduled_date)->format('H:i:s');
        return response()->json(['status' => true,'data' => $data, 'notification_for' => $notification_for]);
    }

    public function updatePushNotification(Request $request) {
        $validator = Validator::make($request->all(), [
                'edit_id' => 'required',      
                'edit_user_type' => 'required',      
                'edit_notification_type' => 'required',      
                'edit_notification_for' => 'required',      
                'edit_title' => 'required',      
                'edit_message' => 'required',      
            ],
            [
                'edit_id.required' => 'Id Required',
                'edit_user_type.required' => 'User Type Required',
                'edit_notification_type.required' => 'Notification Type Required',
                'edit_notification_for.required' => 'Notification For Required',
                'edit_title.required' => 'Title Required',
                'edit_message.required' => 'Message Required',
            ]
        );

        if ($validator->fails()) 
        {  
            $error=json_decode($validator->errors());          

            return response()->json(['status' => 401,'error1' => $error]);
            exit();
        }

        if($request->edit_is_scheduled) {
            $validator = Validator::make($request->all(), [
                    'edit_scheduled_date' => 'required',      
                ],
                [
                    'edit_scheduled_date.required' => 'Scheduled Date Required',
                ]
            );

            if ($validator->fails()) 
            {  
                $error=json_decode($validator->errors());          

                return response()->json(['status' => 401,'error1' => $error]);
                exit();
            }
        }
        $notification_type = "NormalCategories";
        if($request->edit_notification_type == 1) {
            $notification_type = "Normal Business Categories";
        }
        if($request->edit_notification_type == 2) {
            $notification_type = "Political Business Categories";
        }
        if($request->edit_notification_type == 3) {
            $notification_type = "Festivals";
        }
        if($request->edit_notification_type == 4) {
            $notification_type = "Greetings";
        }
        if($request->edit_notification_type == 5) {
            $notification_type = "Offer";
        }

        $image_name = "";
        if($request->hasFile('edit_image')) {
            $image_name = $this->uploadFile($request, null, 'edit_image', 'notification-image'); 
        }

        $pushNotification = PushNotificationScheduled::find($request->edit_id);
        $pushNotification->user_type = $request->edit_user_type;
        $pushNotification->notification_type = $notification_type;
        $pushNotification->notification_for = $request->edit_notification_for;
        $pushNotification->title = $request->edit_title;
        $pushNotification->message = $request->edit_message;
        if($image_name != "") {
            $pushNotification->image = $image_name;
        }
        $pushNotification->is_scheduled = $request->edit_is_scheduled;
        if(!$request->edit_is_scheduled) {
            $pushNotification->scheduled_date = Carbon::now();
            $pushNotification->status = "Completed";
            InitPushNotification::dispatch($pushNotification->id);
        }
        else {
            $pushNotification->scheduled_date = Carbon::parse($request->edit_scheduled_date);
        }
        $pushNotification->save();

        return response()->json(['status' => 1,'data' => "", 'message' => 'Notification Scheduled' ]);
    }
}
