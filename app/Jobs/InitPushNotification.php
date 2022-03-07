<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\PushNotificationScheduled;
use App\Jobs\SendPushNotification;
use DB;
use App\User;
use App\PoliticalBusiness;

class InitPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificationId;
    protected $offset;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notificationId, $offset = 0)
    {
        $this->notificationId = $notificationId;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("notification Job Called");
        $notification = PushNotificationScheduled::find($this->notificationId);
        if(!empty($notification)) {
            $message = $notification->message;
            $title = $notification->title;
            $type = 'general';
            $route = $notification->notification_type;
            $id = $notification->notification_for;
            $name = "";
            if($route == "Normal Business Categories") {
                $name = $id;
                $data = DB::table('business_category')->where('name', $id)->first();
                if($data) {
                    $id = $data->id;
                    $name = $data->name;
                }
            }
            if($route == "Political Business Categories") {
                $data = PoliticalBusiness::where('pb_id', $id)->first();
                if($data) {
                    $name = $data->pb_name;
                }
            }
            if($route == "Festivals") {
                $data = DB::table('festival_data')->where('fest_id', $id)->first();
                if($data) {
                    $name = $data->fest_name;
                }
            }
            if($route == "Greetings") {
                $data = DB::table('custom_cateogry')->where('custom_cateogry_id', $id)->first();
                if($data) {
                    $name = $data->name;
                }
            }
            $data = array(
                'route' => $route,
                'id' => $id,
                'name' => $name,
                'click_action' => "com.app.activity.RegisterActivity",
            );
            $image = "";
            if(!empty($notification->image)) {
                $image = Storage::url($notification->image);
            }
            // $image = "";
            // $message = "This is test notification";
            // $title = "This is test notification";
            $message_payload = array (
                'image' => $image,
                'message' => $message,
                'type' => $type,
                'title' => $title,
                'data' => $data,
            );
            $isusers = true;
            $business_users = array();
            if($notification->notification_type == "Normal Business Categories") {
                $business_users = DB::table('business')->where('business.busi_delete','=','0')->where('business_category', $notification->notification_for)->join('users', 'users.default_business_id','=','business.busi_id')->where('users.status', 0)->distinct('business.user_id')->orderBy('business.user_id')->offset($this->offset)->limit(500)->pluck('business.user_id')->toArray();
                if(count($business_users) == 0) {
                    $isusers = false;
                }
            }
            if($notification->notification_type == 'Political Business Categories') {
                $business_users = PoliticalBusiness::where('political_business.pb_is_deleted', 0)->where('political_business.pb_is_approved', 1)->where('political_business.pb_pc_id', $notification->notification_for)->join('users', 'users.default_political_business_id','=','political_business.pb_id')->where('users.status', 0)->distinct('political_business.user_id')->orderBy('political_business.user_id')->offset($this->offset)->limit(500)->pluck('political_business.user_id')->toArray();
                if(count($business_users) == 0) {
                    $isusers = false;
                }
            }
            if($notification->notification_type == 'Offer') {
                if($notification->notification_for == "Normal Business") {
                    $business_users = DB::table('business')->where('business.busi_delete', 0)->leftJoin('users', 'users.id','=','business.user_id')->where('users.status', 0)->distinct('business.user_id')->orderBy('business.user_id')->offset($this->offset)->limit(500)->pluck('business.user_id')->toArray();
                }
                else {
                    $business_users = PoliticalBusiness::where('political_business.pb_is_deleted', 0)->where('political_business.pb_is_approved', 1)->leftJoin('users', 'users.id','=','political_business.user_id')->where('users.status', 0)->distinct('political_business.user_id')->orderBy('political_business.user_id')->offset($this->offset)->limit(500)->pluck('political_business.user_id')->toArray();
                }
                if(count($business_users) == 0) {
                    $isusers = false;
                }
            }
            if($notification->user_type == "All") {
                if($isusers) {
                    if(count($business_users)) {
                        $userids = $business_users;
                        // $userids = User::where('users.status', 0)->whereIn('users.id', $business_users)->offset($this->offset)->limit(500)->pluck('users.id')->toArray();
                    }
                    else {
                        $userids = User::where('users.status', 0)->offset($this->offset)->limit(500)->pluck('users.id')->toArray();
                    }
                    if(count($userids) > 0) {
                        SendPushNotification::dispatch($userids, $message_payload, $notification->user_type, $notification->notification_type, $notification->notification_for);
                        $this->offset = $this->offset + count($userids);
                        InitPushNotification::dispatch($this->notificationId, $this->offset);
                    }
                }
            }
            if($notification->user_type == "Premium") {
                if($isusers) {
                    if(count($business_users)) {
                        $userids = $business_users;
                        // $userids = User::where('users.status', 0)->whereIn('users.id', $business_users)->leftJoin('purchase_plan', 'purchase_plan.purc_user_id','=','users.id')->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->offset($this->offset)->limit(500)->pluck('purchase_plan.purc_user_id')->toArray();
                    }
                    else {
                        $userids = User::where('users.status', 0)->leftJoin('purchase_plan', 'purchase_plan.purc_user_id','=','users.id')->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->offset($this->offset)->limit(500)->pluck('purchase_plan.purc_user_id')->toArray();
                    }
                    if(count($userids) > 0) {
                        SendPushNotification::dispatch($userids, $message_payload, $notification->user_type, $notification->notification_type, $notification->notification_for);
                        $this->offset = $this->offset + count($userids);
                        InitPushNotification::dispatch($this->notificationId, $this->offset);
                    }
                }
            }
            if($notification->user_type == "Free") {
                if($isusers) {
                    if(count($business_users)) {
                        $userids = $business_users;
                        // $userids = User::where('users.status', 0)->whereIn('users.id', $business_users)->leftJoin('purchase_plan', 'purchase_plan.purc_user_id','=','users.id')->where('purchase_plan.purc_plan_id',3)->distinct('.purchase_plan.purc_user_id')->offset($this->offset)->limit(500)->pluck('purchase_plan.purc_user_id')->toArray();
                    }
                    else {
                        $userids = User::where('users.status', 0)->leftJoin('purchase_plan', 'purchase_plan.purc_user_id','=','users.id')->where('purchase_plan.purc_plan_id',3)->distinct('.purchase_plan.purc_user_id')->offset($this->offset)->limit(500)->pluck('purchase_plan.purc_user_id')->toArray();
                    }
                    if(count($userids) > 0) {
                        SendPushNotification::dispatch($userids, $message_payload, $notification->user_type, $notification->notification_type, $notification->notification_for);
                        $this->offset = $this->offset + count($userids);
                        InitPushNotification::dispatch($this->notificationId, $this->offset);
                    }
                }
            }
        }
    }
}
