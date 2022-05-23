<?php

namespace App;
use DB;
use Illuminate\Support\Facades\Log;

class PushNotification
{

	public static function sendPushNotification($userId, $payload_data) {
        $deviceTokens = DB::table('user_device')
            ->where('user_id',$userId)
            ->where('is_updated',1)
            ->whereNotNull('device_token')
            ->where('device_token','!=','')
            ->where('device_token','!=','NA')
            ->get();
            // dd($deviceTokens);
	    foreach($deviceTokens as $device) {
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
            if(isset($payload_data['image'])) {
                $payload_data['data']['image'] = $payload_data['image'];
            }
	        $ios_fields = array(
	            'registration_ids' => array($device_token),
	            'data' => $payload_data['data'],
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
	        // Log::info($result);
	        curl_close($ch);
	    }
	}
}
