<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use DB;
use App\User;

class SendPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userIds;
    protected $payload;
    protected $user_type;
    protected $notification_type;
    protected $notification_for;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userIds, $payload, $user_type, $notification_type, $notification_for)
    {
        $this->userIds = $userIds;
        $this->payload = $payload;
        $this->user_type = $user_type;
        $this->notification_type = $notification_type;
        $this->notification_for = $notification_for;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->userIds as $userId) {
            $isProcced = false;
            if($this->user_type == "All") {
                $checkUser = User::where('users.status', 0)->where('users.id', $userId)->pluck('users.id')->toArray();
                if(count($checkUser) > 0) {
                    $isProcced = true;
                }
            }
            if($this->user_type == "Premium") {
                if($this->notification_type == "Normal Business Categories") {
                    $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                }
                else if($this->notification_type == "Political Business Categories") {
                    $checkUser = User::where('users.status', 0)->where('users.default_political_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_political_business_id')->where('purchase_plan.purc_business_type', 2)->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                }
                else if($this->notification_type == "Offer") {
                    if($this->notification_for == "Normal Business") {
                        $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                    } 
                    else {
                        $checkUser = User::where('users.status', 0)->where('users.default_political_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_political_business_id')->where('purchase_plan.purc_business_type', 2)->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                    }
                }
                else {
                    $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id','!=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                }

                if(count($checkUser) > 0) {
                    $isProcced = true;
                }
            }
            if($this->user_type == "Free") {
                if($this->notification_type == "Normal Business Categories") {
                    $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id','=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                }
                else if($this->notification_type == "Political Business Categories") {
                    $checkUser = User::where('users.status', 0)->where('users.default_political_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_political_business_id')->where('purchase_plan.purc_business_type', 2)->where('purchase_plan.purc_plan_id','=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                }
                else if($this->notification_type == "Offer") {
                    if($this->notification_for == "Normal Business") {
                        $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id','=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                    } 
                    else {
                        $checkUser = User::where('users.status', 0)->where('users.default_political_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_political_business_id')->where('purchase_plan.purc_business_type', 2)->where('purchase_plan.purc_plan_id','=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                    }
                }
                else {
                    $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id','=',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                }
                // $checkUser = User::where('users.status', 0)->where('users.default_business_id', '!=' ,0)->where('users.id', $userId)->leftJoin('purchase_plan', 'purchase_plan.purc_business_id','=','users.default_business_id')->where('purchase_plan.purc_business_type', 1)->where('purchase_plan.purc_plan_id',3)->distinct('.purchase_plan.purc_user_id')->pluck('purchase_plan.purc_user_id')->toArray();
                if(count($checkUser) > 0) {
                    $isProcced = true;
                }
            }
            if($isProcced) {
                $deviceTokens = DB::table('user_device')
                                ->where('user_id',$userId)
                                ->where('is_updated',1)
                                ->whereNotNull('device_token')
                                ->where('device_token','!=','')
                                ->where('device_token','!=','NA')
                                ->get();
                foreach($deviceTokens as $device) {
                    $payload_data = $this->payload;
                    $device_token = $device->device_token;
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $priority="high";
                    $notification=array_merge(array('title' => $payload_data['title'],'body' => $payload_data['message']),$payload_data);
                    $android_fields = array(
                        'registration_ids' => array($device_token),
                        'notification' => $notification,
                        'data' => isset($payload_data['data']) ? $payload_data['data'] : array(),
                        'content_available'=> true,
                        'priority'=>$priority
                    );

                    $payload_data['data']['title'] = $payload_data['title'];
                    $payload_data['data']['body'] = $payload_data['message'];
                    $payload_data['data']['image'] = $payload_data['image'];
                    $ios_fields = array(
                        'registration_ids' => array($device_token),
                        'data' => $this->payload['data'],
                        // 'notification' => $notification,
                        'content_available'=> true,
                        'priority'=>$priority
                    );

                    $headers = array(
                    'Authorization:key=AAAAl_NGkoI:APA91bEq7EQDA9YiSLP4778gJVBrsI15UI7TfeQ8r7M44a_TrVMYJajS1LZYRO618GRgA8ciRVTdh_TEY-bd-X-xFGLILZJZmxLCQrC0KdAM-b24d5W0SEZSOja7lL1MSxR_GihjcLKa',
                    'Content-Type: application/json'
                    );

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    if($device->device_type == "Android")
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($android_fields));
                    else
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ios_fields));
                    $result = curl_exec($ch);
                    Log::info($result);
                    curl_close($ch);
                }
            }
        }
    }
}
