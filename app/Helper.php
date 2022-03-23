<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Logic\Providers\FacebookRepository;
use App\Permission;
use App\Menu;
use DB;
use Facebook\Facebook;
use App\LinkedIn;
use App\Twitter;
use App\SocialLogin;
use App\LinkedInPage;
use App\FacebookPage;
use App\User;

class Helper extends Model
{

    protected $facebook;

    public function __construct()
    {
        $this->facebook = new FacebookRepository();
    }

    public static function GetLimit()
    {
        return 20;
    }

    public static function generateUniqueReferralCode() {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
        $referral_code = substr(str_shuffle($str_result), 0, 6);
        $checkCode = User::where('ref_code', $referral_code)->first();
        if(empty($referral_code)); {
            return $referral_code;
        }
        return self::generateUniqueReferralCode();
    }

    public static function checkRoutePermission($user_role, $menu_id) {
        if($user_role == 1) {
            return true;
        }
        $checkMenu = Menu::find($menu_id);
        if(empty($checkMenu)) {
            return true;
        }
        if($checkMenu->parent_id != 0) {
            $menu_id = $checkMenu->parent_id;
        }
        $checkPermission = Permission::where('user_role', $user_role)->where('menu_id', $menu_id)->first();
        if($checkPermission) {
            return true;
        }
        return false;
    }

    public static function getFacebookProfile($auth_token) {
        $config = config('services.facebook');
        $fb = new Facebook([
            'app_id' => $config['client_id'],
            'app_secret' => $config['client_secret'],
            'default_graph_version' => 'v2.6',
        ]);
        $fb->setDefaultAccessToken($auth_token);
        try {
            $response = $fb->get('/me?fields=id,name,email,picture')->getGraphNode()->asArray();
            return $response;
        } catch (FacebookSDKException $e) {
            return $e;
        }
    }

    public static function getUserFacebookPages($auth_token) {
        $config = config('services.facebook');
        $fb = new Facebook([
            'app_id' => $config['client_id'],
            'app_secret' => $config['client_secret'],
            'default_graph_version' => 'v2.6',
        ]);
        $fb->setDefaultAccessToken($auth_token);
        try {
            $response = $fb->get('/me/accounts')->getBody();
            return json_decode($response);
        } catch (FacebookSDKException $e) {
            return $e;
        }
    }

    public static function GetInstaBusinessId($pageId,$accessToken)
    {
        $curl_handle=curl_init();
        $access_token = $accessToken;
        $endpoint = $pageId.'?fields=instagram_business_account';
        $data = [];
        $get_post_status = $this->facebook->InstaGetData($accessToken, $endpoint);
        $insta_user_id = $get_post_status['instagram_business_account']['id'];

        if(empty($insta_user_id))
        {
            $insta_user_id = '';
        }
        else
        {
            $endpoint = $insta_user_id.'?fields=biography%2Cid%2Cusername%2Cwebsite%2Cprofile_picture_url';
            $insta_profile = $this->facebook->InstaGetData($accessToken, $endpoint);
            if(!empty($insta_profile))
            {
                $insta_user_id = $insta_profile;
            }
            else
            {
                $insta_user_id = '';
            }
        }
        return $insta_user_id;
        
    }

    public static function checkAccountLinked($user_id, $type) {
        if($type == "twitter") {
            $checkAccount = SocialLogin::where('user_id', $user_id)->where('type', $type)->whereNotNull('access_token_twitter')->whereNotNull('access_token_secret_twitter')->first();
            if(!empty($checkAccount)) {
                return true;
            }
        }
        else {
            $checkAccount = SocialLogin::where('user_id', $user_id)->where('type', $type)->whereNotNull('auth_token')->first();
            if(!empty($checkAccount)) {
                return true;
            }
        }
        return false;
    }

    public static function shareSocialMedia($post_id) {
        $getPost = DB::table('schedule_post')->where('sp_id', $post_id)->first();
        if(!empty($getPost)) {

            $path = Storage::url($getPost->sp_media_path);
            $Twitter_video_path = $getPost->sp_media_path;
            $user_id = $getPost->sp_user_id;
            $sp_media_type = $getPost->sp_media_type;
            $sp_caption = $getPost->sp_caption;
            $sp_hashtag = $getPost->sp_hashtag;

            $social_media_list = DB::table('schedule_post_type')->where('sp_id', $post_id)->get();
            foreach($social_media_list as $social_media) {
                $type = $social_media->social_media_type;
                $profile_page_id = $social_media->profile_page_id;
                self::sharePostToSocialMedia($user_id, $type, $profile_page_id, $path, $sp_media_type, $Twitter_video_path, $sp_caption, $sp_hashtag);
            }

            DB::table('schedule_post')->where('sp_id', $post_id)->update(['is_posted' => 1]);
        }
    }

    public static function sharePostToSocialMedia($user_id, $type, $profile_page_id, $path, $post_type,$Twitter_video_path, $caption, $hashtag) {
        $full_caption = "";
        if($caption != "") {
            $full_caption = $caption . " ";
        }
        if($hashtag != "") {
            $full_caption = $full_caption . $hashtag;
        }
        if($type == 'twitter') {
            self::postToTwitter($user_id, $path, $post_type,$Twitter_video_path, $profile_page_id, $full_caption);
        }
        if($type == 'linkedin') {
            self::postToLinkedIn($user_id, $path, $post_type, $profile_page_id, $full_caption);
        }
        if($type == 'linkedin_page') {
            self::postToLinkedInPage($user_id, $path, $post_type, $profile_page_id, $full_caption);
        }
        if($type == 'facebook') {
            self::postToFacebook($user_id, $path, $profile_page_id, $full_caption, $post_type);
        }
        if($type == 'facebook_page') {
            self::postToFacebookPage($user_id, $path, $profile_page_id, $full_caption, $post_type);
        }
        if($type == 'instagram') {
            self::postToInstgram($user_id, $path, $profile_page_id, $full_caption, $post_type);
        }
    }

    public static function postToTwitter($user_id, $path, $isImage,$Twitter_video_path, $profile_id, $caption){
        $accountData = SocialLogin::where('user_id', $user_id)->where('type', 'twitter')->where('profile_id', $profile_id)->first();
        if(!empty($accountData)) {
            $token = $accountData->access_token_twitter;
            $access_token = $accountData->access_token_secret_twitter;
            if($isImage == 1){
                Twitter::shareImage($token, $access_token, $path, $caption);
            }
            else {
                Twitter::shareVideo($token, $access_token, $Twitter_video_path, $caption);
            }
        }

        // $config = config('services.twitter');
        // Twitter::reconfig(['consumer_key' => $config['consumer_key'], 'consumer_secret' => $config['consumer_secret'], 'token' => $token, 'secret' => $access_token]);

        // $uploaded_media = Twitter::uploadMedia(['media' =>Storage::get($path)]);

        // Twitter::postTweet(['status' => 'Digital Post', 'media_ids' => $uploaded_media->media_id_string, 'response_format' => 'json']);
    }

    public static function postToLinkedIn($user_id, $path, $isImage, $profile_id, $caption){
        $accountData = SocialLogin::where('user_id', $user_id)->where('type', 'linkedin')->where('profile_id', $profile_id)->first();
        if(!empty($accountData)) {
            $token = $accountData->auth_token;
            Log::info($token);
            if($isImage == 1){
                $result = LinkedIn::shareImage($token, $path, $caption, 'access_token');
            } else {
                $result = LinkedIn::shareVideo($token, $path, $caption, 'access_token');
            }
        }
    }

    public static function postToLinkedInPage($user_id, $path, $isImage, $page_id, $caption){
        $page_data = LinkedInPage::where('user_id', $user_id)->where('page_id', $page_id)->first();
        if(!empty($page_data)) {
            $accountData = SocialLogin::where('user_id', $user_id)->where('type', 'linkedin')->where('profile_id', $page_data->profile_id)->first();
            if(!empty($accountData)) {
                $token = $accountData->auth_token;
                Log::info($token);
                if($isImage == 1){
                    $result = LinkedIn::shareImagePage($token, $path, $caption, 'access_token', $page_id);
                } else {
                    $result = LinkedIn::shareVideoPage($token, $path, $caption, 'access_token', $page_id);
                }
            }
        }
    }

    public static function postToFacebook($user_id, $path, $profile_id, $caption, $isImage){
        $accountData = SocialLogin::where('user_id', $user_id)->where('type', 'facebook')->where('profile_id', $profile_id)->first();
        if(!empty($accountData)) {
            $token = $accountData->auth_token;
            $config = config('services.facebook');
            $fb = new Facebook([
                'app_id' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v2.6',
            ]);
            $fb->setDefaultAccessToken($token);
            try {
                $response = $fb->post('/me/feed', [
                    'message' => $caption,
                    'source' => $path
                ])->getGraphNode()->asArray();
                Log::info($response);
                if($response['id']){
                    // post created
                }
            } catch (FacebookSDKException $e) {
            }
        }
    }

    public static function postToFacebookPage($user_id, $path, $page_id, $caption, $isImage){
        $page_data = FacebookPage::where('user_id', $user_id)->where('page_id', $page_id)->first();
        if(!empty($page_data)) {
            $accountData = SocialLogin::where('user_id', $user_id)->where('type', 'facebook')->where('profile_id', $page_data->profile_id)->first();
            if(!empty($accountData)) {
                $token = $page_data->auth_token;
                $config = config('services.facebook');
                $fb = new Facebook([
                    'app_id' => $config['client_id'],
                    'app_secret' => $config['client_secret'],
                    'default_graph_version' => 'v2.6',
                ]);
                $fb->setDefaultAccessToken($token);
                try {
                    if($isImage == 1) {
                        $response = $fb->post('/'.$page_id.'/photos', [
                            'message' => $caption,
                            'url' => $path
                        ])->getGraphNode()->asArray();
                        if($response['id']){
                            // post created
                        }
                    }
                    else {
                        $response = $fb->post('/'.$page_id.'/videos', [
                            'title' => $caption,
                            'file_url' => $path
                        ])->getGraphNode()->asArray();
                        if($response['id']){
                            // post created
                        }
                    }
                } catch (FacebookSDKException $e) {
                }
            }
        }
    }

    public static function postToInstgram($user_id, $path, $profile_id, $caption, $isImage){
        $accountData = SocialLogin::where('user_id', $user_id)->where('type', 'instagram')->where('profile_id', $profile_id)->first();
        if(!empty($accountData)) {
            $token = $accountData->auth_token;
            $config = config('services.facebook');
            $fb = new Facebook([
                'app_id' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v2.6',
            ]);
            $fb->setDefaultAccessToken($token);
            try {
                $endpoint = $profile_id.'/media';
                if($isImage == 1) {
                    $data =  [
                        'message' => $caption,
                        'image_url' => $path
                    ];   
                }
                else {
                    $data =  [
                        'message' => $caption,
                        'media_type' => 'VIDEO',
                        'video_url' => $path
                    ];
                }
                $response = $fb->post($endpoint, $data)->getGraphNode()->asArray();
                if($response['id']){
                    sleep(30);
                    $endpoint_publish = $profile_id.'/media_publish?creation_id='.$response['id'];
                    $responsePublish = $fb->post($endpoint_publish, array())->getGraphNode()->asArray();
                    dd($responsePublish);
                    // post created
                }
            } catch (FacebookSDKException $e) {
            }
        }
    }

    public static function deleteDuplicateDevice($device_id) {
        $userDevices = UserDevice::where('device_id', $device_id)->orderBy('id', 'DESC')->get();
        foreach ($userDevices as $key => $device) {
            if($key != 0) {
                $device->delete();
            }
        }
    }

    public static function getSocialTypeData($post_id) {
        $twitter = DB::table('schedule_post_type')->where('sp_id', $post_id)->where('social_media_type', 'twitter')->get();
        $twitter_list = array();
        foreach ($twitter as $key => $value) {
            $data = SocialLogin::where('type', 'twitter')->where('profile_id', $value->profile_page_id)->first();
            if(!empty($data)) {
                array_push($twitter_list, $data);
            }
        }

        $linkedin = DB::table('schedule_post_type')->where('sp_id', $post_id)->where('social_media_type', 'linkedin')->get();
        $linkedin_list = array();
        foreach ($linkedin as $key => $value) {
            $data = SocialLogin::where('type', 'linkedin')->where('profile_id', $value->profile_page_id)->first();
            if(!empty($data)) {
                array_push($linkedin_list, $data);
            }
        }

        $facebook = DB::table('schedule_post_type')->where('sp_id', $post_id)->where('social_media_type', 'facebook')->get();
        $facebook_list = array();
        foreach ($facebook as $key => $value) {
            $data = SocialLogin::where('type', 'facebook')->where('profile_id', $value->profile_page_id)->first();
            if(!empty($data)) {
                array_push($facebook_list, $data);
            }
        }

        $instagram = DB::table('schedule_post_type')->where('sp_id', $post_id)->where('social_media_type', 'instagram')->get();
        $instagram_list = array();
        foreach ($instagram as $key => $value) {
            $data = SocialLogin::where('type', 'instagram')->where('profile_id', $value->profile_page_id)->first();
            if(!empty($data)) {
                array_push($instagram_list, $data);
            }
        }

        $linkedin_page = DB::table('schedule_post_type')->where('sp_id', $post_id)->where('social_media_type', 'linkedin_page')->get();
        $linkedin_page_list = array();
        foreach ($linkedin_page as $key => $value) {
            $data = LinkedInPage::where('page_id', $value->profile_page_id)->first();
            if(!empty($data)) {
                array_push($linkedin_page_list, $data);
            }
        }

        $facebook_page = DB::table('schedule_post_type')->where('sp_id', $post_id)->where('social_media_type', 'facebook_page')->get();
        $facebook_page_list = array();
        foreach ($facebook_page as $key => $value) {
            $data = FacebookPage::where('page_id', $value->profile_page_id)->first();
            if(!empty($data)) {
                array_push($facebook_page_list, $data);
            }
        }

        $data = ['twitter' => $twitter_list,'linkedin' => $linkedin_list,'facebook' => $facebook_list,'instagram' => $instagram_list,'linkedin_page' => $linkedin_page_list,'facebook_page' => $facebook_page_list];
        return $data;
    }

    public static function createRazorPayContact($user_id) {
        $user = User::find($user_id);
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/contacts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "name": "'.$user->name.'",
          "contact": '.$user->mobile.',
          "type": "customer"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode(getenv('RAZORPAY_API_KEY').':'.getenv('RAZORPAY_API_SECRET')),
          ),
        ));
        /* notes, refrence_id, email optional*/
        $response = curl_exec($curl);

        curl_close($curl);
        $coutactsData = json_decode($response);
        if(isset($coutactsData->error))
        {
            return ['status'=> false, 'error' => $coutactsData->error->description];
        }
        else
        {
            return ['status'=> true, 'contact_id' => $coutactsData->id];
        }
    }

    public static function createRazorPayFundAccount($contact_id, $upi) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/fund_accounts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "contact_id": "'.$contact_id.'",
          "account_type": "vpa",
          "vpa": {
            "address": "'.$upi.'"
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode(getenv('RAZORPAY_API_KEY').':'.getenv('RAZORPAY_API_SECRET')),
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $coutactsData = json_decode($response);
        if(isset($coutactsData->error))
        {
            return ['status'=> false, 'error' => $coutactsData->error->description];
        }
        else
        {
            return ['status'=> true, 'fund_id' => $coutactsData->id];
        }
    }

    public static function payoutByFundAccount($fund_id, $amount)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "account_number": "'.getenv('RAZORPAY_ACCOUNT_NUMBER').'",
          "fund_account_id": "'.$fund_id.'",
          "amount": '.($amount * 100).',
          "currency": "INR",
          "mode": "UPI",
          "queue_if_low_balance": true,
          "purpose": "payout"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode(getenv('RAZORPAY_API_KEY').':'.getenv('RAZORPAY_API_SECRET')),
            //'Authorization: Basic '.base64_encode('env('RAZORPAY_KEY'):env('RAZORPAY_SECRET')'),
          ),
        ));
        /* env('RAZORPAY_KEY'), env('RAZORPAY_SECRET') */
        /* queue_if_low_balance, reference_id, narration,notes  optional,  acountnumber show rozerpay deshbord*/
        /*amout  10 * 100 */
        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if(empty($response->error->description)) {
            return ['status'=> true, 'payment_id' => $response->id];
        }
        else {
            return ['status'=> false, 'error' => $response->error->description];
        }
    }

}