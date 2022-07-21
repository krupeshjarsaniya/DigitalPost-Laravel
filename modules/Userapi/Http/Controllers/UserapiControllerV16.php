<?php

namespace Modules\Userapi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Business;
use App\Post;
use App\Festival;
use App\Purchase;
use App\Photos;
use App\Plan;
use App\Language;
use App\VideoData;
use App\StickerCategory;
use App\BackgroundCategory;
use App\LinkedInPage;
use App\FacebookPage;
use Illuminate\Support\Facades\DB;
use GDText\Box;
use GDText\Color;
use App\UserDevice;
use App\Helper;
use Illuminate\Support\Facades\Storage;
use App\LinkedIn;
use App\Twitter;
use App\PoliticalCategory;
use App\PoliticalLogo;
use App\PoliticalBusiness;
use App\PoliticalBusinessApprovalList;
use App\Popup;
use App\FestivalSubCategory;
use App\CustomSubCategory;
use App\BusinessSubCategory;
use App\GraphicCategory;
use App\VideoSubCategory;
use App\SocialLogin;
use App\UserReferral;
use App\ReferralData;
use App\WithdrawRequest;
use App\PaymentDetail;
use App\Frame;
use App\FrameField;
use App\FrameComponent;
use App\FrameText;
use App\BusinessField;
use Carbon\Carbon;
use App\Jobs\ShareSocialPostJob;
use App\Logic\Providers\FacebookRepository;
use App\MusicCategory;
use App\Music;
use App\BGCreditPlan;
use App\BGCreditPlanHistory;
use App\UserDownloadHistory;
use App\BackgroundRemoveRequest;
use App\ContentCreator;
use App\Distributor;

class UserapiControllerV16 extends Controller
{
    public $successStatus = 200;

    protected $facebook;

    public function __construct()
    {
        $this->facebook = new FacebookRepository();
    }

    public function sendRegisterOTP(Request $request)
    {
        $input = $request->all();
        $name = $input['name'];
        $country_code = $input['country_code'];
        $mobile = $input['mobile'];
        $referral_code = isset($request->referral_code) ? $request->referral_code : "";

        $checkUser = User::where('mobile', $mobile)->first();
        if ($checkUser) {
            if ($checkUser->status == 1) {
                return response()->json(['status' => false, 'message' => 'You were blocked']);
            }
            if ($checkUser->is_verified) {
                if ($checkUser->country_code == 0) {
                    $checkUser->country_code = $country_code;
                }
                $checkUser->save();
                return response()->json(['status' => false, 'message' => 'Mobile Already Registered']);
            } else {
                $otp = rand(100000, 999999);
                $result = $this->sendOTP($country_code, $mobile, $otp);
                if (!$result) {
                    return response()->json(['status' => false, 'message' => 'OTP not sent']);
                }
                $referral_by = 0;
                if ($referral_code != "") {
                    $checkReferralCode = User::where('ref_code', $referral_code)->first();
                    if (empty($checkReferralCode)) {
                        return response()->json(['status' => false, 'message' => 'Invalid referral code']);
                    }
                    $referral_by = $checkReferralCode->id;
                }
                $checkUser->name = $name;
                $checkUser->country_code = $country_code;
                $checkUser->mobile = $mobile;
                $checkUser->otp = $otp;
                $checkUser->used_referral_code = $referral_code;
                $checkUser->referral_by = $referral_by;
                $checkUser->password = bcrypt($name . '@123');

                $settingData = DB::table('setting')->first();
                $register_credit = 0;
                if (!empty($settingData)) {
                    $register_credit = $settingData->register_credit;
                }
                $checkUser->bg_credit = $register_credit;

                $checkUser->save();
                return response()->json(['status' => true, 'message' => 'OTP sent to you mobile']);
            }
        }
        $otp = rand(100000, 999999);
        $result = $this->sendOTP($country_code, $mobile, $otp);
        if (!$result) {
            return response()->json(['status' => false, 'message' => 'OTP not sent']);
        }
        $referral_by = 0;
        if ($referral_code != "") {
            $checkReferralCode = User::where('ref_code', $referral_code)->first();
            if (empty($checkReferralCode)) {
                return response()->json(['status' => false, 'message' => 'Invalid referral code']);
            }
            $referral_by = $checkReferralCode->id;
        }

        $settingData = DB::table('setting')->first();
        $register_credit = 0;
        if (!empty($settingData)) {
            $register_credit = $settingData->register_credit;
        }

        $user = new User;
        $user->name = $name;
        $user->country_code = $country_code;
        $user->mobile = $mobile;
        $user->otp = $otp;
        $user->used_referral_code = $referral_code;
        $user->referral_by = $referral_by;
        $user->password = bcrypt($name . '@123');
        $user->bg_credit = $register_credit;
        $user->save();
        return response()->json(['status' => true, 'message' => 'OTP sent to you mobile']);
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $country_code = $input['country_code'];
        $mobile = $input['mobile'];
        $otp = $input['otp'];

        $token = Hash::make($input['name'], [
            'rounds' => 12
        ]);
        $ref_code = Str::random(6);

        $user = User::where('mobile', $mobile)->where('country_code', $country_code)->first();
        if ($user) {
            if ($user->status == 1) {
                return response()->json(['status' => false, 'message' => 'You were blocked']);
            }
            if ($user->otp != $otp) {
                return response()->json(['status' => false, 'message' => 'Invalid OTP']);
            }
            $user->password = bcrypt($input['name'] . '@123');
            $user->remember_token = $token;
            $user->device_id = $input['device_id'];
            $user->device = $input['device'];
            $user->device_token = $input['device_token'];
            $user->otp = 0;
            $user->is_verified = 1;
            $user->save();

            $newuserid = $user->id;
            if ($user->referral_by != 0) {

                $addReferralData = new ReferralData;
                $addReferralData->ref_by_user_id = $user->referral_by;
                $addReferralData->ref_user_id = $newuserid;
                $addReferralData->save();
                $settingData = DB::table('setting')->first();
                $referral_amount = 0;
                if (!empty($settingData)) {
                    $referral_amount = $settingData->referral_amount;
                }

                $userReferralData = UserReferral::where('user_id', $user->referral_by)->first();
                $total_earning = $userReferralData->total_earning + $referral_amount;
                $current_balance = $userReferralData->current_balance + $referral_amount;
                $userReferralData->total_earning = $total_earning;
                $userReferralData->current_balance = $current_balance;
                $userReferralData->save();
            }


            Helper::deleteDuplicateDevice($input['device_id']);

            $userdeviceinsert = UserDevice::where('device_id', $input['device_id'])->first();
            if (empty($userdivece)) {
                $userdeviceinsert = new UserDevice;
                $userdeviceinsert->device_id = $input['device_id'];
                $userdeviceinsert->device_type = $input['device'];
            }

            $userdeviceinsert->user_id = $newuserid;
            $userdeviceinsert->remember_token = $token;
            if ($input['device_token'] != "abc") {
                $userdeviceinsert->device_token = $input['device_token'];
                $userdeviceinsert->is_updated = 1;
            } else {
                $userdeviceinsert->device_token = "";
            }
            $userdeviceinsert->save();

            $user = User::find($newuserid);

            $users = array();
            $user_data = array();


            $user_data['id'] = strval($user->id);
            $user_data['name'] = !empty($user->name) ? $user->name : "";
            $user_data['mobile'] = !empty($user->mobile) ? $user->mobile : "";
            $user_data['email'] = !empty($user->email) ? $user->email : "";
            $user_data['device'] = !empty($user->device) ? $user->device : "";
            array_push($users, $user_data);

            return response()->json(['data' => $users, 'token' => $token, 'status' => true, 'message' => 'Register Successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid Mobile number']);
        }
    }

    public function sendLoginOTP(Request $request)
    {
        $input = $request->all();
        $country_code = $input['country_code'];
        $mobile = $input['mobile'];

        $checkUser = User::where('mobile', $mobile)->where('is_verified', 1)->first();
        if (empty($checkUser)) {
            return response()->json(['status' => false, 'message' => 'user not found']);
        }
        if ($checkUser->status == 1) {
            return response()->json(['status' => false, 'message' => 'You were blocked']);
        }
        if ($checkUser->country_code == 0) {
            $checkUser->country_code = $country_code;
        }
        if ($mobile == '3030303030') {
            $otp = '123456';
        } else {
            $otp = rand(100000, 999999);
            $result = $this->sendOTP($country_code, $mobile, $otp);
            if (!$result) {
                return response()->json(['status' => false, 'message' => 'OTP not sent']);
            }
        }
        $checkUser->otp = $otp;
        $checkUser->save();
        return response()->json(['status' => true, 'message' => 'OTP sent to you mobile']);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $country_code = $input['country_code'];
        $mobile = $input['mobile'];
        $otp = $input['otp'];
        $user = User::where('mobile', '=', $mobile)->where('country_code', $country_code)->where('is_verified', 1)->first();

        if (!empty($user) || $user != '') {
            if ($user->status == 0) {
                $token = Hash::make($user->email, [
                    'rounds' => 12
                ]);
                if ($user->otp != $otp) {
                    return response()->json(['status' => false, 'message' => 'Invalid OTP']);
                }
                $user->otp = 0;
                $user->is_verified = 1;

                Helper::deleteDuplicateDevice($input['device_id']);

                $userdeviceinsert = UserDevice::where('device_id', $input['device_id'])->first();

                if (empty($userdeviceinsert) || $userdeviceinsert == '') {
                    $userdeviceinsert = new UserDevice;
                    $userdeviceinsert->device_id = $input['device_id'];
                    $userdeviceinsert->device_type = $input['device'];
                }
                $userdeviceinsert->user_id = $user->id;
                $userdeviceinsert->remember_token = $token;
                if ($input['device_token'] != "abc") {
                    $userdeviceinsert->device_token = $input['device_token'];
                    $userdeviceinsert->is_updated = 1;
                } else {
                    $userdeviceinsert->device_token = "";
                }
                $userdeviceinsert->save();

                $isbusiness = false;

                if ($user->default_business_id != '' || $user->default_business_id != 0) {
                    $isbusiness = true;
                }
                $data = array();
                $users = array();

                $data['id'] = strval($user->id);
                $data['name'] = !empty($user->name) ? $user->name : "";
                $data['mobile'] = !empty($user->mobile) ? $user->mobile : "";
                $data['email'] = !empty($user->email) ? $user->email : "";
                $data['device'] = !empty($input['device']) ? $input['device'] : "";
                array_push($users, $data);
                $user->save();

                return response()->json(['data' => $users, 'token' => $token, 'status' => true, 'message' => 'Login Successfully', 'isbusiness' => $isbusiness]);
            } else if ($user->status == 1) {
                return response()->json(['status' => false, 'message' => 'You were blocked']);
            } else {
                return response()->json(['status' => false, 'message' => 'You were removed']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Mobile number not registered. Please register first']);
        }
    }

    public function logout(Request $request)
    {
        $input = $request->all();

        $user = UserDevice::where('remember_token', $input['token'])->first();
        if (!empty($user)) {
            $user->delete();
        }

        return response()->json(['status' => true, 'message' => 'Logout Successfully']);
    }

    public function updateDeviceToken(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $device_id = $input['device_id'];
        $device_type = $input['device_type'];
        $device_token = $input['device_token'];

        $currentDevice = UserDevice::where('device_id', $device_id)
                                    ->where('device_type', $device_type)
                                    ->where('user_id', $user_id)
                                    ->where('remember_token', $input['token'])
                                    ->first();
        if (empty($currentDevice)) {
            return response()->json(['status' => false, 'message' => 'Device not found', 'data' => 0]);
        }

        $getOldDevices = UserDevice::where('device_id', $device_id)->where('device_type', $device_type)->where('id', '!=', $currentDevice->id)->get();
        foreach ($getOldDevices as $key => $device) {
            $device->delete();
        }

        if ($device_token == 'abc') {
            $currentDevice->device_token = "";
            $currentDevice->is_updated = 0;
            $currentDevice->save();
            return response()->json(['status' => false, 'message' => 'Device token not found', 'data' => 0]);
        }
        $currentDevice->device_token = $device_token;
        $currentDevice->is_updated = 1;
        $currentDevice->save();
        return response()->json(['status' => true, 'message' => 'Device token updated', 'data' => 1]);
    }

    public function checkMobile(Request $request)
    {
        $input = $request->all();

        $user = User::where('mobile', '=', $input['mobile'])->first();
        if (!empty($user)) {
            return response()->json(['status' => false, 'message' => 'mobile number already exist']);
        } else {
            return response()->json(['status' => true, 'message' => 'mobile number not exist']);
        }
    }
    // ------------------------------------ Profile Apis -------------------------------------------------

    public function editMyProfile(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        } else {
            if ($request['email'] != "") {
                User::where('id', $user_id)->update(array(
                    'name' => $request['name'],
                    'email' => $request['email'],
                ));
            } else {
                User::where('id', $user_id)->update(array(
                    'name' => $request['name'],
                ));
            }

            $data = array();

            $data['name'] = !empty($request['name']) ? $request['name'] : "";
            $data['email'] = !empty($request['email']) ? $request['email'] : "";

            return response()->json(['status' => true, 'message' => 'Account Information Successfully Update', 'data' => $data]);
        }
    }
    public function getMyProfile(Request $request)
    {

        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $userdata = User::where('id', '=', $user_id)->first()->toArray();

        $newdata = array_map(function ($v) {
            return (is_null($v)) ? "" : $v;
        }, $userdata);

        if ($userdata != null || !empty($userdata) || $userdata != '') {

            return response()->json(['data' => $newdata, 'status' => true, 'message' => 'user valid']);
        } else {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
    }

    public function get_userid($token)
    {

        $userdata = UserDevice::where('remember_token', '=', $token)->select('user_id')->first();
        if ($userdata != null || !empty($userdata) || $userdata != '') {
            $user_id = $userdata->user_id;
            $user = User::where('id', $user_id)->where('status', 0)->first();
            if (empty($user)) {
                $user_id = 0;
            }
        } else {
            $user_id = 0;
        }
        return $user_id;
    }

    // ------------------------------------ Business Apis -------------------------------------------------

    public function addBusiness(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $name = $input['name'];
        $email = $input['email'];
        $mobile = isset($input['mobile']) ? $input['mobile'] : "";
        $mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $hashtag = (isset($input['hashtag'])) ? $input['hashtag'] : '';
        $website = $input['website'];
        $address = $input['address'];
        $logo = $request->file('logo');
        $logo_dark = $request->file('logo_dark');
        $watermark = $request->file('watermark');
        $watermark_dark = $request->file('watermark_dark');
        $business_category = $input['business_category'];
        $path = '';
        $watermark_path = '';
        $path_dark = '';
        $watermark_dark_path = '';

        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $twitter =  isset($input['twitter']) ? $input['twitter'] : "";
        $instagram =  isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin =  isset($input['linkedin']) ? $input['linkedin'] : "";
        $youtube =  isset($input['youtube']) ? $input['youtube'] : "";

        if ($watermark != null) {
            $watermark_path  =  $this->uploadFile($request, null, "watermark", 'business-img');
        }
        if ($logo != null) {
            $path  =  $this->uploadFile($request, null, "logo", 'business-img');
        }

        if ($watermark_dark != null) {
            $watermark_dark_path  =  $this->uploadFile($request, null, "watermark_dark", 'business-img');
        }
        if ($logo_dark != null) {
            $path_dark  =  $this->uploadFile($request, null, "logo_dark", 'business-img');
        }

        $business = new Business();
        $business->busi_name = $name;
        $business->user_id = $user_id;
        $business->busi_email = $email;
        $business->busi_website = $website;
        $business->busi_mobile = $mobile;
        $business->busi_mobile_second = $mobile_second;
        $business->busi_address = $address;
        $business->busi_logo = $path;
        $business->watermark_image = $watermark_path;
        $business->busi_logo_dark = $path_dark;
        $business->watermark_image_dark = $watermark_dark_path;
        $business->business_category = $business_category;
        $business->hashtag = $hashtag;
        $business->busi_facebook = $facebook;
        $business->busi_twitter = $twitter;
        $business->busi_instagram = $instagram;
        $business->busi_linkedin = $linkedin;
        $business->busi_youtube = $youtube;
        $business->save();

        $business_id = $business->busi_id;

        $start_date = date('Y-m-d');

        $purchase = new Purchase();
        $purchase->purc_user_id = $user_id;
        $purchase->purc_business_id = $business_id;
        $purchase->purc_plan_id = 3;
        $purchase->purc_start_date = $start_date;
        $purchase->save();

        $userdata = User::where('id', '=', $user_id)->select('default_business_id')->first();

        if ($userdata->default_business_id == 0 || $userdata->default_business_id == '') {
            User::where('id', $user_id)->update(array(
                'default_business_id' => $business_id,
            ));
        }

        $logoBackgroundRemove = isset($input['logoBackgroundRemove']) ? $input['logoBackgroundRemove'] : 0;
        $watermarkBackgroundRemove = isset($input['watermarkBackgroundRemove']) ? $input['watermarkBackgroundRemove'] : 0;
        $logoDarkBackgroundRemove = isset($input['logoDarkBackgroundRemove']) ? $input['logoDarkBackgroundRemove'] : 0;
        $watermarkDarkBackgroundRemove = isset($input['watermarkDarkBackgroundRemove']) ? $input['watermarkDarkBackgroundRemove'] : 0;

        $backgroundRemoveRequest = BackgroundRemoveRequest::where('business_type', 1)->where('business_id', $business_id)->first();

        if($logoBackgroundRemove == 0 && $watermarkBackgroundRemove == 0 && $logoDarkBackgroundRemove == 0 && $watermarkDarkBackgroundRemove == 0){
            if(!empty($backgroundRemoveRequest)) {
                $backgroundRemoveRequest->delete();
            }
        }
        else {
            if(empty($backgroundRemoveRequest)) {
                $backgroundRemoveRequest = new BackgroundRemoveRequest;
                $backgroundRemoveRequest->user_id = $user_id;
                $backgroundRemoveRequest->business_type = 1;
                $backgroundRemoveRequest->business_id = $business_id;
            }
            $backgroundRemoveRequest->remove_logo = $logoBackgroundRemove;
            $backgroundRemoveRequest->remove_watermark = $watermarkBackgroundRemove;
            $backgroundRemoveRequest->remove_logo_dark = $logoDarkBackgroundRemove;
            $backgroundRemoveRequest->remove_watermark_dark = $watermarkDarkBackgroundRemove;
            $backgroundRemoveRequest->save();
        }


        return response()->json(['status' => true, 'message' => 'Data successfully Added']);

    }

    public function getcurrntbusinesspreornot(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $userdata = User::where('id', '=', $user_id)->select('default_business_id')->first();


        $currntbusiness = Business::where('busi_id', '=', $userdata->default_business_id)->first();

        $ispreminum = false;
        if ($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != '') {

            $priminum = Purchase::where('purc_business_id', '=', $userdata->default_business_id)->where('purc_plan_id', '=', 2)->first();



            if (!empty($priminum) || $priminum != null || $priminum != '') {
                $ispreminum = true;
            } else {
                $ispreminum = false;
            }

            return response()->json(['data' => $currntbusiness, 'status' => true, 'message' => 'data recived', 'premium' => $ispreminum]);
        } else {
            return response()->json(['status' => false, 'message' => "you havent't set current business yet"]);
        }
    }

    public function markascurrentbusiness(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $business_id = $input['business_id'];

        User::where('id', $user_id)->update(array(
            'default_business_id' => $business_id,
        ));
        $user_data = User::find($user_id);
        $frameList = DB::table('user_frames')->where('user_id', '=', $user_id)->where('business_id', '=', $user_data->default_business_id)->where('is_deleted', '=', 0)->orderBy('user_frames_id', 'DESC')->get();

        $frameLists = array();

        foreach ($frameList as $key => $value) {
            $data = array();

            $data['business_id'] = strval($value->business_id);
            $data['date_added'] = !empty($value->date_added) ? $value->date_added : "";
            $data['frame_url'] = !empty($value->frame_url) ? Storage::url($value->frame_url) : "";
            $data['user_frames_id'] = strval($value->user_frames_id);
            $data['user_id'] = strval($value->user_id);

            array_push($frameLists, $data);
        }


        $currntbusiness = Business::where('busi_id', '=', $user_data->default_business_id)->where('busi_delete', '=', 0)->first();

        $updatedCurrentBusinessDetails = array();

        $ispreminum = false;
        if ($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != '') {
            $priminum = Purchase::where('purc_business_id', '=', $user_data->default_business_id)->select('purc_id', 'purc_plan_id', 'purc_start_date', 'purc_end_date')->first();

            if (!empty($priminum) || $priminum != null || $priminum != '') {
                $start_dates = date('Y-m-d');
                if ($priminum->purc_plan_id == 1) {
                    $plantrial = Plan::where('plan_sku', '=', '000FREESKU')->select('plan_validity')->first();
                    $start_date = strtotime($start_dates);
                    $end_date = strtotime($priminum->end_date);
                    $days = ($end_date - $start_date) / 60 / 60 / 24;
                    if ($days > $plantrial->plan_validity && $days > 0) {
                        $ispreminum = false;
                    } else {
                        $ispreminum = true;
                    }
                }
                if ($priminum->purc_plan_id == 3) {

                    $ispreminum = false;
                }

                if ($priminum->purc_plan_id == 2) {
                    $ispreminum = true;
                }
            } else {
                $ispreminum = false;
            }


            $updatedCurrentBusinessDetails['busi_id'] = strval($currntbusiness->busi_id);
            $updatedCurrentBusinessDetails['user_id'] = strval($currntbusiness->user_id);
            $updatedCurrentBusinessDetails['busi_name'] = !empty($currntbusiness->busi_name) ? $currntbusiness->busi_name : "";
            $updatedCurrentBusinessDetails['busi_logo'] = !empty($currntbusiness->busi_logo) ? Storage::url($currntbusiness->busi_logo) : "";
            $updatedCurrentBusinessDetails['busi_mobile'] = !empty($currntbusiness->busi_mobile) ? $currntbusiness->busi_mobile : "";
            $updatedCurrentBusinessDetails['busi_mobile_second'] = !empty($currntbusiness->busi_mobile_second) ? $currntbusiness->busi_mobile_second : "";
            $updatedCurrentBusinessDetails['busi_email'] = !empty($currntbusiness->busi_email) ? $currntbusiness->busi_email : "";
            $updatedCurrentBusinessDetails['busi_address'] = !empty($currntbusiness->busi_address) ? $currntbusiness->busi_address : "";
            $updatedCurrentBusinessDetails['busi_website'] = !empty($currntbusiness->busi_website) ? $currntbusiness->busi_website : "";
            $updatedCurrentBusinessDetails['business_category'] = !empty($currntbusiness->business_category) ? $currntbusiness->business_category : "";
            $updatedCurrentBusinessDetails['busi_is_approved'] = strval($currntbusiness->busi_is_approved);
            $updatedCurrentBusinessDetails['busi_delete'] = strval($currntbusiness->busi_delete);
            $updatedCurrentBusinessDetails['busi_facebook'] = strval($currntbusiness->busi_facebook);
            $updatedCurrentBusinessDetails['busi_twitter'] = strval($currntbusiness->busi_twitter);
            $updatedCurrentBusinessDetails['busi_instagram'] = strval($currntbusiness->busi_instagram);
            $updatedCurrentBusinessDetails['busi_linkedin'] = strval($currntbusiness->busi_linkedin);
            $updatedCurrentBusinessDetails['busi_youtube'] = strval($currntbusiness->busi_youtube);

            $p_plan = Purchase::where('purc_user_id', $user_id)->where('purc_business_id', $user_data->default_business_id)->get();
            $plan_name = "";
            if (count($p_plan) != 0) {
                foreach ($p_plan as $key => $value) {
                    if ($value->purc_is_cencal == 0 && $value->purc_is_expire == 0) {
                        if ($value->purc_plan_id == 2) {
                            $plan_name = 'Premium';
                        } elseif ($value->purc_plan_id == 3) {
                            $plan_name = 'Free';
                        }
                    } else {
                        $plan_name = 'Free';
                    }
                }
            } else {
                $plan_name = 'Free';
            }

            $updatedCurrentBusinessDetails['plan_name'] = $plan_name;
        } else {
            $currntbusiness = "you havent't set current business yet";
        }



        return response()->json(['status' => true, 'message' => 'Set successfuly', 'frameList' => $frameLists, 'current_business' => $updatedCurrentBusinessDetails]);
    }

    public function updateBusiness(Request $request)
    {

        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $getBusiness = Business::where('busi_id', '=', $input['id'])->where('user_id', $user_id)->first();
        if (empty($getBusiness)) {
            return response()->json(['status' => false, 'message' => 'Something goes wrong']);
        }
        $id = $input['id'];

        $name = $input['name'];
        $email = $input['email'];
        $mobile = isset($input['mobile']) ? $input['mobile'] : '';
        $website = $input['website'];
        $address = $input['address'];
        $mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $hashtag = (isset($input['hashtag'])) ? $input['hashtag'] : '';
        $logo = $request->file('logo');
        $logo_dark = $request->file('logo_dark');
        $watermark = $request->file('watermark');
        $watermark_dark = $request->file('watermark_dark');
        $business_category = (isset($input['business_category'])) ? $input['business_category'] : "";
        $currntbusiness = Business::where('busi_id', '=', $id)->select('busi_name', 'busi_logo', 'watermark_image', 'busi_logo_dark', 'watermark_image_dark')->first();
        $watermark_path = '';

        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $twitter =  isset($input['twitter']) ? $input['twitter'] : "";
        $instagram =  isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin =  isset($input['linkedin']) ? $input['linkedin'] : "";
        $youtube =  isset($input['youtube']) ? $input['youtube'] : "";

        if (!is_null($currntbusiness)) {

            $namechange = false;
            if ($currntbusiness->busi_name != $name) {
                $namechange = true;
                $name = $input['name'];
            } else {
                $namechange = false;
                $name = $currntbusiness->busi_name;
            }

            if ($watermark != null) {
                $watermark_path  =  $this->uploadFile($request, null, "watermark", 'business-img');
            } else {
                $watermark_path = $currntbusiness->watermark_image;
            }

            if ($logo != null) {
                $path  =  $this->uploadFile($request, null, "logo", 'business-img');
            } else {
                $path = $currntbusiness->busi_logo;
            }

            if ($logo_dark != null) {
                $path_dark  =  $this->uploadFile($request, null, "logo_dark", 'business-img');
            } else {
                $path_dark = $currntbusiness->busi_logo_dark;
            }

            if ($watermark_dark != null) {
                $watermark_path_dark  =  $this->uploadFile($request, null, "watermark_dark", 'business-img');
            } else {
                $watermark_path_dark = $currntbusiness->watermark_image_dark;
            }

            if ($namechange) {


                Business::where('busi_id', $id)->update(array(
                    'busi_is_approved' => 0
                ));

                $_isBusinessAvail = DB::table('business_new')->where('busi_id_old', '=', $id)->select('user_id_new')->first();
                $_isPremiumUser = DB::table('purchase_plan')->where('purc_business_type', 1)->where('purc_business_id', '=', $id)->where('purc_plan_id', '!=', 3)->first();

                if (!empty($_isPremiumUser) || $_isPremiumUser != '' || $_isPremiumUser != null) {

                    if (is_null($_isBusinessAvail)) {
                        DB::table('business_new')->insert(
                            [
                                'busi_name_new' => $name,
                                'user_id_new' => $user_id,
                                'busi_email_new' => $email,
                                'busi_website_new' => $website,
                                'busi_mobile_new' => $mobile,
                                'busi_mobile_second_new' => $mobile_second,
                                'busi_address_new' => $address,
                                'busi_logo_new' => $path,
                                'busi_is_approved_new' => 0,
                                'busi_id_old' => $id,
                                'business_category' => $business_category,

                            ]
                        );
                        Business::where('busi_id', $id)->update(array(
                            'busi_email' => $email,
                            'user_id' => $user_id,
                            'busi_website' => $website,
                            'busi_mobile' => $mobile,
                            'busi_mobile_second' => $mobile_second,
                            'busi_address' => $address,
                            'business_category' => $business_category,
                            'hashtag' => $hashtag,
                            'watermark_image' => $watermark_path,
                            'busi_facebook' => $facebook,
                            'busi_twitter' => $twitter,
                            'busi_instagram' => $instagram,
                            'busi_linkedin' => $linkedin,
                            'busi_youtube' => $youtube,
                            'busi_logo' => $path,

                        ));
                    } else {
                        DB::table('business_new')
                            ->where('busi_id_old', $id)
                            ->update([
                                'busi_name_new' => $name,
                                'user_id_new' => $user_id,
                                'busi_email_new' => $email,
                                'busi_website_new' => $website,
                                'busi_mobile_new' => $mobile,
                                'busi_mobile_second_new' => $mobile_second,
                                'busi_address_new' => $address,
                                'busi_logo_new' => $path,
                                'busi_is_approved_new' => 0,
                                'busi_id_old' => $id,
                                'business_category' => $business_category,

                            ]);
                        Business::where('busi_id', $id)->update(array(
                            'busi_email' => $email,
                            'user_id' => $user_id,
                            'busi_website' => $website,
                            'busi_mobile' => $mobile,
                            'busi_mobile_second' => $mobile_second,
                            'busi_address' => $address,
                            'business_category' => $business_category,
                            'hashtag' => $hashtag,
                            'watermark_image' => $watermark_path,
                            'watermark_image_dark' => $watermark_path_dark,
                            'busi_facebook' => $facebook,
                            'busi_twitter' => $twitter,
                            'busi_instagram' => $instagram,
                            'busi_linkedin' => $linkedin,
                            'busi_youtube' => $youtube,
                            'busi_logo' => $path,
                            'busi_logo_dark' => $path_dark,

                        ));
                    }
                    $message = 'Please wait till admin approves your changes!';
                } else {
                    Business::where('busi_id', $id)->update(array(
                        'busi_name' => $name,
                        'busi_email' => $email,
                        'user_id' => $user_id,
                        'busi_website' => $website,
                        'busi_logo' => $path,
                        'busi_logo_dark' => $path_dark,
                        'busi_mobile' => $mobile,
                        'busi_mobile_second' => $mobile_second,
                        'busi_address' => $address,
                        'business_category' => $business_category,
                        'hashtag' => $hashtag,
                        'watermark_image' => $watermark_path,
                        'watermark_image_dark' => $watermark_path_dark,
                        'busi_facebook' => $facebook,
                        'busi_twitter' => $twitter,
                        'busi_instagram' => $instagram,
                        'busi_linkedin' => $linkedin,
                        'busi_youtube' => $youtube,

                    ));
                    $message = 'Business Information Update';
                }
            } else {
                Business::where('busi_id', $id)->update(array(
                    'busi_email' => $email,
                    'user_id' => $user_id,
                    'busi_website' => $website,
                    'busi_mobile' => $mobile,
                    'busi_mobile_second' => $mobile_second,
                    'busi_address' => $address,
                    'business_category' => $business_category,
                    'hashtag' => $hashtag,
                    'watermark_image' => $watermark_path,
                    'busi_facebook' => $facebook,
                    'busi_twitter' => $twitter,
                    'busi_instagram' => $instagram,
                    'busi_linkedin' => $linkedin,
                    'busi_youtube' => $youtube,
                    'busi_logo' => $path,
                    'busi_logo_dark' => $path_dark,
                    'watermark_image_dark' => $watermark_path_dark,
                ));

                $message = 'Business Information Update';
            }

            $logoBackgroundRemove = isset($input['logoBackgroundRemove']) ? $input['logoBackgroundRemove'] : 0;
            $watermarkBackgroundRemove = isset($input['watermarkBackgroundRemove']) ? $input['watermarkBackgroundRemove'] : 0;
            $logoDarkBackgroundRemove = isset($input['logoDarkBackgroundRemove']) ? $input['logoDarkBackgroundRemove'] : 0;
            $watermarkDarkBackgroundRemove = isset($input['watermarkDarkBackgroundRemove']) ? $input['watermarkDarkBackgroundRemove'] : 0;

            $backgroundRemoveRequest = BackgroundRemoveRequest::where('business_type', 1)->where('business_id', $id)->first();

            if($logoBackgroundRemove == 0 && $watermarkBackgroundRemove == 0 && $logoDarkBackgroundRemove == 0 && $watermarkDarkBackgroundRemove == 0){
                if(!empty($backgroundRemoveRequest)) {
                    $backgroundRemoveRequest->delete();
                }
            }
            else {
                if(empty($backgroundRemoveRequest)) {
                    $backgroundRemoveRequest = new BackgroundRemoveRequest;
                    $backgroundRemoveRequest->user_id = $user_id;
                    $backgroundRemoveRequest->business_type = 1;
                    $backgroundRemoveRequest->business_id = $id;
                }
                $backgroundRemoveRequest->remove_logo = $logoBackgroundRemove;
                $backgroundRemoveRequest->remove_watermark = $watermarkBackgroundRemove;
                $backgroundRemoveRequest->remove_logo_dark = $logoDarkBackgroundRemove;
                $backgroundRemoveRequest->remove_watermark_dark = $watermarkDarkBackgroundRemove;
                $backgroundRemoveRequest->save();
            }

            return response()->json(['status' => true, 'message' => $message]);

        } else {
            return response()->json(['status' => false, 'message' => 'Record not Found']);
        }
    }


    public function getmyallbusiness(Request $request)
    {

        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $user = User::where('id', $user_id)->first();

        $listofbusiness = DB::table('business')->where('business.user_id', '=', $user_id)->where('business.busi_delete', '=', 0)->leftJoin('purchase_plan', 'business.busi_id', '=', 'purchase_plan.purc_business_id')->leftJoin(
            'plan',
            'purchase_plan.purc_plan_id',
            '=',
            'plan.plan_id'
        )->select('business.busi_id', 'busi_logo_dark', 'watermark_image_dark', 'business.busi_name', 'business.business_category', 'business.busi_email', 'business.busi_address', 'business.busi_mobile', 'business.busi_mobile_second', 'business.busi_logo', 'business.watermark_image', 'business.busi_website', 'plan.plan_name', 'plan.plan_id', 'purchase_plan.purc_start_date', 'purchase_plan.purc_end_date', 'purchase_plan.purc_plan_id', 'business.watermark_image', 'business.busi_facebook', 'business.busi_instagram', 'business.busi_twitter', 'business.busi_linkedin', 'business.busi_youtube', 'purchase_plan.purc_is_expire')->distinct()->get()->toArray();

        $listofbusiness = array_map(function ($value) {
            return (array)$value;
        }, $listofbusiness);

        $finalarr = array();
        for ($i = 0; $i < count($listofbusiness); $i++) {

            $newdata = array_map(function ($v) {
                return (is_null($v)) ? "" : $v;
            }, $listofbusiness[$i]);

            array_push($finalarr, $newdata);
        }

        $finale_array = array();
        $start_dates = date('Y-m-d');
        foreach ($finalarr as $business) {
            if (!empty($business['busi_logo'])) {
                $business['busi_logo'] = Storage::url($business['busi_logo']);
            }
            if (!empty($business['watermark_image'])) {
                $business['watermark_image'] = Storage::url($business['watermark_image']);
            }

            if (!empty($business['busi_logo_dark'])) {
                $business['busi_logo_dark'] = Storage::url($business['busi_logo_dark']);
            }
            if (!empty($business['watermark_image_dark'])) {
                $business['watermark_image_dark'] = Storage::url($business['watermark_image_dark']);
            }

            if ($business['plan_id'] == 1 || $business['plan_id'] == 3) {
                $business['need_to_upgrade'] = 1;
            } else {
                $business['need_to_upgrade'] = 0;
            }

            if ($business['busi_id'] == $user->default_business_id) {
                $val_busi = 1;
                $business['is_current_business'] = strval($val_busi);
            } else {
                $val_busi = 0;
                $business['is_current_business'] = strval($val_busi);
            }

            if ($business['purc_plan_id'] != 3 || $business['purc_plan_id'] != "3") {
                $plantrial = Plan::where('plan_sku', '=', 'Free')->select('plan_validity')->first();
                $start_date = strtotime($business['purc_start_date']);
                $end_date = strtotime($business['purc_end_date']);
                $today = strtotime(date('Y-m-d'));
                if ($today > $end_date && ($business['purc_is_expire'] == 1 || $business['purc_is_expire'] == "1")) {
                    $business['remaining_days'] = '0 Days';
                } else {
                    $days = ($end_date - $today) / 60 / 60 / 24;
                    $business['remaining_days'] = $days . ' Days';
                }
            } else {
                $business['remaining_days'] = '0 Days';
            }

            array_push($finale_array, $business);
        }

        return response()->json(['data' => $finale_array, 'status' => true, 'message' => 'List of all business']);
    }

    public function removeMyBusiness(Request $request)
    {

        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $getbusiness = Business::where('busi_id', $input['id'])->where('user_id', $user_id)->first();
        if (empty($getbusiness)) {
            return response()->json(['status' => false, 'message' => 'Something goes wrong']);
        }
        $userdata = User::where('id', '=', $user_id)->select('default_business_id')->first();

        if ($userdata->default_business_id != $input['id']) {

            Business::where('busi_id', $input['id'])->update(array(
                'busi_delete' => 1,
            ));
            Photos::where('photo_business_id', $input['id'])->update(array(
                'photo_is_delete' => 1,
            ));

            return response()->json(['status' => true, 'message' => 'Business Succesfully Removed']);
        } else {

            Business::where('busi_id', $input['id'])->update(array(
                'busi_delete' => 1,
            ));
            Photos::where('photo_business_id', $input['id'])->update(array(
                'photo_is_delete' => 1,
            ));

            $currntbusiness = Business::where('user_id', '=', $user_id)->where('busi_delete', '=', 0)->select('busi_id')->first();

            if (!empty($currntbusiness) || !is_null($currntbusiness)) {
                User::where('id', $user_id)->update(array(
                    'default_business_id' => $currntbusiness->busi_id,
                ));
            } else {
                User::where('id', $user_id)->update(array(
                    'default_business_id' => 0,
                ));
            }
            return response()->json(['status' => true, 'message' => 'Business Succesfully Removed']);
        }

    }

    // ------------------------------------ Homepage Apis -------------------------------------------------


    public function getthisMonthsFestival(Request $request)
    {

        $date = date('Y-m');

        $currnt_date = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime($currnt_date . ' -1 day'));
        $next_date = date('Y-m-d', strtotime($currnt_date . ' +1 day'));


        $slider = Festival::whereDate('fest_date', '>=', $currnt_date)->where('fest_type', 'festival')->where('fest_is_delete', 0)->orderBy('fest_date', 'asc')->get();

        for ($i = 0; $i < sizeof($slider); $i++) {
            if ($slider[$i]['fest_date'] == $currnt_date) {
                $slider[$i]['current_date'] = true;
            } else {
                $slider[$i]['current_date'] = false;
            }
            $slider[$i]['fest_day'] = date_parse_from_format('Y-m-d', $slider[$i]['fest_date'])['day'];
            $slider[$i]['fest_date'] = date("d-m-Y", strtotime($slider[$i]['fest_date']));
        }

        $festivals = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type', '=', 'festival')->where('fest_is_delete', '=', 0)->get();

        for ($i = 0; $i < sizeof($festivals); $i++) {
            $festivals[$i]['fest_day'] = date_parse_from_format('Y-m-d', $festivals[$i]['fest_date'])['day'];
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
        }

        $incedents = Festival::where('fest_type', '=', 'incident')->where('fest_is_delete', '=', 0)->get();
        $incedentsArray = array();
        for ($i = 0; $i < sizeof($incedents); $i++) {
            $incedents[$i]['fest_day'] = date_parse_from_format('Y-m-d', $incedents[$i]['fest_date'])['day'];
            $photo = Post::where('post_category_id', '=', $incedents[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'post_category_id')->orderBy('post_id', 'DESC')->get();
            $temp['title'] = $incedents[$i]['fest_name'];
            $temp['img_url'] = $photo;
            $temp['information'] = $incedents[$i]['fest_info'];
            $temp['fest_image'] = $incedents[$i]['fest_image'];
            $temp['fest_id'] = $incedents[$i]['fest_id'];
            array_push($incedentsArray, $temp);
        }

        // ----------------------------- Get current business
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $userdata = User::where('id', '=', $user_id)->select('default_business_id')->first();

        $currntbusiness = Business::where('busi_id', '=', $userdata->default_business_id)->where('busi_delete', '=', 0)->first();

        $updatedCurrentBusinessDetails = array();
        $preference = DB::table('user_preference')->where('user_id', '=', $user_id)->get();

        $ispreminum = false;
        if ($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != '') {
            $priminum = Purchase::where('purc_business_id', '=', $userdata->default_business_id)->select('purc_id', 'purc_plan_id', 'purc_start_date', 'purc_end_date')->first();

            if (!empty($priminum) || $priminum != null || $priminum != '') {
                $start_dates = date('Y-m-d');
                if ($priminum->purc_plan_id == 1) {
                    $plantrial = Plan::where('plan_sku', '=', '000FREESKU')->select('plan_validity')->first();
                    $start_date = strtotime($start_dates);
                    $end_date = strtotime($priminum->end_date);
                    $days = ($end_date - $start_date) / 60 / 60 / 24;
                    if ($days > $plantrial->plan_validity && $days > 0) {
                        $ispreminum = false;
                    } else {
                        $ispreminum = true;
                    }
                }
                if ($priminum->purc_plan_id == 3) {
                    $ispreminum = false;
                }

                if ($priminum->purc_plan_id == 2) {
                    $ispreminum = true;
                }
            } else {
                $ispreminum = false;
            }


            $updatedCurrentBusinessDetails['busi_id'] = $currntbusiness->busi_id;
            $updatedCurrentBusinessDetails['user_id'] = $currntbusiness->user_id;
            $updatedCurrentBusinessDetails['busi_name'] = $currntbusiness->busi_name;
            $updatedCurrentBusinessDetails['busi_logo'] = $currntbusiness->busi_logo;
            $updatedCurrentBusinessDetails['busi_mobile'] = $currntbusiness->busi_mobile;
            $updatedCurrentBusinessDetails['busi_email'] = $currntbusiness->busi_email;
            $updatedCurrentBusinessDetails['busi_address'] = $currntbusiness->busi_address;
            $updatedCurrentBusinessDetails['busi_website'] = $currntbusiness->busi_website;
            $updatedCurrentBusinessDetails['busi_is_approved'] = $currntbusiness->busi_is_approved;
            $updatedCurrentBusinessDetails['busi_delete'] = $currntbusiness->busi_delete;
            $updatedCurrentBusinessDetails['busi_facebook'] = $currntbusiness->busi_facebook;
            $updatedCurrentBusinessDetails['busi_twitter'] = $currntbusiness->busi_twitter;
            $updatedCurrentBusinessDetails['busi_instagram'] = $currntbusiness->busi_instagram;
            $updatedCurrentBusinessDetails['busi_linkedin'] = $currntbusiness->busi_linkedin;
            $updatedCurrentBusinessDetails['busi_youtube'] = $currntbusiness->busi_youtube;
            $updatedCurrentBusinessDetails['watermark_image'] = '';
            if (!empty($currntbusiness['watermark_image'])) {
                $updatedCurrentBusinessDetails['watermark_image'] = Storage::url($currntbusiness['watermark_image']);
            }

            if (!empty($preference)) {

                foreach ($preference as $value) {
                    if ($value->preference_value == 1) {
                        $updatedCurrentBusinessDetails['busi_logo'] = '';
                    }
                    if ($value->preference_value == 2) {
                        $updatedCurrentBusinessDetails['busi_mobile'] = '';
                    }
                    if ($value->preference_value == 3) {
                        $updatedCurrentBusinessDetails['busi_email'] = '';
                    }
                    if ($value->preference_value == 4) {
                        $updatedCurrentBusinessDetails['busi_address'] = '';
                    }
                    if ($value->preference_value == 5) {
                        $updatedCurrentBusinessDetails['busi_website'] = '';
                    }
                    if ($value->preference_value == 6) {
                        $updatedCurrentBusinessDetails['busi_name'] = '';
                    }
                }
            }
        } else {
            $currntbusiness = "you havent't set current business yet";
        }

        $userstatus = User::where('remember_token', '=', $input['token'])->select('status')->first();

        $logout = false;

        if ($userstatus->status == 1 || $userstatus->status == 2) {
            $logout = true;
        }

        $frameList = DB::table('user_frames')->where('user_id', '=', $user_id)->where('business_id', '=', $userdata->default_business_id)->where('is_deleted', '=', 0)->orderBy('user_frames_id', 'DESC')->get();

        if (!empty($frameList)) {
            foreach ($frameList as &$frame) {
                $frame->frame_url = Storage::url($frame->frame_url);
            }
        }

        $sharemsg = '';
        $credit = DB::table('setting')->where('setting_id', '=', 1)->select('whatsapp')->first();
        if ($credit->whatsapp == '' || is_null($credit->whatsapp)) {
            $sharemsg = '';
        } else {
            $sharemsg = $credit->whatsapp;
        }
        if (!empty($festivals) || !empty($incedents)) {
            return response()->json(['slider' => $slider, 'festival' => $festivals, 'incidents' => $incedentsArray, 'status' => true, 'message' => 'List of all festival', 'current_business' => $updatedCurrentBusinessDetails, 'premium' => $ispreminum, 'current_date' => $currnt_date, 'logout' => $logout, 'frameList' => $frameList, 'preference' => $preference, 'share_message' => $sharemsg, 'current_business_new' => $currntbusiness]);
        } else {
            return response()->json(['status' => false, 'message' => 'There is no festival in this month', 'current_date' => $currnt_date]);
        }
    }
    public function getHomePage(Request $request)
    {
        $user_language_check = false;
        $date = date('Y-m');

        $currnt_date = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime($currnt_date . ' -1 day'));
        $next_date = date('Y-m-d', strtotime($currnt_date . ' +1 day'));

        $adv_datas = DB::table('advetisement')->where('is_delete', '=', 0)->get();
        $advetisement = array();

        foreach ($adv_datas as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['adv_image'] = !empty($value->adv_image) ? Storage::url($value->adv_image) : "";
            $data['adv_number'] = !empty($value->adv_number) ? $value->adv_number : "";
            $data['adv_link'] = !empty($value->adv_link) ? $value->adv_link : "";

            array_push($advetisement, $data);
        }

        $trandings = Festival::whereDate('fest_date', $currnt_date)->whereIn('fest_type', array('tranding', 'festival'))->where('fest_is_delete', 0)->orderBy('fest_date', 'ASC')->get();
        $tranding = array();
        for ($i = 0; $i < sizeof($trandings); $i++) {
            $trandings[$i]['fest_day'] = date_parse_from_format('Y-m-d', $trandings[$i]['fest_date'])['day'];
            $trandings[$i]['fest_date'] = date("d-m-Y", strtotime($trandings[$i]['fest_date']));
            $data_tranding['fest_id'] = strval($trandings[$i]['fest_id']);
            $data_tranding['fest_name'] = !empty($trandings[$i]['fest_name']) ? $trandings[$i]['fest_name'] : "";
            $data_tranding['fest_info'] = !empty($trandings[$i]['fest_info']) ? $trandings[$i]['fest_info'] : "";
            $data_tranding['fest_image'] = !empty($trandings[$i]['fest_image']) ? Storage::url($trandings[$i]['fest_image']) : "";
            $data_tranding['fest_type'] = !empty($trandings[$i]['fest_type']) ? $trandings[$i]['fest_type'] : "";
            $data_tranding['fest_date'] = $trandings[$i]['fest_date'];
            $data_tranding['fest_day'] = strval($trandings[$i]['fest_day']);
            $data_tranding['fest_is_delete'] = strval($trandings[$i]['fest_is_delete']);
            $data_tranding['img_url'] = array();

            if($trandings[$i]['fest_type'] == 'tranding') {

                $photo = Post::where('post_category_id', '=', $trandings[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id', 'post_mode')->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->get();

                foreach ($photo as $ph_value) {
                    $data_ph['post_content'] = !empty($ph_value->post_thumb) ? Storage::url($ph_value->post_thumb) : Storage::url($ph_value->post_content);
                    $data_ph['post_id'] = !empty($ph_value->post_id) ? strval($ph_value->post_id) : "0";
                    $data_ph['image_type'] = !empty($ph_value->image_type) ? strval($ph_value->image_type) : "0";
                    $data_ph['post_category_id'] = !empty($ph_value->post_category_id) ? strval($ph_value->post_category_id) : "0";
                    $data_ph['post_mode'] = !empty($ph_value->post_mode) ? strval($ph_value->post_mode) : "light";
                    $data_ph['post_type'] = "image";
                    array_push($data_tranding['img_url'], $data_ph);
                }

                $videoPostCategory = DB::table('video_data')->where('video_name', $trandings[$i]['fest_name'])->where('video_is_delete', 0)->first();
                if(!empty($videoPostCategory)) {

                    $video = DB::table('video_post_data')
                    ->where('video_post_id', '=', $videoPostCategory->video_id)
                    ->where('is_deleted', '=', 0)
                    ->orderBy('image_type', 'ASC')
                    ->orderBy('id', 'DESC')
                    ->get();

                    foreach ($video as $key => $value) {
                        $data = array();

                        $data['id'] = strval($value->id);
                        $data['image'] = !empty($value->thumbnail) ? Storage::url($value->thumbnail) : "";
                        if ($value->video_store == "LOCAL") {
                            $data['video'] = !empty($value->video_url) ? url('/') . '/' . $value->video_url : "";
                        } else {
                            $data['video'] = !empty($value->video_url) ? Storage::url($value->video_url) : "";
                        }
                        $data['image_type'] = strval($value->image_type);
                        $data['color'] = !empty($value->color) ? $value->color : "";
                        $data['post_mode'] = !empty($value->post_mode) ? $value->post_mode : "light";
                        $data['post_type'] = "video";
                        array_push($data_tranding['img_url'], $data);
                    }
                }
            }


            array_push($tranding, $data_tranding);
        }

        $festivals = Festival::whereDate('fest_date', '>=', $currnt_date)->where('fest_type', 'festival')->where('fest_is_delete', 0)->orderBy('fest_date', 'asc')->offset(0)->limit(10)->get();
        $festival = array();
        $data_festival = array();
        for ($i = 0; $i < sizeof($festivals); $i++) {
            $festivals[$i]['fest_day'] = date_parse_from_format('Y-m-d', $festivals[$i]['fest_date'])['day'];
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
            $data_festival['fest_id'] = strval($festivals[$i]['fest_id']);
            $data_festival['fest_name'] = !empty($festivals[$i]['fest_name']) ? $festivals[$i]['fest_name'] : "";
            $data_festival['fest_info'] = !empty($festivals[$i]['fest_info']) ? $festivals[$i]['fest_info'] : "";
            $data_festival['fest_image'] = !empty($festivals[$i]['fest_image']) ? Storage::url($festivals[$i]['fest_image']) : "";
            $data_festival['fest_type'] = !empty($festivals[$i]['fest_type']) ? $festivals[$i]['fest_type'] : "";
            $data_festival['fest_date'] = $festivals[$i]['fest_date'];
            $data_festival['fest_day'] = strval($festivals[$i]['fest_day']);
            $data_festival['fest_is_delete'] = strval($festivals[$i]['fest_is_delete']);

            array_push($festival, $data_festival);
        }

        $incedents = Festival::where('fest_type', '=', 'incident')->where('fest_is_delete', '=', 0)->where('new_cat', 0)->orderBy('position_no', 'ASC')->get();

        $incedent = array();
        $data_incedent = array();
        for ($i = 0; $i < sizeof($incedents); $i++) {
            $incedents[$i]['fest_day'] = date_parse_from_format('Y-m-d', $incedents[$i]['fest_date'])['day'];

            $incedents[$i]['fest_date'] = date("d-m-Y", strtotime($incedents[$i]['fest_date']));
            $data_incedent['fest_id'] = strval($incedents[$i]['fest_id']);
            $data_incedent['fest_name'] = !empty($incedents[$i]['fest_name']) ? $incedents[$i]['fest_name'] : "";
            $data_incedent['fest_info'] = !empty($incedents[$i]['fest_info']) ? $incedents[$i]['fest_info'] : "";
            $data_incedent['fest_image'] = !empty($incedents[$i]['fest_image']) ? Storage::url($incedents[$i]['fest_image']) : "";
            $data_incedent['fest_type'] = !empty($incedents[$i]['fest_type']) ? $incedents[$i]['fest_type'] : "";
            $data_incedent['fest_date'] = $incedents[$i]['fest_date'];
            $data_incedent['fest_day'] = strval($incedents[$i]['fest_day']);
            $data_incedent['fest_is_delete'] = strval($incedents[$i]['fest_is_delete']);

            array_push($incedent, $data_incedent);
        }



        // ----------------------------- Get current business
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $checkReferralCode = User::find($user_id);
        $user_selected_language = explode(',', $checkReferralCode->user_language);
        array_push($user_selected_language, "2", "4");
        $referral_code = $checkReferralCode->ref_code;
        if (empty($checkReferralCode->ref_code)) {
            $referral_code = Helper::generateUniqueReferralCode();
            $checkReferralCode->ref_code = $referral_code;
            $checkReferralCode->save();
        }
        $userdata = User::where('id', '=', $user_id)->select(['default_business_id', 'user_language', 'default_political_business_id'])->first();
        $user_language_check = $userdata->user_language != NULL ? true : false;
        $currntbusiness = Business::where('busi_id', '=', $userdata->default_business_id)->where('busi_delete', '=', 0)->first();
        $political_category_name = "";
        $currntbusinessPolitical = PoliticalBusiness::where('pb_id', '=', $userdata->default_political_business_id)->where('pb_is_deleted', '=', 0)->first();
        if(!empty($currntbusinessPolitical)) {
            $partyData = DB::table('political_category')->where('pc_id', '=', $currntbusinessPolitical->pb_pc_id)->first();
            if(!empty($partyData)) {
                $political_category_name = $partyData->pc_name;
            }
        }
        $updatedCurrentBusinessDetails = array();
        $preference = DB::table('user_preference')->where('user_id', '=', $user_id)->get();

        $ispreminum = false;
        $renewPopup = false;
        $remainingDaysForNormalBusiness = 0;
        $remainingDaysForPoliticalBusiness = 0;
        $renewal_image = "";
        $daysBefore = 5;
        $renewalPopup = (object)[];
        $renewalPopupnormalBusiness = false;
        $renewalPopuppoliticalBusiness = false;
        $credit = DB::table('setting')->where('setting_id', '=', 1)->select('credit', 'setting_id', 'privacy_policy', 'terms_condition', 'whatsapp', 'renewal_days', 'renewal_image')->first();
        if (!empty($credit)) {
            $daysBefore = $credit->renewal_days;
            if (!empty($credit->renewal_image)) {
                $renewal_image = url($credit->renewal_image);
            }
        }
        if ($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != '') {
            $priminum = Purchase::where('purc_business_id', '=', $userdata->default_business_id)->where('purc_business_type', 1)->select('purc_id', 'purc_plan_id', 'purc_start_date', 'purc_end_date')->first();

            if (!empty($priminum) || $priminum != null || $priminum != '') {
                $start_dates = date('Y-m-d');
                if ($priminum->purc_plan_id == 1) {
                    $plantrial = Plan::where('plan_id', '=', $priminum->purc_plan_id)->select('plan_validity')->first();
                    $start_date = strtotime($start_dates);
                    $end_date = strtotime($priminum->purc_end_date);
                    $days = ($end_date - $start_date) / 60 / 60 / 24;
                    $tmp_end_date = Carbon::parse($priminum->purc_end_date);
                    $tmp_start_date = Carbon::now();
                    $remainingDaysForNormalBusiness = $tmp_end_date->diffInDays($tmp_start_date);
                    if ($remainingDaysForNormalBusiness <= $daysBefore) {
                        $renewPopup = true;
                        $renewalPopupnormalBusiness = true;
                    }
                    if ($days > $plantrial->plan_validity && $days > 0) {
                        $ispreminum = false;

                    } else {
                        $ispreminum = true;
                    }
                }
                if ($priminum->purc_plan_id == 3) {

                    $ispreminum = false;
                } else {
                    $start_date = strtotime($start_dates);
                    $end_date = strtotime($priminum->purc_end_date);
                    $days = ($end_date - $start_date) / 60 / 60 / 24;
                    $tmp_end_date = Carbon::parse($priminum->purc_end_date);
                    $tmp_start_date = Carbon::now();
                    $remainingDaysForNormalBusiness = $tmp_end_date->diffInDays($tmp_start_date);
                    if ($remainingDaysForNormalBusiness <= $daysBefore) {
                        $renewPopup = true;
                        $renewalPopupnormalBusiness = true;
                    }
                    $ispreminum = true;
                }

            } else {
                $ispreminum = false;
            }




            $updatedCurrentBusinessDetails['busi_id'] = strval($currntbusiness->busi_id);
            $updatedCurrentBusinessDetails['user_id'] = strval($currntbusiness->user_id);
            $updatedCurrentBusinessDetails['busi_name'] = !empty($currntbusiness->busi_name) ? $currntbusiness->busi_name : "";
            $updatedCurrentBusinessDetails['busi_logo'] = !empty($currntbusiness->busi_logo) ? Storage::url($currntbusiness->busi_logo) : "";
            $updatedCurrentBusinessDetails['busi_logo_dark'] = !empty($currntbusiness->busi_logo_dark) ? Storage::url($currntbusiness->busi_logo_dark) : "";
            $updatedCurrentBusinessDetails['busi_mobile'] = !empty($currntbusiness->busi_mobile) ? $currntbusiness->busi_mobile : "";
            $updatedCurrentBusinessDetails['busi_mobile_second'] = !empty($currntbusiness->busi_mobile_second) ? $currntbusiness->busi_mobile_second : "";
            $updatedCurrentBusinessDetails['busi_email'] = !empty($currntbusiness->busi_email) ? $currntbusiness->busi_email : "";
            $updatedCurrentBusinessDetails['busi_address'] = !empty($currntbusiness->busi_address) ? $currntbusiness->busi_address : "";
            $updatedCurrentBusinessDetails['busi_website'] = !empty($currntbusiness->busi_website) ? $currntbusiness->busi_website : "";
            $updatedCurrentBusinessDetails['business_category'] = !empty($currntbusiness->business_category) ? $currntbusiness->business_category : "";
            $updatedCurrentBusinessDetails['busi_is_approved'] = strval($currntbusiness->busi_is_approved);
            $updatedCurrentBusinessDetails['busi_delete'] = strval($currntbusiness->busi_delete);
            $updatedCurrentBusinessDetails['busi_facebook'] = strval($currntbusiness->busi_facebook);
            $updatedCurrentBusinessDetails['busi_twitter'] = strval($currntbusiness->busi_twitter);
            $updatedCurrentBusinessDetails['busi_instagram'] = strval($currntbusiness->busi_instagram);
            $updatedCurrentBusinessDetails['busi_linkedin'] = strval($currntbusiness->busi_linkedin);
            $updatedCurrentBusinessDetails['busi_youtube'] = strval($currntbusiness->busi_youtube);
            $updatedCurrentBusinessDetails['watermark_image'] = ($currntbusiness->watermark_image) ? Storage::url(strval($currntbusiness->watermark_image)) : '';
            $updatedCurrentBusinessDetails['watermark_image_dark'] = ($currntbusiness->watermark_image_dark) ? Storage::url(strval($currntbusiness->watermark_image_dark)) : '';

            $p_plan = Purchase::where('purc_user_id', $user_id)->where('purc_business_id', $userdata->default_business_id)->get();
            $plan_name = "";
            if (count($p_plan) != 0 && !empty($p_plan) && $p_plan != "") {
                foreach ($p_plan as $key => $value) {
                    if ($value->purc_is_cencal == 0 && $value->purc_is_expire == 0) {

                        $plan_names = Plan::where('plan_id', $value->purc_plan_id)
                            ->select('plan_name')
                            ->first();
                        if (!empty($plan_names)) {
                            $plan_name = $plan_names->plan_name;
                            $cur_status = 1;
                        } else {
                            $plan_name = 'Free';
                            $cur_status = 0;
                        }
                    } else {
                        $plan_name = 'Free';
                        $cur_status = 0;
                    }
                }
            } else {
                $plan_name = 'Free';
                $cur_status = 0;
            }

            $updatedCurrentBusinessDetails['plan_name'] = $plan_name;
            $cur_status = 1;
            $updatedCurrentBusinessDetails['status'] = strval($cur_status);


        } else {
            $cur_status = 0;
            $updatedCurrentBusinessDetails['status'] = strval($cur_status);
        }

        if ($currntbusinessPolitical != null || !empty($currntbusinessPolitical) || $currntbusinessPolitical != '') {
            $priminumPolitical = Purchase::where('purc_business_id', '=', $userdata->default_political_business_id)->where('purc_business_type', 2)->select('purc_id', 'purc_plan_id', 'purc_start_date', 'purc_end_date')->first();

            if (!empty($priminumPolitical) || $priminumPolitical != null || $priminumPolitical != '') {
                if ($priminumPolitical->purc_plan_id != 3) {
                    $tmp_end_datePolitical = Carbon::parse($priminumPolitical->purc_end_date);
                    $tmp_start_datePolitical = Carbon::now();
                    $remainingDaysForPoliticalBusiness = $tmp_end_datePolitical->diffInDays($tmp_start_datePolitical);
                    if ($remainingDaysForPoliticalBusiness <= $daysBefore) {
                        $renewPopup = true;
                        $renewalPopuppoliticalBusiness = false;
                    }
                }
            }
        }
        if ($renewPopup) {
            $renewalPopup->image = $renewal_image;
            $renewalPopup->normalBusiness = $renewalPopupnormalBusiness;
            $renewalPopup->remainingDaysForNormalBusiness = $remainingDaysForNormalBusiness;
            $renewalPopup->politocalBusiness = $renewalPopuppoliticalBusiness;
            $renewalPopup->remainingDaysForPoliticalBusiness = $remainingDaysForPoliticalBusiness;
        }


        $popupData = (object)[];
        $todayDate = Carbon::now();
        $popup = Popup::where('start_date', '<=', $todayDate)->where('end_date', '>=', $todayDate)->where('is_delete', 0)->first();
        if (!empty($popup)) {
            $popup->image = Storage::url($popup->image);
            $start = Carbon::now();
            $end = Carbon::parse($popup->end_date);
            $diff_in_hours = $start->diffInHours($end);
            $popup->diff_in_hours = $diff_in_hours;
            if ($popup->user_type == "All") {
                $popupData = $popup;
            } else if ($popup->user_type == "Premium") {
                if ($ispreminum) {
                    $popupData = $popup;
                }
            } else {
                if (!$ispreminum) {
                    $popupData = $popup;
                }
            }
        }

        $userstatus = User::where('id', '=', $user_id)->select('status')->first();;

        $logout = false;

        if ($userstatus->status == 1 || $userstatus->status == 2) {
            $logout = true;
        }


        $frameList = DB::table('user_frames')->where('user_id', '=', $user_id)->where(function ($query) use ($userdata) {
            $query->where('business_id', '=', $userdata->default_business_id)
                ->orWhere('business_id', '=', $userdata->default_political_business_id);
        })->where('is_deleted', '=', 0)->orderBy('user_frames_id', 'DESC')->get();



        if (!empty($frameList)) {
            foreach ($frameList as &$frame) {
                $frame->frame_url = Storage::url($frame->frame_url);
            }
        }

        $sharemsg = '';
        $credit = DB::table('setting')->where('setting_id', '=', 1)->select('whatsapp')->first();
        if ($credit->whatsapp == '' || is_null($credit->whatsapp)) {
            $sharemsg = '';
        } else {
            $sharemsg = $credit->whatsapp;
        }
        $category_data = DB::table('business_category')->where('is_delete', '=', 0)->limit(10)->get();

        $category = array();

        $keyval = 0;
        foreach ($category_data as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['category_name'] = !empty($value->name) ? $value->name : "";
            $data['image'] = !empty($value->image) ? Storage::url($value->image) : "";
            array_push($category, $data);
            if (!empty($currntbusiness)) {
                if ($value->name == $currntbusiness->business_category) {
                    $keyval = $key;
                }
            }
        }

        $buss_category = $this->moveElement($category, $keyval, 0);
        $currntbusiness_photos = array();
        if (!empty($currntbusiness)) {


            $currntbusiness_photo_id = DB::table('business_category')->where('name', $currntbusiness->business_category)->where('is_delete', 0)->first();

            if (!empty($currntbusiness_photo_id)) {
                $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', 'image')->where('buss_cat_post_id', '=', $currntbusiness_photo_id->id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->limit(10)->get();
                $currntbusiness_photos['id'] =  $currntbusiness_photo_id->id;
                $currntbusiness_photos['cat_name'] =  $currntbusiness->business_category;
                $currntbusiness_photos['images'] =  [];

                foreach ($currntbusiness_photo as $img_key => $img_value) {

                    $img_data['image_id'] = strval($img_value->id);
                    $img_data['image_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                    $img_data['image_type'] = strval($img_value->image_type);
                    $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";

                    array_push($currntbusiness_photos['images'], $img_data);
                }
            }
        }

        $currntpoliticalbusiness_photos = array();
        if(!empty($currntbusinessPolitical)) {

            $currntPoliticalbusiness_photo_id = DB::table('business_category')->where('name', $political_category_name)->where('is_delete', 0)->first();
            $currntpoliticalbusiness_photos = array();
            if (!empty($currntPoliticalbusiness_photo_id)) {
                $currntpoliticalbusiness_photoData = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', 'image')->where('buss_cat_post_id', '=', $currntPoliticalbusiness_photo_id->id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->limit(10)->get();
                $currntpoliticalbusiness_photos['id'] =  $currntPoliticalbusiness_photo_id->id;
                $currntpoliticalbusiness_photos['cat_name'] =  $political_category_name;
                $currntpoliticalbusiness_photos['images'] =  [];

                foreach ($currntpoliticalbusiness_photoData as $img_key => $img_value) {

                    $img_data['image_id'] = strval($img_value->id);
                    $img_data['image_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                    $img_data['image_type'] = strval($img_value->image_type);
                    $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";

                    array_push($currntpoliticalbusiness_photos['images'], $img_data);
                }
            }
        }





        $new_category_data = Festival::where('fest_is_delete', '=', 0)->where('new_cat', '!=', 0)->orderBy('position_no', 'ASC')->get();
        $new_category_dataArray = array();
        $user_language = User::where('id', $user_id)->value('user_language');
        for ($i = 0; $i < sizeof($new_category_data); $i++) {

            $temp['id'] = $new_category_data[$i]['fest_id'];
            $temp['title'] = $new_category_data[$i]['fest_name'];
            $temp['type'] = $new_category_data[$i]['new_cat'];

            $temp['img_url'] = array();

            $post = array();
            $business = DB::table('business')->where('busi_id', $userdata->default_business_id)->first();
            if (!empty($business)) {
                $category = DB::table('business_category')->where('name', $business->business_category)->first();
                if (!empty($category)) {
                    $post = DB::table('business_category_post_data')
                        ->where('is_deleted', 0)
                        ->whereIn('language_id', $user_selected_language)
                        ->where('post_type', 'image')
                        ->where('buss_cat_post_id', $category->id)
                        ->where('festival_id', $new_category_data[$i]['fest_id'])
                        ->orderBy('id', 'DESC')
                        ->limit(10)
                        ->get();
                }
            }
            foreach ($post as $img_key => $img_value) {
                $data_ph['post_id'] = strval($img_value->id);
                $data_ph['post_content'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                $data_ph['image_type'] = !empty($img_value->image_type) ? strval($img_value->image_type) : 0;
                $data_ph['post_category_id'] = $new_category_data[$i]['fest_id'];

                array_push($temp['img_url'], $data_ph);
            }


            if (count($post) < 10) {
                $limit_1 = 10 - count($post);
                if ($new_category_data[$i]['new_cat'] == 1) {
                    $checkFestival = Festival::where('fest_id', $new_category_data[$i]['fest_id'])->first();
                    if ($checkFestival->fest_name == "Trending") {
                        $photo = Post::where('post_category_id', '=', $new_category_data[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id')->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->limit($limit_1)->get();
                    } else {
                        $photo = Post::where('post_category_id', '=', $new_category_data[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id')->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('post_id', 'DESC')->limit($limit_1)->get();
                    }
                } else {
                    $checkFestival = Festival::where('fest_id', $new_category_data[$i]['fest_id'])->first();
                    if ($checkFestival->fest_name == "Trending") {
                        $photo = Post::where('post_category_id', '=', $new_category_data[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id')->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->limit($limit_1)->get();
                    } else {
                        $photo = Post::where('post_category_id', '=', $new_category_data[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id')->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('post_id', 'DESC')->limit($limit_1)->get();
                    }
                }
                foreach ($photo as $ph_value) {
                    $data_ph['post_content'] = !empty($ph_value->post_thumb) ? Storage::url($ph_value->post_thumb) : Storage::url($ph_value->post_content);
                    $data_ph['post_id'] = !empty($ph_value->post_id) ? strval($ph_value->post_id) : 0;
                    $data_ph['image_type'] = !empty($ph_value->image_type) ? strval($ph_value->image_type) : 0;
                    $data_ph['post_category_id'] = !empty($ph_value->post_category_id) ? strval($ph_value->post_category_id) : 0;
                    array_push($temp['img_url'], $data_ph);
                }
            }


            array_push($new_category_dataArray, $temp);
        }

        $new_category_data_greetings = DB::table('custom_cateogry')->where('is_active', 1)->whereIn('highlight', array(1, 3))->orderBy('slider_img_position', 'ASC')->get();
        $new_category_data_greetingsArray = array();
        foreach ($new_category_data_greetings as $greeting) {

            $photo = DB::table('custom_cateogry_data')
                ->whereIn('language_id', $user_selected_language)
                ->where('custom_cateogry_id', '=', $greeting->custom_cateogry_id)
                ->where('is_delete', '=', 0)
                ->orderBy('image_type', 'ASC')
                ->orderBy('custom_cateogry_data_id', 'DESC')
                ->limit(10)
                ->get();

            $temp1['id'] = $greeting->custom_cateogry_id;
            $temp1['title'] = $greeting->name;

            $temp1['img_url'] = array();
            foreach ($photo as $ph_value) {
                $data_ph1['custom_cateogry_id'] = !empty($ph_value->custom_cateogry_id) ? strval($ph_value->custom_cateogry_id) : 0;
                $data_ph1['banner_image'] = !empty($ph_value->banner_image) ? Storage::url($ph_value->banner_image) : "";
                $data_ph1['image'] = !empty($ph_value->image_one) ? Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['image_one'] = !empty($ph_value->image_one) ? Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['position_x'] = $ph_value->position_x;
                $data_ph1['images']['position_y'] = $ph_value->position_y;
                $data_ph1['images']['img_position_x'] = $ph_value->img_position_x;
                $data_ph1['images']['img_position_y'] = $ph_value->img_position_y;
                $data_ph1['images']['img_height'] = $ph_value->img_height;
                $data_ph1['images']['img_width'] = $ph_value->img_width;
                array_push($temp1['img_url'], $data_ph1);
            }

            array_push($new_category_data_greetingsArray, $temp1);
        }



        $politicalCurrentBusinessDetails = $this->getPoliticalCurrentBusiness($userdata->default_political_business_id, $user_id);
        $retrunData = (object)[];
        if ($politicalCurrentBusinessDetails[0]) {
            $retrunData = $politicalCurrentBusinessDetails[0];
        }

        $remaining_bg_credit = $checkReferralCode->bg_credit;

        if (!empty($festivals) || !empty($incedents)) {
            return response()->json(['remaining_bg_credit' => $remaining_bg_credit, 'slider' => $advetisement, 'festival' => $festival, 'cateogry' => $incedent, 'business_category' => $buss_category, 'current_business' => $updatedCurrentBusinessDetails, 'premium' => $ispreminum, 'current_date' => $currnt_date, 'logout' => $logout, 'frameList' => $frameList, 'share_message' => $sharemsg, 'currntbusiness_photos' => (object)$currntbusiness_photos, 'currntpoliticalbusiness_photos' => (object)$currntpoliticalbusiness_photos, 'new_category' => $new_category_dataArray, 'greetings' => $new_category_data_greetingsArray, 'status' => true, 'user_language' => $user_language_check, 'message' => 'List of all festival', 'politicalCurrentBusinessDetails' => $retrunData, 'isPoliticalPrimium' => $politicalCurrentBusinessDetails[1], 'popup' => $popupData, 'renewalPopup' => $renewalPopup, 'referral_code' => $referral_code, 'trandings' => $tranding]);
        } else {
            return response()->json(['remaining_bg_credit' => $remaining_bg_credit, 'status' => false, 'message' => 'There is no festival in this month', 'current_date' => $currnt_date]);
        }
    }

    public function getMonthsPost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $type = $input['type'];
        $user = User::find($user_id);
        $user_selected_language = explode(",", $user->user_language);
        array_push($user_selected_language, '2', '4');

        $festival_data = Festival::where('fest_id', $input['postcategoryid'])->first();
        $isVideoAvailable = false;
        $videoFestival = VideoData::where('video_name', $festival_data->fest_name)->where('video_is_delete', 0)->first();
        if ($videoFestival) {
            $videoPost = DB::table('video_post_data')->where('video_post_id', '=', $videoFestival->video_id)->where('is_deleted', '=', 0)->first();
            if ($videoPost) {
                $isVideoAvailable = true;
            }
        }
        $category_id = $input['postcategoryid'];

        $category_type = 0;
        if ($type == 'image') {
            if ($festival_data->fest_type == 'festival') {
                $category_type = 3;
            } else {
                $category_type = 5;
            }
        } else {
            $category_id = $videoFestival->video_id;
            if ($videoFestival->fest_type == 'festival') {
                $category_type = 4;
            } else {
                $category_type = 6;
            }
        }

        $limitData = Helper::getUserRemainingLimit($user_id, $category_type, $category_id);
        $limitData['type'] = $category_type;

        $sub_category_id = $input['sub_category_id'];

        if ($type == "image") {

            $categoriesIds = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->groupBy('sub_category_id')->pluck('sub_category_id')->toArray();
            $categories = FestivalSubCategory::whereIn('id', $categoriesIds)->where('festival_id', $input['postcategoryid'])->where('is_delete', 0)->get();

            $offset = 0;
            if (!empty($request->offset)) {
                $offset = $request->offset;
            }
            $transactionLimit = Helper::GetLimit();
            $language_id = $input['languageid'];
            $languageid = explode(',', $language_id);

            $user_language = User::where('id', $user_id)->value('user_language');

            if (in_array(0, $languageid)) {
                if ($user_language != null) {
                    $checkFestival = Festival::where('fest_id', $input['postcategoryid'])->first();
                    if ($checkFestival->fest_name == "Trending") {
                        if ($sub_category_id == 0) {
                            $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                        } else {
                            $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                        }
                    } else {
                        if ($sub_category_id == 0) {
                            $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                        } else {
                            $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                        }
                    }
                } else {
                    if ($sub_category_id == 0) {
                        $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                    } else {
                        $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                    }
                }
            } else {
                if ($sub_category_id == 0) {
                    $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->whereIn('language_id', $languageid)->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $posts = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->whereIn('language_id', $languageid)->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            }

            $language_ids = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->select('language_id')->get()->toArray();
            $language_id_array = array_unique($language_ids, SORT_REGULAR);

            $temp = array();
            if ($offset == 0) {
                $post = array();
                $business = DB::table('business')->where('busi_id', $user->default_business_id)->first();
                if (!empty($business)) {
                    $category = DB::table('business_category')->where('name', $business->business_category)->first();
                    if (!empty($category)) {
                        $post = DB::table('business_category_post_data')
                            ->where('is_deleted', 0)
                            ->whereIn('language_id', $user_selected_language)
                            ->where('post_type', $type)
                            ->where('buss_cat_post_id', $category->id)
                            ->where('festival_id', $input['postcategoryid'])
                            ->orderBy('id', 'DESC')
                            ->get();
                    }
                }
                foreach ($post as $img_key => $img_value) {
                    if ($type == "image") {
                        $img_data['post_id'] = strval($img_value->id);
                        $img_data['post_content'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) : "";
                        $img_data['image_thumbnail_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                        $img_data['image_type'] = strval($img_value->image_type);
                        $img_data['post_mode'] = !empty($img_value->post_mode) ? $img_value->post_mode : 'light';
                        $img_data['post_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : 0;
                        $img_data['post_category_id'] = 0;
                    } else {
                        $img_data['id'] = strval($img_value->id);
                        $img_data['image'] = !empty($img_value->video_thumbnail) ? Storage::url($img_value->video_thumbnail) : "";
                        $img_data['video'] = !empty($img_value->video_url) ? url('/') . '/' . $img_value->video_url : "";
                        $img_data['type'] = strval($img_value->image_type);
                        $img_data['color'] = "";
                        $img_data['post_mode'] = !empty($img_value->post_mode) ? $img_value->post_mode : 'light';
                    }

                    array_push($temp, $img_data);
                }
            }

            foreach ($posts as $ph_value) {
                $data_ph['post_content'] = !empty($ph_value->post_content) ? Storage::url($ph_value->post_content) : "";
                $data_ph['image_thumbnail_url'] = !empty($ph_value->post_thumb) ? Storage::url($ph_value->post_thumb) : Storage::url($ph_value->post_content);
                $data_ph['post_id'] = !empty($ph_value->post_id) ? strval($ph_value->post_id) : 0;
                $data_ph['image_type'] = !empty($ph_value->image_type) ? strval($ph_value->image_type) : 0;
                $data_ph['post_category_id'] = !empty($ph_value->post_category_id) ? strval($ph_value->post_category_id) : 0;
                $data_ph['post_language_id'] = !empty($ph_value->language_id) ? strval($ph_value->language_id) : 0;
                $data_ph['post_mode'] = !empty($ph_value->post_mode) ? $ph_value->post_mode : 'light';
                array_push($temp, $data_ph);
            }

            if (in_array(0, $languageid)) {
                if ($user_language != null) {
                    $checkFestival = Festival::where('fest_id', $input['postcategoryid'])->first();
                    if ($checkFestival->fest_name == "Trending") {
                        if ($sub_category_id == 0) {
                            $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                        } else {
                            $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                        }
                    } else {
                        if ($sub_category_id == 0) {
                            $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                        } else {
                            $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                        }
                    }
                } else {
                    if ($sub_category_id == 0) {
                        $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                    } else {
                        $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                    }
                }
            } else {
                if ($sub_category_id == 0) {
                    $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->whereIn('language_id', $languageid)->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                } else {
                    $posts_next = Post::where('post_category_id', '=', $input['postcategoryid'])->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->whereIn('language_id', $languageid)->orderBy('post_id', 'DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                }
            }

            $languages = Language::where('is_delete', '=', 0)->whereIn('id', $language_id_array)->get();

            $language = array();

            foreach ($languages as $key => $value) {
                $data = array();
                $data['id'] = strval($value->id);
                $data['language'] = !empty($value->name) ? $value->name : "";
                array_push($language, $data);
            }

            $next = true;
            if (count($posts_next) == 0) {
                $next = false;
            }

            $meta = array(
                'offset' => $offset + count($posts),
                'limit' => intval($transactionLimit),
                'record' => count($posts),
                'next' => $next
            );

            return response()->json(['categories' => $categories, 'limitData' => $limitData, 'data' => $temp, "isVideoAvailable" => $isVideoAvailable, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => 'List of all festival']);
        } else {
            if ($videoFestival) {
                $videoid = $videoFestival->video_id;
            } else {
                $videoid = 0;
            }

            $categoriesIds = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->groupBy('sub_category_id')->pluck('sub_category_id')->toArray();
            $categories = VideoSubCategory::whereIn('id', $categoriesIds)->where('festival_id', $videoid)->where('is_delete', 0)->get();

            $language_id = $input['languageid'];
            $languageid = explode(',', $language_id);

            $offset = 0;
            if (!empty($request->offset)) {
                $offset = $request->offset;
            }
            $transactionLimit = Helper::GetLimit();

            $user_language = User::where('id', $user_id)->value('user_language');
            if (in_array(0, $languageid)) {
                if ($user_language != null) {
                    if ($sub_category_id == 0) {
                        $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                    } else {
                        $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                    }
                } else {
                    if ($sub_category_id == 0) {
                        $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                    } else {
                        $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                    }
                }
            } else {
                if ($sub_category_id == 0) {
                    $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            }

            $language_ids = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->select('language_id')->get()->toArray();

            $language_id_array = [];
            foreach ($language_ids as $id) {
                array_push($language_id_array, $id->language_id);
            }
            $language_id_array = array_unique($language_id_array, SORT_REGULAR);

            $videos = array();

            if ($offset == 0) {

                $post = array();
                $business = DB::table('business')->where('busi_id', $user->default_business_id)->first();
                if (!empty($business)) {
                    $category = DB::table('business_category')->where('name', $business->business_category)->first();
                    if (!empty($category)) {
                        $post = DB::table('business_category_post_data')
                            ->where('is_deleted', 0)
                            ->whereIn('language_id', $user_selected_language)
                            ->where('post_type', $type)
                            ->where('buss_cat_post_id', $category->id)
                            ->where('festival_id', $input['postcategoryid'])
                            ->orderBy('id', 'DESC')
                            ->get();
                    }
                }

                foreach ($post as $img_key => $img_value) {
                    if ($type == "image") {
                        $img_data['post_id'] = strval($img_value->id);
                        $img_data['post_content'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) : "";
                        $img_data['image_thumbnail_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                        $img_data['image_type'] = strval($img_value->image_type);
                        $img_data['post_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";
                        $img_data['post_mode'] = !empty($img_value->post_mode) ? strval($img_value->post_mode) : "light";
                        $img_data['post_category_id'] = "";
                    } else {
                        $img_data['id'] = strval($img_value->id);
                        $img_data['image'] = !empty($img_value->video_thumbnail) ? Storage::url($img_value->video_thumbnail) : "";
                        $img_data['video'] = !empty($img_value->video_url) ? url('/') . '/' . $img_value->video_url : "";
                        $img_data['type'] = strval($img_value->image_type);
                        $img_data['color'] = "";
                        $img_data['post_mode'] = !empty($img_value->post_mode) ? strval($img_value->post_mode) : "light";
                    }

                    array_push($videos, $img_data);
                }
            }


            foreach ($video as $key => $value) {
                $data = array();

                $data['id'] = strval($value->id);
                $data['image'] = !empty($value->thumbnail) ? Storage::url($value->thumbnail) : "";
                if ($value->video_store == "LOCAL") {
                    $data['video'] = !empty($value->video_url) ? url('/') . '/' . $value->video_url : "";
                } else {
                    $data['video'] = !empty($value->video_url) ? Storage::url($value->video_url) : "";
                }
                $data['type'] = strval($value->image_type);
                $data['color'] = !empty($value->color) ? $value->color : "";
                $data['post_mode'] = !empty($value->post_mode) ? $value->post_mode : "";
                array_push($videos, $data);
            }

            if (in_array(0, $languageid)) {
                if ($user_language != null) {
                    if ($sub_category_id == 0) {
                        $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                    } else {
                        $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                    }
                } else {
                    if ($sub_category_id == 0) {
                        $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                    } else {
                        $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                    }
                }
            } else {
                if ($sub_category_id == 0) {
                    $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                } else {
                    $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                }
            }

            $languages = Language::where('is_delete', '=', 0)->whereIn('id', $language_id_array)->get();

            $language = array();

            foreach ($languages as $key => $value) {
                $data = array();
                $data['id'] = strval($value->id);
                $data['language'] = !empty($value->name) ? $value->name : "";
                array_push($language, $data);
            }

            $next = true;
            if (count($video_next) == 0) {
                $next = false;
            }

            $meta = array(
                'offset' => $offset + count($video),
                'limit' => intval($transactionLimit),
                'record' => count($video),
                'next' => $next
            );

            return response()->json(['categories' => $categories, 'limitData' => $limitData, 'data' => $videos, "isVideoAvailable" => $isVideoAvailable, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => "Video List Successfully"]);
        }
    }

    public function getDays(Request $request)
    {

        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        $currnt_date = date('Y-m-d');
        $festivals = array();
        if ($input['date'] != '') {
            $date = str_replace('/', '-', $input['date']);
            $date = date('Y-m-d', strtotime($date));

            $festivals = Festival::where('fest_date', '=', $date)->where('fest_type', '=', 'festival')->where('fest_is_delete', '=', 0)->get()->toArray();
        } else {

            $festivals1 = Festival::where('fest_date', '>=', date('Y-m-d'))->where('fest_type', '=', 'festival')->where('fest_is_delete', '=', 0)->get()->toArray();

            $festivals2 = Festival::where('fest_date', '<', date('Y-m-d'))->where('fest_type', '=', 'festival')->where('fest_is_delete', '=', 0)->get()->toArray();

            $festivals = array_merge($festivals1, $festivals2);
        }
        $festival = array();
        $data_festival = array();
        for ($i = 0; $i < sizeof($festivals); $i++) {
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
            $data_festival['fest_id'] = strval($festivals[$i]['fest_id']);
            $data_festival['fest_name'] = !empty($festivals[$i]['fest_name']) ? $festivals[$i]['fest_name'] : "";
            $data_festival['fest_image'] = !empty($festivals[$i]['fest_image']) ? Storage::url($festivals[$i]['fest_image']) : "";
            $data_festival['fest_date'] = $festivals[$i]['fest_date'];

            array_push($festival, $data_festival);
        }

        $olddate = array();
        $newdate = array();
        $current = date('d-m-Y');
        foreach ($festival as $fest) {
            if (strtotime($fest['fest_date']) >= strtotime($current)) {
                array_push($newdate, $fest);
            } else {
                array_push($olddate, $fest);
            }
        }

        usort($newdate, function ($a, $b) {
            return strtotime($a['fest_date']) <=> strtotime($b['fest_date']);
        });

        usort($olddate, function ($a, $b) {
            return strtotime($a['fest_date']) <=> strtotime($b['fest_date']);
        });


        $finalarr = array_merge($newdate, array_reverse($olddate));

        if (!empty($festivals)) {
            return response()->json(['festival' => $finalarr, 'status' => true, 'message' => 'List of all festival', 'current_date' => $currnt_date,]);
        } else {
            return response()->json(['festival' => $finalarr, 'status' => false, 'message' => 'There is no festival on this date', 'current_date' => $currnt_date]);
        }
    }

    public function savePreference(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if ($input['is_delete'] == 'false' || $input['is_delete'] == false) {

            DB::table('user_preference')->insert(
                ['user_id' => $user_id, 'preference_value' => $input['preference_value']]
            );
        } else {

            DB::table('user_preference')->where('user_id', '=', $user_id)->where('preference_value', '=', $input['preference_value'])->delete();
        }
        $userdata = User::where('id', '=', $user_id)->select('default_business_id')->first();
        if (!empty($userdata)) {
            $currntbusiness = Business::where('busi_id', '=', $userdata->default_business_id)->where('busi_delete', '=', 0)->first();

            $preference = DB::table('user_preference')->where('user_id', '=', $user_id)->get();

            $updatedCurrentBusinessDetails = array();
            $updatedCurrentBusinessDetails['busi_id'] = $currntbusiness->busi_id;
            $updatedCurrentBusinessDetails['user_id'] = $currntbusiness->user_id;
            $updatedCurrentBusinessDetails['busi_name'] = $currntbusiness->busi_name;
            $updatedCurrentBusinessDetails['busi_logo'] = $currntbusiness->busi_logo;
            $updatedCurrentBusinessDetails['busi_mobile'] = $currntbusiness->busi_mobile;
            $updatedCurrentBusinessDetails['busi_email'] = $currntbusiness->busi_email;
            $updatedCurrentBusinessDetails['busi_address'] = $currntbusiness->busi_address;
            $updatedCurrentBusinessDetails['busi_website'] = $currntbusiness->busi_website;
            $updatedCurrentBusinessDetails['busi_is_approved'] = $currntbusiness->busi_is_approved;
            $updatedCurrentBusinessDetails['busi_delete'] = $currntbusiness->busi_delete;
            $updatedCurrentBusinessDetails['busi_facebook'] = $currntbusiness->busi_facebook;
            $updatedCurrentBusinessDetails['busi_twitter'] = $currntbusiness->busi_twitter;
            $updatedCurrentBusinessDetails['busi_instagram'] = $currntbusiness->busi_instagram;
            $updatedCurrentBusinessDetails['busi_linkedin'] = $currntbusiness->busi_linkedin;
            $updatedCurrentBusinessDetails['busi_youtube'] = $currntbusiness->busi_youtube;
            $updatedCurrentBusinessDetails['watermark_image'] = Storage::url($currntbusiness->watermark_image);

            if (!empty($preference)) {

                foreach ($preference as $value) {
                    if ($value->preference_value == 1) {
                        $updatedCurrentBusinessDetails['busi_logo'] = '';
                    }
                    if ($value->preference_value == 2) {
                        $updatedCurrentBusinessDetails['busi_mobile'] = '';
                    }
                    if ($value->preference_value == 3) {
                        $updatedCurrentBusinessDetails['busi_email'] = '';
                    }
                    if ($value->preference_value == 4) {
                        $updatedCurrentBusinessDetails['busi_address'] = '';
                    }
                    if ($value->preference_value == 5) {
                        $updatedCurrentBusinessDetails['busi_website'] = '';
                    }
                    if ($value->preference_value == 6) {
                        $updatedCurrentBusinessDetails['busi_name'] = '';
                    }
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Successfully set your Preference', 'preference' => $preference, 'current_business' => $updatedCurrentBusinessDetails]);
    }

    public function getCustomCategoryPost()
    {

        $onlycat = DB::table('custom_cateogry')->where('is_active', 1)->orderBy('slider_img_position', 'ASC')->get();

        $finalarry = array();

        $slider = array();

        foreach ($onlycat as $value) {
            $temp = array();
            $temp['name'] = $value->name;
            $temp['custom_cateogry_id'] = $value->custom_cateogry_id;
            $temp['catdata'] = [];
            $preference = DB::table('custom_cateogry_data')->where('custom_cateogry_id', '=', $value->custom_cateogry_id)->orderBy('custom_cateogry_data_id', 'DESC')->get();
            foreach ($preference as $value2) {
                $data['banner_image'] = Storage::url($value2->image_one);
                $data['image'] = Storage::url($value2->banner_image);
                $data['custom_cateogry_id'] = $value->custom_cateogry_id;
                $data['images']['image_one'] = Storage::url($value2->image_one);
                $data['images']['position_x'] = $value2->position_x;
                $data['images']['position_y'] = $value2->position_y;
                $data['images']['img_position_x'] = $value2->img_position_x;
                $data['images']['img_position_y'] = $value2->img_position_y;
                $data['images']['img_height'] = $value2->img_height;
                $data['images']['img_width'] = $value2->img_width;
                array_push($temp['catdata'], $data);
            }

            array_push($finalarry, $temp);
            $slide = array();
            $slide['custom_cateogry_id'] = $value->custom_cateogry_id;
            $slide['slider_img'] = Storage::url($value->slider_img);
            $slide['slider_img_position'] = $value->slider_img_position;
            array_push($slider, $slide);
        }

        return response()->json(['status' => true, 'message' => 'Successfully set your Preference', 'data' => $finalarry, 'slider' => $slider]);
    }

    public function getCustomCategoryImages(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $preference = DB::table('custom_cateogry_data')->where('custom_cateogry_id', '=', $input['custom_cateogry_id'])->orderBy('custom_cateogry_data_id', 'DESC')->get();

        foreach ($preference as &$value2) {
            $value2->banner_image = Storage::url($value2->banner_image);
            $value2->image_one = Storage::url($value2->image_one);
            $value2->position_x = $value2->position_x;
            $value2->position_y = $value2->position_y;
        }

        if (!empty($preference)) {
            return response()->json(['status' => true, 'message' => 'Successfully get images', 'data' => $preference]);
        } else {
            return response()->json(['status' => false, 'message' => 'Image not found']);
        }
    }

    public function getVideoPosts(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $finalarr = array();
        $festivals =  DB::table('video_post')->where('is_deleted', '=', 0)->orderBy('date_added', 'ASC')->get();

        if (!empty($festivals)) {
            $olddate = array();
            $newdate = array();
            $current = date('d-m-Y');
            foreach ($festivals as $fest) {
                if (strtotime($fest->date) >= strtotime($current)) {
                    array_push($newdate, $fest);
                } else {
                    array_push($olddate, $fest);
                }
                $fest->video_url = url('/') . '/' . $fest->video_url;
                $imgurl_create = Storage::url('/');
                $fest->thumbnail = str_replace(".com/", ".com", $imgurl_create) . '' . $fest->thumbnail;
            }
            usort($newdate, function ($a, $b) {
                return strtotime($a->date) <=> strtotime($b->date);
            });


            usort($olddate, function ($a, $b) {
                return strtotime($a->date) <=> strtotime($b->date);
            });


            $finalarr = array_merge($newdate, array_reverse($olddate));
        }

        if (count($festivals) != 0) {
            return response()->json(['status' => true, 'message' => 'Videos listed successfully', 'data' => $finalarr]);
        } else {
            return response()->json(['status' => false, 'message' => 'videos not found']);
        }
    }

    public function getBusinessCategory(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $category_data = DB::table('business_category')->where('is_delete', '=', 0)->get();

        $category = array();

        foreach ($category_data as $key => $value) {
            $data['id'] = strval($value->id);
            $data['category_name'] = !empty($value->name) ? $value->name : "";
            $data['category_image'] = !empty($value->image) ? Storage::url($value->image) : "";
            array_push($category, $data);
        }


        if (count($category_data) != 0) {
            return response()->json(['status' => true, 'message' => 'Category list successfully', 'cateogry' => $category]);
        } else {
            return response()->json(['status' => false, 'message' => 'Category not found']);
        }
    }

    // ------------------------------------ Plan Apis -------------------------------------------------

    public function purchasePlan(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $userData = User::find($user_id);
        if ($input['business_type'] == 1) {
            $checkBusiness = Business::where('busi_id', $input['business_id'])->where('user_id', $user_id)->where('busi_delete', 0)->first();
        } else {
            $checkBusiness = PoliticalBusiness::where('pb_id', $input['business_id'])->where('user_id', $user_id)->where('pb_is_deleted', 0)->first();
        }
        if (empty($checkBusiness)) {
            return response()->json(['status' => false, 'message' => 'Something goes wrong']);
        }

        $is_purchasebeforee = DB::table('purchase_plan')->where('purc_user_id', '=', $user_id)->where('purc_plan_id', '!=', 3)->select('purc_user_id')->first();

        if (is_null($is_purchasebeforee)) {

            $results = DB::table('refferal_data')->where('ref_user_id', '=', $user_id)->select('ref_by_user_id')->first();
            if (!is_null($results)) {
                $credit = DB::table('setting')->where('setting_id', '=', 1)->select('credit')->first();

                $usercredit = DB::table('users')->where('id', '=', $results->ref_by_user_id)->select('user_credit', 'id')->first();

                $newcredit = intval($usercredit->user_credit) + intval($credit->credit);

                User::where('id', '=', $results->ref_by_user_id)->update(array(
                    'user_credit' => $newcredit,
                ));
            }
        }

        $remainingcredit = '';

        if ($remainingcredit != 0) {
            $usercredit = DB::table('users')->where('id', '=', $user_id)->select('user_credit', 'id')->first();
            $newcredit = intval($usercredit->user_credit) - intval($remainingcredit);

            User::where('id', '=', $user_id)->update(array(
                'user_credit' => $newcredit,
            ));
        }

        $business_id = $input['business_id'];
        $plan_id = $input['plan_id'];
        $start_date = date('Y-m-d');

        if ($userData->referral_by != 0 && $userData->referral_premium == 0) {
            $settingData = DB::table('setting')->first();
            $referral_subscription_amount = 0;
            if (!empty($settingData)) {
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

        $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity', 'bg_credit')->first();
        $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));
        $end_date = Carbon::parse($end_date);
        $checkAlreadyPremium = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', $input['business_type'])->first();
        $new_start_date = '';
        if (!empty($checkAlreadyPremium->purc_end_date)) {
            $tmp_end_date = Carbon::parse($checkAlreadyPremium->purc_end_date);
            $tmp_start_date = Carbon::now();
            $diff = $tmp_end_date->diffInDays($tmp_start_date);
            $new_start_date = $tmp_start_date->addDays($diff);
            $end_date = $end_date->addDays($diff);
        }

        Purchase::where('purc_business_id', $business_id)->where('purc_business_type', $input['business_type'])->update([
            'purc_plan_id' => $plan_id,
            'purc_start_date' => $start_date,
            'purc_end_date' => $end_date,
            'purc_order_id' => $input['order_id'],
            'purchase_id' => $input['purchase_id'],
            'device' => $input['device'],
            'purc_is_cencal' => 0,
            'purc_tel_status' => 7,
            'purc_follow_up_date' => null,
            'purc_is_expire' => 0,
        ]);
        DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', $input['business_type'])->delete();
        $this->addPurchasePlanHistory($business_id, $input['business_type'], $new_start_date);

        if ($input['plan_type'] == 3) {
            $userdata = User::where('id', '=', $user_id)->select(['default_business_id', 'default_political_business_id'])->first();
            $getPurchaseData = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', $input['business_type'])->first();
            if ($getPurchaseData->purc_business_type == 1) {

                $checkPBusiness = PoliticalBusiness::where('pb_id', $userdata->default_political_business_id)->where('user_id', $user_id)->where('pb_is_deleted', 0)->first();
                if(empty($checkPBusiness)) {
                    $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id, 0);
                }
                else {
                    $purchase = Purchase::where('purc_business_id', $userdata->default_political_business_id)->where('purc_business_type', 2)->first();
                    if ($purchase->purc_plan_id == 3) {
                        $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id, $userdata->default_political_business_id);
                    }
                    else {
                        $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id, 0);
                    }
                }

                // $this->addPoliticalBusinessWhilePlanIsThree($user_id, $plan_id, $userdata->default_political_business_id);

            } else {

                $purchase = Purchase::where('purc_business_id', $userdata->default_business_id)->where('purc_business_type', 1)->first();
                if ($purchase->purc_plan_id == 3) {
                    $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id, $userdata->default_business_id);
                }
                else {
                    $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id, 0);
                }

                // $this->addSimpleBusinessWhilePlanIsThree($user_id, $plan_id, $userdata->default_business_id);

            }
        }

        $bg_credit = !empty($userData->bg_credit) ? $userData->bg_credit : 0;
        $plan_bg_credit = !empty($plantrial->bg_credit) ? $plantrial->bg_credit : 0;
        $userData->bg_credit = $bg_credit + $plan_bg_credit;
        $userData->save();

        $usercredit = DB::table('users')->where('id', '=', $user_id)->select('user_credit', 'id')->first();

        return response()->json(['status' => true, 'message' => 'Purchase Plan successfully Added', 'user_credit' => $usercredit->user_credit]);
    }

    //  next two function use when user purchase plan type three and user have no any default business

    function addSimpleBusinessWhilePlanIsThree($user_id, $plan_id, $business_id = 0)
    {
        if ($business_id != 0) {
            $start_date = date('Y-m-d');

            $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
            $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));
            $purchase = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 1)->first();
            $new_start_date = "";
            if ($purchase->purc_plan_id == 3) {
                Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 1)->update(array(
                    'purc_plan_id' => $plan_id,
                    'purc_start_date' => $start_date,
                    'purc_end_date' => $end_date,
                    'purc_is_cencal' => 0,
                    'purc_tel_status' => 7,
                    'purc_follow_up_date' => null,
                    'purc_is_expire' => 0,
                ));
            } else {

                $business = new Business();
                $business->busi_name = 'Business Name';
                $business->user_id = $user_id;
                $business->busi_email = '';
                $business->busi_mobile = '';
                $business->save();
                $business_id = $business->id;

                $start_date = date('Y-m-d');

                $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));

                $purchase = new Purchase();
                $purchase->purc_user_id = $user_id;
                $purchase->purc_business_id = $business_id;
                $purchase->purc_plan_id = $plan_id;
                $purchase->purc_start_date = $start_date;
                $purchase->purc_end_date = $end_date;
                $purchase->purc_business_type = 1;
                $purchase->purc_tel_status = 7;
                $purchase->purc_follow_up_date = null;
                $purchase->save();
                $this->addPurchasePlanHistory($business_id, 1);

                // if (!empty($purchase->purc_end_date)) {
                //     $tmp_end_date = Carbon::parse($purchase->purc_end_date);
                //     $tmp_start_date = Carbon::now();
                //     $diff = $tmp_end_date->diffInDays($tmp_start_date);
                //     $new_start_date = $tmp_start_date->addDays($diff);
                //     $end_date = $tmp_end_date->addDays($diff);
                // }
                // Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 1)->update(array(
                //     'purc_start_date' => $start_date,
                //     'purc_end_date' => $end_date,
                //     'purc_is_cencal' => 0,
                //     'purc_tel_status' => 7,
                //     'purc_follow_up_date' => null,
                //     'purc_is_expire' => 0,
                // ));
            }
            DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 1)->delete();
            $this->addPurchasePlanHistory($business_id, 1, $new_start_date);
        } else {
            $checkPurchase = Purchase::where('purchase_plan.purc_user_id', $user_id)->where('purchase_plan.purc_business_type', 1)->join('business', 'business.busi_id', '=', 'purchase_plan.purc_business_id')->where('business.busi_delete', 0)->where(function ($query) {
                $query->where('purchase_plan.purc_plan_id', 3)
                    ->orWhere('purchase_plan.purc_is_expire', 1);
            })->first();
            if (empty($checkPurchase)) {
                $business = new Business();
                $business->busi_name = 'Business Name';
                $business->user_id = $user_id;
                $business->busi_email = '';
                $business->busi_mobile = '';
                $business->save();
                $business_id = $business->id;

                $start_date = date('Y-m-d');

                $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));

                $purchase = new Purchase();
                $purchase->purc_user_id = $user_id;
                $purchase->purc_business_id = $business_id;
                $purchase->purc_plan_id = $plan_id;
                $purchase->purc_start_date = $start_date;
                $purchase->purc_end_date = $end_date;
                $purchase->purc_business_type = 1;
                $purchase->purc_tel_status = 7;
                $purchase->purc_follow_up_date = null;
                $purchase->save();
                $this->addPurchasePlanHistory($business_id, 1);
            } else {
                $start_date = date('Y-m-d');
                $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));
                $purchase = Purchase::where('purc_id', $checkPurchase->purc_id)->first();
                $new_start_date = "";
                if ($purchase->purc_plan_id == 3) {
                    Purchase::where('purc_id', $checkPurchase->purc_id)->update(array(
                        'purc_plan_id' => $plan_id,
                        'purc_start_date' => $start_date,
                        'purc_end_date' => $end_date,
                        'purc_is_cencal' => 0,
                        'purc_tel_status' => 7,
                        'purc_follow_up_date' => null,
                        'purc_is_expire' => 0,
                    ));
                } else {
                    if (!empty($purchase->purc_end_date)) {
                        $tmp_end_date = Carbon::parse($purchase->purc_end_date);
                        $tmp_start_date = Carbon::now();
                        $diff = $tmp_end_date->diffInDays($tmp_start_date);
                        $new_start_date = $tmp_start_date->addDays($diff);
                        $end_date = $tmp_end_date->addDays($diff);
                    }
                    Purchase::where('purc_id', $checkPurchase->purc_id)->update(array(
                        'purc_start_date' => $start_date,
                        'purc_end_date' => $end_date,
                        'purc_is_cencal' => 0,
                        'purc_tel_status' => 7,
                        'purc_follow_up_date' => null,
                        'purc_is_expire' => 0,
                    ));
                }
                DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 1)->delete();
                $this->addPurchasePlanHistory($business_id, 1, $new_start_date);
            }

            $user_data = User::find($user_id);
            if ($user_data->default_business_id == '' || empty($user_data->default_business_id) || $user_data->default_business_id == 0) {
                User::where('id', $user_id)->update(array(
                    'default_business_id' => $business_id,
                ));
            }
        }
    }

    function addPoliticalBusinessWhilePlanIsThree($user_id, $plan_id, $business_id = 0)
    {
        if ($business_id != 0) {
            $start_date = date('Y-m-d');

            $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
            $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));
            $purchase = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 2)->first();
            $new_start_date = "";
            if ($purchase->purc_plan_id == 3) {
                Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 2)->update(array(
                    'purc_plan_id' => $plan_id,
                    'purc_start_date' => $start_date,
                    'purc_end_date' => $end_date,
                    'purc_is_cencal' => 0,
                    'purc_tel_status' => 7,
                    'purc_follow_up_date' => null,
                    'purc_is_expire' => 0,
                ));
            } else {

                $business = new PoliticalBusiness();
                $business->pb_name = 'Person name';
                $business->user_id = $user_id;
                $business->pb_designation = '';
                $business->pb_mobile = '';
                $business->pb_pc_id = 1;
                $business->save();
                $business_id = $business->id;

                $start_date = date('Y-m-d');

                $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));

                $purchase = new Purchase();
                $purchase->purc_user_id = $user_id;
                $purchase->purc_business_id = $business_id;
                $purchase->purc_plan_id = $plan_id;
                $purchase->purc_start_date = $start_date;
                $purchase->purc_end_date = $end_date;
                $purchase->purc_business_type = 2;
                $purchase->purc_tel_status = 7;
                $purchase->purc_follow_up_date = null;
                $purchase->save();
                $this->addPurchasePlanHistory($business_id, 2);

                // if (!empty($purchase->purc_end_date)) {
                //     $tmp_end_date = Carbon::parse($purchase->purc_end_date);
                //     $tmp_start_date = Carbon::now();
                //     $diff = $tmp_end_date->diffInDays($tmp_start_date);
                //     $new_start_date = $tmp_start_date->addDays($diff);
                //     $end_date = $tmp_end_date->addDays($diff);
                // }
                // Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 2)->update(array(
                //     'purc_start_date' => $start_date,
                //     'purc_end_date' => $end_date,
                //     'purc_is_cencal' => 0,
                //     'purc_tel_status' => 7,
                //     'purc_follow_up_date' => null,
                //     'purc_is_expire' => 0,
                // ));
            }
            DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 2)->delete();
            $this->addPurchasePlanHistory($business_id, 2, $new_start_date);
        } else {
            $checkPurchase = Purchase::where('purchase_plan.purc_user_id', $user_id)->where('purchase_plan.purc_business_type', 2)->join('political_business', 'political_business.pb_id', '=', 'purchase_plan.purc_business_id')->where('political_business.pb_is_deleted', 0)->where(function ($query) {
                $query->where('purchase_plan.purc_plan_id', 3)
                    ->orWhere('purchase_plan.purc_is_expire', 1);
            })->first();
            if (empty($checkPurchase)) {
                $business = new PoliticalBusiness();
                $business->pb_name = 'Person name';
                $business->user_id = $user_id;
                $business->pb_designation = '';
                $business->pb_mobile = '';
                $business->pb_pc_id = 1;
                $business->save();
                $business_id = $business->id;

                $start_date = date('Y-m-d');

                $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));

                $purchase = new Purchase();
                $purchase->purc_user_id = $user_id;
                $purchase->purc_business_id = $business_id;
                $purchase->purc_plan_id = $plan_id;
                $purchase->purc_start_date = $start_date;
                $purchase->purc_end_date = $end_date;
                $purchase->purc_business_type = 2;
                $purchase->purc_tel_status = 7;
                $purchase->purc_follow_up_date = null;
                $purchase->save();
                $this->addPurchasePlanHistory($business_id, 2);
            } else {
                $start_date = date('Y-m-d');
                $plantrial = Plan::where('plan_id', '=', $plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $plantrial->plan_validity . ' days'));
                $purchase = Purchase::where('purc_id', $checkPurchase->purc_id)->first();
                $new_start_date = "";
                if ($purchase->purc_plan_id == 3) {
                    Purchase::where('purc_id', $checkPurchase->purc_id)->update(array(
                        'purc_plan_id' => $plan_id,
                        'purc_start_date' => $start_date,
                        'purc_end_date' => $end_date,
                        'purc_is_cencal' => 0,
                        'purc_tel_status' => 7,
                        'purc_follow_up_date' => null,
                        'purc_is_expire' => 0,
                    ));
                } else {
                    if (!empty($purchase->purc_end_date)) {
                        $tmp_end_date = Carbon::parse($purchase->purc_end_date);
                        $tmp_start_date = Carbon::now();
                        $diff = $tmp_end_date->diffInDays($tmp_start_date);
                        $new_start_date = $tmp_start_date->addDays($diff);
                        $end_date = $tmp_end_date->addDays($diff);
                    }
                    Purchase::where('purc_id', $checkPurchase->purc_id)->update(array(
                        'purc_start_date' => $start_date,
                        'purc_end_date' => $end_date,
                        'purc_is_cencal' => 0,
                        'purc_tel_status' => 7,
                        'purc_follow_up_date' => null,
                        'purc_is_expire' => 0,
                    ));
                }
                DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 2)->delete();
                $this->addPurchasePlanHistory($business_id, 2, $new_start_date);
            }
            $user_data = User::find($user_id);
            if ($user_data->default_political_business_id == '' || empty($user_data->default_political_business_id) || $user_data->default_political_business_id == 0) {
                User::where('id', $user_id)->update(array(
                    'default_political_business_id' => $business_id,
                ));
            }
        }
    }


    public function cencalPurchasedPlan(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        Purchase::where('purc_id', $input['id'])->where('purc_user_id', $user_id)->update(array(
            'purc_is_cencal' => 1,
        ));

        return response()->json(['status' => true, 'message' => 'plan Succesfully cancel']);
    }

    public function exiprePurchasedPlan(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        Purchase::where('purc_id', $input['id'])->update(array(
            'purc_is_expire' => 1,
        ));

        return response()->json(['status' => true, 'message' => 'plan expired']);
    }

    public function getMyPurchasePlanList(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $activeplan = DB::table('purchase_plan')->where('purc_user_id', '=', $user_id)->where('purc_is_cencal', '=', 0)->Where('purc_is_expire', '=', 0)->join('business', 'purchase_plan.purc_business_id', '=', 'business.busi_id')->join('plan', 'purchase_plan.purc_plan_id', '=', 'plan.plan_id')->get()->toArray();

        foreach ($activeplan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
        }

        $activeplan = array_map(function ($value) {
            return (array)$value;
        }, $activeplan);

        $finalarr = array();
        for ($i = 0; $i < count($activeplan); $i++) {


            $newdata = array_map(function ($v) {
                return (is_null($v)) ? "" : $v;
            }, $activeplan[$i]);


            array_push($finalarr, $newdata);
        }

        $expiredPlan = DB::table('purchase_plan')->where('purc_user_id', '=', $user_id)->Where('purc_is_expire', '=', 1)->join('business', 'purchase_plan.purc_business_id', '=', 'business.busi_id')->join('plan', 'purchase_plan.purc_plan_id', '=', 'plan.plan_id')->get();

        foreach ($expiredPlan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
        }

        $cencaledplan = DB::table('purchase_plan')->where('purc_user_id', '=', $user_id)->where('purc_is_cencal', '=', 1)->join('business', 'purchase_plan.purc_business_id', '=', 'business.busi_id')->join('plan', 'purchase_plan.purc_plan_id', '=', 'plan.plan_id')->get();


        foreach ($cencaledplan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
        }

        if (!empty($activeplan) || !empty($expiredPlan) || !empty($cencaledplan)) {
            return response()->json(['activeplan' => $finalarr, 'expiredplan' => $expiredPlan, 'cencaledplan' => $cencaledplan, 'status' => true, 'message' => 'List of all Plan']);
        } else {
            return response()->json(['status' => false, 'message' => "You haven't purchased any plan"]);
        }
    }
    public function testplan(Request $request)
    {
        $input = $request->all();
        $start_dates = date('Y-m-d');
        $business = DB::table('purchase_plan')->where('purc_business_id', '=', $input['business_id'])->select('purc_plan_id', 'purc_end_date')->first();
        $primiumPlanInfo = DB::table('plan')->where('plan_id', '=', 2)->select('plan_information', 'plan_actual_price', 'plan_descount')->first();
        if ($business->purc_plan_id == 1) {
            $plantrial = Plan::where('plan_sku', '=', '000FREESKU')->select('plan_validity')->first();
            $start_date = strtotime($start_dates);
            $end_date = strtotime($business->purc_end_date);
            $days = ($end_date - $start_date) / 60 / 60 / 24;
            if ($days > $plantrial->plan_validity && $days > 0) {
                $this_plan_expire_no_trial = 1;
            } else {
                $this_plan_expire_no_trial = 0;
            }
        } else {
            $this_plan_expire_no_trial = 0;
        }
        $temparray = array(
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_2599',
                'plan_actual_price' => 2599,
                "plan_discount_price" => $primiumPlanInfo->plan_actual_price,
                "plan_descount" => $primiumPlanInfo->plan_descount . " Discount for limited time",
                "plan_information" => unserialize($primiumPlanInfo->plan_information),
                "plan_validity" => "365",
                "plan_validity_type" => "days"
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_2299',
                'plan_actual_price' => 2299,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_1999',
                'plan_actual_price' => 1999,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_1699',
                'plan_actual_price' => 1699,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_1399',
                'plan_actual_price' => 1399,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_1099',
                'plan_actual_price' => 1099,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_799',
                'plan_actual_price' => 799,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_499',
                'plan_actual_price' => 499,
            ],
            [
                'plan_id' => 2,
                'plan_name' => 'Premium',
                'plan_sku' => 'premium_199',
                'plan_actual_price' => 199,
            ]
        );

        return response()->json(['plans' => $temparray, 'status' => true, 'message' => 'List of all Plan', 'this_plan_expire_no_trial' => $this_plan_expire_no_trial]);
    }
    // -------------------------------------- Photos Api -------------------------------------

    public function savePhotos(Request $request)
    {

        $input = $request->all();

        $logo = $request->file('image');

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $path  =  $this->uploadFile($request, null, "image", 'post-img');

        $photo = new Photos();
        $photo->photo_user_id = $user_id;
        $photo->photo_url = $path;
        $photo->photo_business_id = $input['business_id'];
        $photo->photo_business_type = $input['business_type'];
        $photo->save();

        $total = DB::table('photos')->where('photo_user_id', $user_id)->count();
        $userData = User::find($user_id);
        $userData->total_post_download = $total;
        $userData->save();

        return response()->json(['status' => true, 'message' => "Image successfully saved"]);
    }

    public function getPhotos(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $page = $request['page'] == NULL ? 1 : $request['page'];
        $limit = 10;
        $offset = $limit * ($page - 1);

        $getallphotos = DB::table('photos')->join('users', 'photos.photo_user_id', '=', 'users.id')->select('users.name', 'photos.photo_url', 'photos.photo_id')->where('photos.photo_is_delete', '=', 0)->where('photos.photo_user_id', '=', $user_id)->orderBy('photos.photo_id', 'DESC')->limit($limit)->offset($offset)->get();

        if (!empty($getallphotos)) {
            return response()->json(['data' => $getallphotos, 'status' => true, 'message' => "Image successfully get"]);
        } else {
            return response()->json(['status' => false, 'message' => "You don't have any image yet"]);
        }
    }

    // --------------------------------------------------------------------------------------------------------------------------------



    function drawBorder(&$img, &$color, $thickness = 1)
    {
        $x1 = 50;
        $y1 = 50;

        $x2 = ImageSX($img) - 50;
        $y2 = ImageSY($img) - 50;

        for ($i = 0; $i < $thickness; $i++) {
            ImageRectangle($img, $x1++, $y1++, $x2--, $y2--, $color);
        }
    }


    public function getTemplates(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $defaultbusiness = User::where('id', '=', $user_id)->select('default_business_id')->first();

        if ($defaultbusiness == null || $defaultbusiness == '' || empty($defaultbusiness)) {

            return response()->json(['status' => false, 'message' => "You don't have any default business yet"]);
        }

        $businessid = $defaultbusiness->default_business_id;

        $bdetail = Business::where('busi_id', '=', $businessid)->select('busi_name', 'busi_email', 'busi_mobile', 'busi_website', 'busi_address', 'busi_logo')->first();

        if ($bdetail == null || $bdetail == '' || empty($bdetail)) {

            return response()->json(['status' => false, 'message' => "You don't have any default business yet"]);
        }

        $logo_img = $bdetail->busi_logo;

        $item = array();

        $images = imagecreatefrompng(public_path('/') . 'images1.png');

        imagealphablending($images, false);
        imagesavealpha($images, true);

        $image_width = imagesx($images);

        $image_height = imagesy($images);

        $company_name = $bdetail->busi_name;

        $email_id = $bdetail->busi_email;

        $mobile_no = $bdetail->busi_mobile;

        $website = $bdetail->busi_website;

        $address = $bdetail->busi_address;

        // company name

        if ($company_name != '') {

            $box = new Box($images);

            $box->setFontFace(public_path('/') . 'font/HONEJ___.ttf'); // http://www.dafont.com/franchise.font

            $box->setFontColor(new Color(0, 0, 0));

            $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);

            $box->setFontSize(70);

            $box->setBox(20, 20, $image_width, $image_height);

            $box->setTextAlign('center', 'top');

            $box->draw($company_name);
        }
        if ($logo_img != '') {
            $second = @imagecreatefrompng($logo_img);
            if (!$second) {
                return response()->json(['status' => false, 'message' => "Not valid png"]);
            }

            imagecopyresized($images, $second, 20, 20, 0, 0, 468, 356, 468, 356);
        }


        // Email id

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(40, 20, $image_width, $image_height - 110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($email_id);

        // mobile no

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(40, 20, $image_width, $image_height - 110);

        $box->setTextAlign('center', 'bottom');

        $box->draw($mobile_no);

        // website

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(-40, 20, $image_width, $image_height - 110);

        $box->setTextAlign('right', 'bottom');

        $box->draw($website);

        //multi line text

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/minecraftia.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setLineHeight(1.5);

        //$box->enableDebug();

        $box->setBox(40, 20, $image_width, $image_height - 40);

        $box->setTextAlign('left', 'bottom');

        $box->draw($address);

        $tempname = 'images/' . rand() . '.png';
        $name = public_path('/') . $tempname;

        imagepng($images, $name);

        imagedestroy($images);

        $data = URL('/public') . '/' . $tempname;
        array_push($item, $data);

        // --------------------------------------- second template

        $logo_img = $bdetail->busi_logo;


        $images = imagecreatefrompng(public_path('/') . 'images1.png');

        $image_width = imagesx($images);

        $image_height = imagesy($images);

        $color = imagecolorallocate($images, 155, 155, 155);
        $this->drawBorder($images, $color, 10);

        imagealphablending($images, false);
        imagesavealpha($images, true);


        $company_name = $bdetail->busi_name;

        $email_id = $bdetail->busi_email;

        $mobile_no = ' ' . $bdetail->busi_mobile . ' ';

        $website = $bdetail->busi_website;

        $address = $bdetail->busi_address;

        // company name

        if ($company_name != '') {

            $box = new Box($images);

            $box->setFontFace(public_path('/') . 'font/HONEJ___.ttf'); // http://www.dafont.com/franchise.font

            $box->setFontColor(new Color(0, 0, 0));

            $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);

            $box->setFontSize(70);

            $box->setBox(20, 50, $image_width, $image_height);

            $box->setTextAlign('center', 'top');

            $box->draw($company_name);
        }
        if ($logo_img != '') {
            $second = @imagecreatefrompng($logo_img);
            if (!$second) {
                return response()->json(['status' => false, 'message' => "Not valid png"]);
            }
            imagecopyresized($images, $second, 1300, 20, 0, 0, 468, 356, 468, 356);
        }


        $mimage = imagecreatefrompng(public_path('/images') . '/phone.png');
        imagecopyresized($images, $mimage, 200, $image_height - 120, 0, 0, 30, 30, 30, 30);

        // mobile no

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBackgroundColor(new Color(255, 255, 255));

        $box->setBox(120, 80, $image_width, $image_height - 110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($mobile_no);

        // Email id

        $mimage = imagecreatefrompng(public_path('/images') . '/phone.png');
        imagecopyresized($images, $mimage, 1000, $image_height - 120, 0, 0, 30, 30, 30, 30);

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBackgroundColor(new Color(255, 255, 255));

        $box->setBox(0, 80, $image_width, $image_height - 110);

        $box->setTextAlign('center', 'bottom');

        $box->draw($email_id);


        $mimage = imagecreatefrompng(public_path('/images') . '/phone.png');
        imagecopyresized($images, $mimage, 1750, $image_height - 120, 0, 0, 30, 30, 30, 30);

        // website

        $box = new Box($images);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBackgroundColor(new Color(255, 255, 255));


        $box->setBox(-120, 80, $image_width, $image_height - 110);

        $box->setTextAlign('right', 'bottom');

        $box->draw($website);


        $tempname = 'images/' . rand() . '.png';
        $name = public_path('/') . $tempname;

        imagepng($images, $name);

        imagedestroy($images);

        $data = URL('/public') . '/' . $tempname;
        array_push($item, $data);

        //  -------------------------------------------- third


        $logo_img = $bdetail->busi_logo;


        $images = imagecreatefrompng(public_path('/') . 'images1.png');

        $image_width = imagesx($images);

        $image_height = imagesy($images);

        imagealphablending($images, false);
        imagesavealpha($images, true);


        $company_name = $bdetail->busi_name;

        $email_id = $bdetail->busi_email;

        $mobile_no = ' ' . $bdetail->busi_mobile . ' ';

        $website = $bdetail->busi_website;

        $address = $bdetail->busi_address;


        // company name

        if ($company_name != '') {

            $box = new Box($images);

            $box->setFontFace(public_path('/') . 'font/HONEJ___.ttf'); // http://www.dafont.com/franchise.font

            $box->setFontColor(new Color(0, 0, 0));

            $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);

            $box->setFontSize(70);

            $box->setBox(20, 50, $image_width, $image_height);

            $box->setTextAlign('center', 'top');

            $box->draw($company_name);
        }
        if ($logo_img != '') {
            $second = @imagecreatefrompng($logo_img);
            if (!$second) {
                return response()->json(['status' => false, 'message' => "Not valid png"]);
            }
            imagecopyresized($images, $second, 750, $image_height - 500, 0, 0, 468, 356, 468, 356);
        }




        // mobile no

        $box = new Box($images);

        $mimage = imagecreatefrompng(public_path('/images') . '/phone.png');
        imagecopyresized($images, $mimage, 650, $image_height - 100, 0, 0, 30, 30, 30, 30);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(700, 50, $image_width, $image_height - 110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($mobile_no);

        // Email id


        $box = new Box($images);


        $mimage = imagecreatefrompng(public_path('/images') . '/phone.png');
        imagecopyresized($images, $mimage, 950, $image_height - 100, 0, 0, 30, 30, 30, 30);


        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(1000, 50, $image_width, $image_height - 110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($email_id);

        // website

        $box = new Box($images);

        $mimage = imagecreatefrompng(public_path('/images') . '/phone.png');
        imagecopyresized($images, $mimage, 650, $image_height - 50, 0, 0, 30, 30, 30, 30);

        $box->setFontFace(public_path('/') . 'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(50, 100, $image_width, $image_height - 110);

        $box->setTextAlign('center', 'bottom');

        $box->draw($website);


        $tempname = 'images/' . rand() . '.png';
        $name = public_path('/') . $tempname;

        imagepng($images, $name);

        imagedestroy($images);

        $data = URL('/public') . '/' . $tempname;
        array_push($item, $data);

        return response()->json(['data' => $item, 'status' => true, 'message' => "Image Genetares"]);
    }

    public function getAllVideoPosts(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $currnt_date = date('Y-m-d');

        $festivals = DB::table('video_data')->where('video_type', '=', 'festival')->whereDate('video_date', '>=', $currnt_date)->where('video_is_delete', 0)->orderBy('video_date', 'asc')->offset(0)->limit(10)->get();

        $incidents = DB::table('video_data')->where('video_type', '=', 'incident')->where('video_is_delete', '=', 0)->get();

        $data_festival = array();
        $data_incident = array();

        foreach ($festivals as $key => $festival) {
            $data = array();

            $data['id'] = strval($festival->video_id);
            $data['video_name'] = !empty($festival->video_name) ? $festival->video_name : "";
            $data['video_date'] = !empty($festival->video_date) ? date('d-m-Y', strtotime($festival->video_date)) : "";
            $data['video_image'] = !empty($festival->video_image) ? Storage::url($festival->video_image) : "";
            $data['video_type'] = !empty($festival->video_type) ? $festival->video_type : "";

            array_push($data_festival, $data);
        }

        foreach ($incidents as $key => $incident) {
            $data = array();

            $data['id'] = strval($incident->video_id);
            $data['video_name'] = !empty($incident->video_name) ? $incident->video_name : "";
            $data['video_date'] = !empty($incident->video_date) ? date('d-m-Y', strtotime($incident->video_date)) : "";
            $data['video_image'] = !empty($incident->video_image) ? Storage::url($incident->video_image) : "";
            $data['video_type'] = !empty($incident->video_type) ? $incident->video_type : "";

            array_push($data_incident, $data);
        }
        if (count($festivals) != 0 || count($incidents) != 0) {
            return response()->json(['festival' => $data_festival, 'category' => $data_incident, 'status' => true, 'message' => "Video List Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Video Not Found"]);
        }
    }

    public function getAdvetisement(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $adv_datas = DB::table('advetisement')->where('is_delete', '=', 0)->get();
        $advetisement = array();

        foreach ($adv_datas as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['adv_image'] = !empty($value->adv_image) ? Storage::url($value->adv_image) : "";
            $data['adv_number'] = !empty($value->adv_number) ? $value->adv_number : "";
            $data['adv_link'] = !empty($value->adv_link) ? $value->adv_link : "";

            array_push($advetisement, $data);
        }
        if (count($adv_datas) != 0) {
            return response()->json(['data' => $advetisement, 'status' => true, 'message' => "Advetisement List Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Advetisement Not Found"]);
        }
    }

    public function getLanguage(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $user_language = User::where('id', $user_id)->value('user_language');
        $user_language = !empty($user_language) ? explode(',', $user_language) : "";
        $languages = Language::where('is_delete', '=', 0)->get();

        $language = array();

        foreach ($languages as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['status'] = $user_language != "" ? (in_array($value->id, $user_language) ? true : false) : false;
            $data['language'] = !empty($value->name) ? $value->name : "";
            array_push($language, $data);
        }

        if (count($languages) != 0) {
            return response()->json(['data' => $language, 'status' => true, 'message' => "Language List Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Language Not Found"]);
        }
    }

    public function getLanguageVideo(Request $request)
    {
        $input = $request->all();
        $videoid = $input['videoid'];
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $offset = 0;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();

        $category_data = DB::table('video_data')->where('video_id', $videoid)->first();
        $category_type = $category_data->video_type;
        if ($category_type == 'festival') {
            $category_type = 4;
        } else {
            $category_type = 6;
        }

        $limitData = Helper::getUserRemainingLimit($user_id, $category_type, $videoid);
        $limitData['type'] = $category_type;

        $user_language = User::where('id', $user_id)->value('user_language');
        $user_selected_language = explode(",", $user_language);
        array_push($user_selected_language, '2', '4');

        $categories = VideoSubCategory::where('festival_id', $videoid)->where('is_delete', 0)->get();
        $sub_category_id = $input['sub_category_id'];

        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $video = DB::table('video_post_data')->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $video = DB::table('video_post_data')->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            } else {
                $video = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            }
        }

        $language_ids = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->select('language_id')->get()->toArray();

        $language_id_array = [];
        foreach ($language_ids as $id) {
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);

        $videos = array();
        foreach ($video as $key => $value) {
            $data = array();

            $data['id'] = strval($value->id);
            $data['image'] = !empty($value->thumbnail) ? Storage::url($value->thumbnail) : "";
            if ($value->video_store == "LOCAL") {
                $data['video'] = !empty($value->video_url) ? url('/') . '/' . $value->video_url : "";
            } else {
                $data['video'] = !empty($value->video_url) ? Storage::url($value->video_url) : "";
            }
            $data['type'] = strval($value->image_type);
            $data['color'] = !empty($value->color) ? $value->color : "";
            $data['post_mode'] = !empty($value->post_mode) ? $value->post_mode : "light";
            array_push($videos, $data);
        }

        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                } else {
                    $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                } else {
                    $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
            } else {
                $video_next = DB::table('video_post_data')->whereIn('language_id', $user_selected_language)->where('sub_category_id', $sub_category_id)->where('video_post_id', '=', $videoid)->whereIn('language_id', $languageid)->where('is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($video))->get();
            }
        }

        $languages = Language::where('is_delete', '=', 0)->whereIn('id', $language_id_array)->get();

        $language = array();

        foreach ($languages as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['language'] = !empty($value->name) ? $value->name : "";
            array_push($language, $data);
        }

        $next = true;
        if (count($video_next) == 0) {
            $next = false;
        }

        $meta = array(
            'offset' => $offset + count($video),
            'limit' => intval($transactionLimit),
            'record' => count($video),
            'next' => $next
        );

        return response()->json(['categories' => $categories, 'limitData' => $limitData, 'data' => $videos, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => "Video List Successfully"]);

    }

    public function getLanguagePost(Request $request)
    {
        $input = $request->all();
        $postid = $input['postid'];
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $offset = 0;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();

        $user_language = User::where('id', $user_id)->value('user_language');

        if (in_array(0, $languageid)) {
            if ($user_language != null) {

                $post = Post::where('post_category_id', '=', $postid)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->take($transactionLimit)->skip($offset)->get();
            } else {
                $post = Post::where('post_category_id', '=', $postid)->where('post_is_deleted', '=', 0)->take($transactionLimit)->skip($offset)->get();
            }
        } else {
            $post = Post::where('post_category_id', '=', $postid)->whereIn('language_id', $languageid)->where('post_is_deleted', '=', 0)->take($transactionLimit)->skip($offset)->get();
        }

        $posts = array();
        foreach ($post as $key => $value) {
            $data = array();

            $data['id'] = strval($value->post_id);
            $data['image'] = !empty($value->post_content) ? Storage::url($value->post_content) : "";
            $data['image_thumbnail_url'] = !empty($value->post_thumb) ? Storage::url($value->post_thumb) : Storage::url($value->post_content);
            $data['type'] = strval($value->image_type);
            array_push($posts, $data);
        }

        if (in_array(0, $languageid)) {
            if ($user_language != null) {

                $post_next = Post::where('post_category_id', '=', $postid)->where('post_is_deleted', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->take($transactionLimit)->skip($offset + count($post))->get();
            } else {
                $post_next = Post::where('post_category_id', '=', $postid)->where('post_is_deleted', '=', 0)->take($transactionLimit)->skip($offset + count($post))->get();
            }
        } else {
            $post_next = Post::where('post_category_id', '=', $postid)->whereIn('language_id', $languageid)->where('post_is_deleted', '=', 0)->take($transactionLimit)->skip($offset + count($post))->get();
        }

        $next = true;
        if (count($post_next) == 0) {
            $next = false;
        }

        $meta = array(
            'offset' => $offset + count($post),
            'limit' => intval($transactionLimit),
            'record' => count($post),
            'next' => $next
        );

        if (count($post) != 0) {
            return response()->json(['data' => $posts, 'meta' => $meta, 'status' => true, 'message' => "post List Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "post Not Found"]);
        }
    }

    public function getCustomCategoryPosts(Request $request)
    {

        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $user = User::find($user_id);
        $user_selected_language = explode(",", $user->user_language);
        array_push($user_selected_language, '2', '4');

        $new_category_data_greetings = DB::table('custom_cateogry')->where('type', 0)->where('is_active', 1)->whereIn('highlight', array(2, 3))->orderBy('slider_img_position', 'ASC')->get();
        $new_category_data_greetingsArray = array();
        foreach ($new_category_data_greetings as $greeting) {

            $photo = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $greeting->custom_cateogry_id)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->limit(10)->get();

            $temp1['id'] = $greeting->custom_cateogry_id;
            $temp1['title'] = $greeting->name;

            $temp1['img_url'] = array();
            foreach ($photo as $ph_value) {
                $data_ph1['custom_cateogry_id'] = !empty($ph_value->custom_cateogry_id) ? strval($ph_value->custom_cateogry_id) : 0;
                $data_ph1['banner_image'] = !empty($ph_value->banner_image) ? Storage::url($ph_value->banner_image) : "";
                $data_ph1['image'] = !empty($ph_value->image_one) ? Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['image_one'] = !empty($ph_value->image_one) ? Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['position_x'] = $ph_value->position_x;
                $data_ph1['images']['position_y'] = $ph_value->position_y;
                $data_ph1['images']['img_position_x'] = $ph_value->img_position_x;
                $data_ph1['images']['img_position_y'] = $ph_value->img_position_y;
                $data_ph1['images']['img_height'] = $ph_value->img_height;
                $data_ph1['images']['img_width'] = $ph_value->img_width;
                array_push($temp1['img_url'], $data_ph1);
            }

            array_push($new_category_data_greetingsArray, $temp1);
        }

        $onlycat = DB::table('custom_cateogry')->where('type', 0)->where('is_active', 1)->whereIn('highlight', array(2, 3))->orderBy('slider_img_position', 'ASC')->get();


        $finalarry = array();

        $slider = array();

        foreach ($onlycat as $value) {
            $temp = array();
            $temp['custom_cateogry_id'] = strval($value->custom_cateogry_id);
            $temp['name'] = !empty($value->name) ? $value->name : "";
            $temp['custom_image'] = !empty($value->slider_img) ? Storage::url($value->slider_img) : "";

            array_push($finalarry, $temp);
            $slide = array();
            $slide['custom_cateogry_id'] = $value->custom_cateogry_id;
            $slide['slider_img'] = Storage::url($value->slider_img);
            $slide['slider_img_position'] = $value->slider_img_position;
            array_push($slider, $slide);
        }

        $onlycat = DB::table('custom_cateogry')->where('type', 0)->where('is_active', 1)->whereIn('highlight', array(0, 1))->orderBy('slider_img_position', 'ASC')->get();


        foreach ($onlycat as $value) {
            $temp = array();
            $temp['custom_cateogry_id'] = strval($value->custom_cateogry_id);
            $temp['name'] = !empty($value->name) ? $value->name : "";
            $temp['custom_image'] = !empty($value->slider_img) ? Storage::url($value->slider_img) : "";

            array_push($finalarry, $temp);
            $slide = array();
            $slide['custom_cateogry_id'] = $value->custom_cateogry_id;
            $slide['slider_img'] = Storage::url($value->slider_img);
            $slide['slider_img_position'] = $value->slider_img_position;
            array_push($slider, $slide);
        }

        return response()->json(['status' => true, 'message' => 'Successfully set your Preference', 'data' => $finalarry, 'slider' => $slider, 'greeting' => $new_category_data_greetingsArray]);
    }

    public function getLanguageCustomeCategoryPost(Request $request)
    {
        $input = $request->all();
        $catid = $input['catid'];
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $offset = 0;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();

        $category_type = 7;

        $limitData = Helper::getUserRemainingLimit($user_id, $category_type, $catid);
        $limitData['type'] = $category_type;

        $user_language = User::where('id', $user_id)->value('user_language');
        $user_selected_language = explode(",", $user_language);
        array_push($user_selected_language, '2', '4');

        $sub_category_id = $input['sub_category_id'];
        $categoriesIds = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->groupBy('custom_sub_category_id')->pluck('custom_sub_category_id')->toArray();
        $categories = CustomSubCategory::whereIn('id', $categoriesIds)->where('custom_category_id', $catid)->where('is_delete', 0)->get();

        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $cat = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $cat = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_sub_category_id', $sub_category_id)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $cat = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $cat = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_sub_category_id', $sub_category_id)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $cat = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->whereIn('language_id', $languageid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            } else {
                $cat = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_sub_category_id', $sub_category_id)->where('custom_cateogry_id', '=', $catid)->whereIn('language_id', $languageid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            }
        }

        $language_ids = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('is_delete', '=', 0)->where('custom_cateogry_id', '=', $catid)->select('language_id')->get()->toArray();

        $language_id_array = [];
        foreach ($language_ids as $id) {
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);


        $cats = array();
        foreach ($cat as $key => $value) {
            $data = array();

            $data['id'] = strval($value->custom_cateogry_data_id);
            $data['banner_image'] = !empty($value->image_one) ? Storage::url($value->image_one) : "";
            $data['image'] = !empty($value->banner_image) ? Storage::url($value->banner_image) : "";
            $data['position_x'] = !empty($value->position_x) ? $value->position_x : "";
            $data['position_y'] = !empty($value->position_y) ? $value->position_y : "";
            $data['img_position_x'] = !empty($value->img_position_x) ? $value->img_position_x : "";
            $data['img_position_y'] = !empty($value->img_position_y) ? $value->img_position_y : "";
            $data['img_height'] = !empty($value->img_height) ? $value->img_height : "";
            $data['img_width'] = !empty($value->img_width) ? $value->img_width : "";
            $data['post_mode'] = !empty($value->post_mode) ? $value->post_mode : "light";
            $data['type'] = strval($value->image_type);
            array_push($cats, $data);
        }

        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $cat_next = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
                } else {
                    $cat_next = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_sub_category_id', $sub_category_id)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $cat_next = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
                } else {
                    $cat_next = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_sub_category_id', $sub_category_id)->where('custom_cateogry_id', '=', $catid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $cat_next = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_cateogry_id', '=', $catid)->whereIn('language_id', $languageid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
            } else {
                $cat_next = DB::table('custom_cateogry_data')->whereIn('language_id', $user_selected_language)->where('custom_sub_category_id', $sub_category_id)->where('custom_cateogry_id', '=', $catid)->whereIn('language_id', $languageid)->where('is_delete', '=', 0)->orderBy('image_type', 'ASC')->orderBy('custom_cateogry_data_id', 'DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
            }
        }

        $language = array();
        if (!empty($language_id_array)) {

            $languages = Language::where('is_delete', '=', 0)->whereIn('id', $language_id_array)->get();

            foreach ($languages as $key => $value) {
                $data = array();
                $data['id'] = strval($value->id);
                $data['language'] = !empty($value->name) ? $value->name : "";
                array_push($language, $data);
            }
        }

        $next = true;
        if (count($cat_next) == 0) {
            $next = false;
        }

        $meta = array(
            'offset' => $offset + count($cat),
            'limit' => intval($transactionLimit),
            'record' => count($cat),
            'next' => $next
        );

        return response()->json(['categories' => $categories, 'limitData' => $limitData, 'data' => $cats, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => "Custome Category Post List Successfully"]);
    }

    public function GetAllFestivalVideo(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $user = User::find($user_id);
        $user_selected_language = explode(",", $user->user_language);
        array_push($user_selected_language, '2', '4');

        $currnt_date = date('Y-m-d');
        if ($input['date'] != '') {
            $date = str_replace('/', '-', $input['date']);
            $date = date('Y-m-d', strtotime($date));

            $videos = VideoData::where('video_date', '=', $date)->where('video_type', '=', 'festival')->where('video_is_delete', '=', 0)->get()->toArray();
        } else {

            $videos1 = VideoData::where('video_date', '>=', date('Y-m-d'))->where('video_type', '=', 'festival')->where('video_is_delete', '=', 0)->get()->toArray();

            $videos2 = VideoData::where('video_date', '<', date('Y-m-d'))->where('video_type', '=', 'festival')->where('video_is_delete', '=', 0)->get()->toArray();

            $videos = array_merge($videos1, $videos2);
        }

        $video = array();
        $data_video = array();
        for ($i = 0; $i < sizeof($videos); $i++) {
            $videos[$i]['video_date'] = date("d-m-Y", strtotime($videos[$i]['video_date']));
            $data_video['video_id'] = strval($videos[$i]['video_id']);
            $data_video['video_name'] = !empty($videos[$i]['video_name']) ? $videos[$i]['video_name'] : "";
            $data_video['video_image'] = !empty($videos[$i]['video_image']) ? Storage::url($videos[$i]['video_image']) : "";
            $data_video['video_date'] = $videos[$i]['video_date'];

            array_push($video, $data_video);
        }

        $olddate = array();
        $newdate = array();
        $current = date('d-m-Y');
        foreach ($video as $fest) {
            if (strtotime($fest['video_date']) >= strtotime($current)) {
                array_push($newdate, $fest);
            } else {
                array_push($olddate, $fest);
            }
        }

        usort($newdate, function ($a, $b) {
            return strtotime($a['video_date']) <=> strtotime($b['video_date']);
        });

        usort($olddate, function ($a, $b) {
            return strtotime($a['video_date']) <=> strtotime($b['video_date']);
        });

        $finalarr = array_merge($newdate, array_reverse($olddate));

        if (!empty($videos)) {

            return response()->json(['video' => $finalarr, 'status' => true, 'message' => 'List of all video', 'current_date' => $currnt_date,]);
        } else {
            return response()->json(['status' => false, 'message' => 'There is no video on this date', 'current_date' => $currnt_date]);
        }
    }

    public function Plans(Request $request)
    {
        $new_or_renewal = $request->new_or_renewal;
        $plan_type = $request->plan_type;
        $plans = Plan::where('status', '!=', 1)->where('new_or_renewal', $new_or_renewal)->where(function ($query) use ($plan_type) {
            $query->where('plan_type', $plan_type);
            $query->orWhere('plan_type', 3);
        })->where('plan_id', '!=', 3)->orderBy('order_no', 'asc')->get();
        $plan = array();

        foreach ($plans as $key => $value) {
            $data['id'] = strval($value->plan_id);
            $data['plan_type'] = !empty($value->plan_type) ? $value->plan_type : "";
            $data['plan_name'] = !empty($value->plan_or_name) ? $value->plan_or_name : "";
            $data['price'] = !empty($value->plan_actual_price) ? $value->plan_actual_price : "";
            $data['plan_validity'] = !empty($value->plan_validity) ? $value->plan_validity : "";
            $data['plan_validity_type'] = !empty($value->plan_validity_type) ? $value->plan_validity_type : "";
            $data['order_no'] = !empty($value->order_no) ? $value->order_no : 0;
            $data['bg_credit'] = !empty($value->bg_credit) ? $value->bg_credit : 0;
            $data['image'] = !empty($value->image) ? Storage::url($value->image) : "";
            array_push($plan, $data);
        }
        return response()->json(['data' => $plan, 'status' => true, 'message' => 'List of Plan']);
    }

    public function getBusinessCategoryImages(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $type = $request->type;

        $offset = 0;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);

        $isVideoAvailable = false;
        $videoPost = DB::table('business_category_post_data')->where('post_type', 'video')->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->first();
        if ($videoPost) {
            $isVideoAvailable = true;
        }

        $category_type = 0;
        if ($type == 'image') {
            $category_type = 1;
        } else {
            $category_type = 2;
        }

        $limitData = Helper::getUserRemainingLimit($user_id, $category_type, $request->buss_cat_id);
        $limitData['type'] = $category_type;

        $sub_category_id = $input['sub_category_id'];
        $categoriesIds = DB::table('business_category_post_data')->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->groupBy('business_sub_category_id')->pluck('business_sub_category_id')->toArray();
        $categories = BusinessSubCategory::whereIn('id', $categoriesIds)->where('business_category_id', $request->buss_cat_id)->where('is_delete', 0)->get();

        $user_language = User::where('id', $user_id)->value('user_language');
        $user_selected_language = explode(',', $user_language);
        array_push($user_selected_language, '2', '4');

        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $images = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')/*->orderByRaw("FIELD(language_id , ".$user_language.") DESC")*/->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $images = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('business_sub_category_id', $sub_category_id)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')/*->orderByRaw("FIELD(language_id , ".$user_language.") DESC")*/->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $images = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $images = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('business_sub_category_id', $sub_category_id)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $images = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->whereIn('language_id', $languageid)->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            } else {
                $images = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('business_sub_category_id', $sub_category_id)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->whereIn('language_id', $languageid)->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            }
        }

        $language_ids = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->select('language_id')->get()->toArray();
        $language_id_array = [];
        foreach ($language_ids as $id) {
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);

        $buss_images = array();
        foreach ($images as $img_key => $img_value) {

            if ($type == "image") {
                $img_data['image_id'] = strval($img_value->id);
                $img_data['image_url'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) : "";
                $img_data['image_thumbnail_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                $img_data['image_type'] = strval($img_value->image_type);
                $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";
                $img_data['post_mode'] = !empty($img_value->post_mode) ? strval($img_value->post_mode) : "light";
            } else {
                $img_data['video_id'] = strval($img_value->id);
                $img_data['video_thumbnail'] = !empty($img_value->video_thumbnail) ? Storage::url($img_value->video_thumbnail) : "";
                $img_data['video_url'] = !empty($img_value->video_url) ? url('/') . '/' . $img_value->video_url : "";
                $img_data['video_type'] = strval($img_value->image_type);
                $img_data['video_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";
                $img_data['post_mode'] = !empty($img_value->post_mode) ? strval($img_value->post_mode) : "light";
            }

            array_push($buss_images, $img_data);
        }
        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $Getimages_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($images))->get();
                } else {
                    $Getimages_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('business_sub_category_id', $sub_category_id)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($images))->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $Getimages_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($images))->get();
                } else {
                    $Getimages_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('business_sub_category_id', $sub_category_id)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($images))->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $Getimages_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->whereIn('language_id', $languageid)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($images))->get();
            } else {
                $Getimages_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('business_sub_category_id', $sub_category_id)->where('buss_cat_post_id', '=', $request->buss_cat_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->whereIn('language_id', $languageid)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($images))->get();
            }
        }
        $language = array();

        if (!empty($language_id_array)) {
            $languages = Language::where('is_delete', '=', 0)->whereIn('id', $language_id_array)->get();

            foreach ($languages as $key => $value) {
                $data = array();
                $data['id'] = strval($value->id);
                $data['language'] = !empty($value->name) ? $value->name : "";
                array_push($language, $data);
            }
        }

        $next = true;
        if (count($Getimages_next) == 0) {
            $next = false;
        }
        $meta = array(
            'offset' => $offset + count($images),
            'limit' => intval($transactionLimit),
            'record' => count($images),
            'next' => $next
        );

        return response()->json(['categories' => $categories, 'limitData' => $limitData, 'isVideoAvailable' => $isVideoAvailable, 'buss_images' => $buss_images, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => 'List of all images']);
    }

    public function moveElement(&$array, $a, $b)
    {
        $p1 = array_splice($array, $a, 1);
        $p2 = array_splice($array, 0, $b);
        $array = array_merge($p2, $p1, $array);

        return $array;
    }

    public function CurrntbusinessPhoto(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $offset = 0;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);

        $user_language = User::where('id', $user_id)->value('user_language');
        $user_selected_language = explode(",", $user_language);
        array_push($user_selected_language, '2', '4');

        $type = $request->type;

        $category_type = 0;
        if ($type == 'image') {
            $category_type = 1;
        } else {
            $category_type = 2;
        }

        $limitData = Helper::getUserRemainingLimit($user_id, $category_type, $request->busi_id);
        $limitData['type'] = $category_type;

        $isVideoAvailable = false;
        $videoPost = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', 'video')->where('buss_cat_post_id', '=', $request->busi_id)->where('festival_id', 0)->where('is_deleted', '=', 0)->first();
        if ($videoPost) {
            $isVideoAvailable = true;
        }

        $sub_category_id = $input['sub_category_id'];
        $categoriesIds = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->groupBy('business_sub_category_id')->pluck('business_sub_category_id')->toArray();
        $categories = BusinessSubCategory::whereIn('id', $categoriesIds)->where('business_category_id', $request->busi_id)->where('is_delete', 0)->get();



        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')/*->orderByRaw("FIELD(language_id , ".$user_language.") DESC")*/->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')/*->orderByRaw("FIELD(language_id , ".$user_language.") DESC")*/->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                } else {
                    $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->whereIn('language_id', $languageid)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            } else {
                $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->whereIn('language_id', $languageid)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset)->get();
            }
        }
        if ($sub_category_id == 0) {
            $language_ids = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->select('language_id')->get()->toArray();
        } else {
            $language_ids = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->select('language_id')->get()->toArray();
        }
        $language_id_array = [];
        foreach ($language_ids as $id) {
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);


        $images = array();
        foreach ($currntbusiness_photo as $img_key => $img_value) {
            if ($type == "image") {
                $img_data['image_id'] = strval($img_value->id);
                $img_data['image_url'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) : "";
                $img_data['image_thumbnail_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                $img_data['image_type'] = strval($img_value->image_type);
                $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";
                $img_data['post_mode'] = !empty($img_value->post_mode) ? strval($img_value->post_mode) : "light";
            } else {
                $img_data['id'] = strval($img_value->id);
                $img_data['video'] = !empty($img_value->video_url) ? url('/') . '/' . $img_value->video_url : "";
                $img_data['image'] = !empty($img_value->video_thumbnail) ? Storage::url($img_value->video_thumbnail) : Storage::url($img_value->thumbnail);
                $img_data['type'] = strval($img_value->image_type);
                $img_data['video_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";
                $img_data['post_mode'] = !empty($img_value->post_mode) ? strval($img_value->post_mode) : "light";
            }

            array_push($images, $img_data);
        }

        if (in_array(0, $languageid)) {
            if ($user_language != null) {
                if ($sub_category_id == 0) {
                    $currntbusiness_photo_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
                } else {
                    $currntbusiness_photo_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderByRaw("FIELD(language_id , " . $user_language . ") DESC")->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
                }
            } else {
                if ($sub_category_id == 0) {
                    $currntbusiness_photo_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
                } else {
                    $currntbusiness_photo_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
                }
            }
        } else {
            if ($sub_category_id == 0) {
                $currntbusiness_photo_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->whereIn('language_id', $languageid)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
            } else {
                $currntbusiness_photo_next = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('business_sub_category_id', $sub_category_id)->where('post_type', $type)->where('buss_cat_post_id', '=', $request->busi_id)->where('is_deleted', '=', 0)->where('festival_id', 0)->whereIn('language_id', $languageid)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
            }
        }

        $languages = Language::where('is_delete', '=', 0)->whereIn('id', $language_id_array)->get();

        $language = array();

        foreach ($languages as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['language'] = !empty($value->name) ? $value->name : "";
            array_push($language, $data);
        }

        $next = true;
        if (count($currntbusiness_photo_next) == 0) {
            $next = false;
        }
        $meta = array(
            'offset' => $offset + count($currntbusiness_photo),
            'limit' => intval($transactionLimit),
            'record' => count($currntbusiness_photo),
            'next' => $next
        );

        if ($type == "image") {
            return response()->json(['categories' => $categories, 'limitData' => $limitData, 'isVideoAvailable' => $isVideoAvailable, 'images' => $images, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => 'List of all images']);
        } else {
            return response()->json(['categories' => $categories, 'limitData' => $limitData, 'isVideoAvailable' => $isVideoAvailable, 'videos' => $images, 'meta' => $meta, 'language' => $language, 'status' => true, 'message' => 'List of all images']);
        }
    }


    public function newCategoryAllImage(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $photo = Post::where('post_category_id', '=', $request->category_id)->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id')->orderBy('post_id', 'DESC')->get();

        if (!empty($photo)) {

            return response()->json(['images' => $photo, 'status' => true, 'message' => 'List of all images']);
        } else {
            return response()->json(['status' => false, 'message' => 'There is no images']);
        }
    }

    public function getLanguageWithImage(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $user_language = User::where('id', $user_id)->value('user_language');
        $user_language = !empty($user_language) ? explode(',', $user_language) : "";
        $languages = Language::where('is_delete', '=', 0)->get();

        $language = array();

        foreach ($languages as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['status'] = $user_language != "" ? (in_array($value->id, $user_language) ? true : false) : false;
            $data['language'] = !empty($value->name) ? $value->name : "";
            $data['image'] = !empty($value->image) ? Storage::url($value->image) : "";
            array_push($language, $data);
        }

        if (count($languages) != 0) {
            return response()->json(['data' => $language, 'status' => true, 'message' => "Language List Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Language Not Found"]);
        }
    }

    public function SetUserLanguage(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        User::where('id', $user_id)->update(['user_language' => $request->language]);

        if (!empty($request->language)) {
            return response()->json(['status' => true, 'message' => "Language Set Successfully"]);
        } else {
            return response()->json(['status' => false, 'message' => "Something Went Wrong. Language Not Set."]);
        }
    }

    // -------------------- Political Business

    public function getPoliticalCategory()
    {
        $cat_list = PoliticalCategory::where('pc_is_deleted', '=', 0)->get();

        foreach ($cat_list as &$cat) {
            if ($cat->pc_image != '') {
                $cat->pc_image = Storage::url($cat->pc_image);
            } else {
                $cat->pc_image = "https://digitalpost365.sgp1.digitaloceanspaces.com/public/images/7MO5rYc1618656161.jpg";
            }
        }

        if (!$cat_list) {
            return response()->json(['status' => false, 'message' => "Category not available"]);
        }

        return response()->json(['status' => true, 'message' => "Category list retrived Successfully", 'category_list' => $cat_list]);
    }

    public function addPoliticalBusiness(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $name = $input['name'];
        $designation = isset($input['designation']) ? $input['designation'] : "";
        $mobile = isset($input['mobile']) ? $input['mobile'] : "";
        $pb_mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $hashtag = (isset($input['hashtag'])) ? $input['hashtag'] : '';
        $party_id = $input['party_id'];


        $logo = $request->file('party_logo');
        $watermark = $request->file('watermark');
        $logo_dark = $request->file('party_logo_dark');
        $watermark_dark = $request->file('watermark_dark');
        $left_image = $request->file('left_image');
        $right_image = $request->file('right_image');

        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $twitter =  isset($input['twitter']) ? $input['twitter'] : "";
        $instagram =  isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin =  isset($input['linkedin']) ? $input['linkedin'] : "";
        $youtube =  isset($input['youtube']) ? $input['youtube'] : "";

        $logo_path = '';
        $watermark_path = '';
        $logo_path_dark = '';
        $watermark_path_dark = '';
        $left_image_path = '';
        $right_image_path = '';

        if ($watermark != null) {
            $watermark_path  =  $this->uploadFile($request, null, "watermark", 'political-business-img');
        }

        if ($logo != null) {
            $logo_path  =  $this->uploadFile($request, null, "party_logo", 'political-business-img');
        }

        if ($watermark_dark != null) {
            $watermark_path_dark  =  $this->uploadFile($request, null, "watermark_dark", 'political-business-img');
        }

        if ($logo_dark != null) {
            $logo_path_dark  =  $this->uploadFile($request, null, "party_logo_dark", 'political-business-img');
        }

        if ($left_image != null) {
            $left_image_path  =  $this->uploadFile($request, null, "left_image", 'political-business-img');
        }

        if ($right_image != null) {
            $right_image_path  =  $this->uploadFile($request, null, "right_image", 'political-business-img');
        }


        $business = new PoliticalBusiness();
        $business->pb_name = $name;
        $business->user_id = $user_id;
        $business->pb_designation = $designation;
        $business->pb_mobile = $mobile;
        $business->pb_mobile_second = $pb_mobile_second;
        $business->pb_pc_id = $party_id;
        $business->pb_party_logo = $logo_path;
        $business->pb_watermark = $watermark_path;
        $business->pb_party_logo_dark = $logo_path_dark;
        $business->pb_watermark_dark = $watermark_path_dark;
        $business->pb_left_image = $left_image_path;
        $business->pb_right_image = $right_image_path;
        $business->hashtag = $hashtag;
        $business->pb_facebook = $facebook;
        $business->pb_twitter = $twitter;
        $business->pb_instagram = $instagram;
        $business->pb_linkedin = $linkedin;
        $business->pb_youtube = $youtube;
        $business->save();

        $business_id = $business->pb_id;

        $start_date = date('Y-m-d');

        $purchase = new Purchase();
        $purchase->purc_user_id = $user_id;
        $purchase->purc_business_id = $business_id;
        $purchase->purc_plan_id = 3;
        $purchase->purc_start_date = $start_date;
        $purchase->purc_business_type = 2;
        $purchase->save();


        $userdata = User::where('id', '=', $user_id)->select('default_political_business_id')->first();

        if ($userdata->default_political_business_id == 0 || $userdata->default_political_business_id == '') {
            User::where('id', $user_id)->update(array(
                'default_political_business_id' => $business_id,
            ));
        } else {
            $checkOldBusines = PoliticalBusiness::where('user_id', $user_id)->where('pb_id', $userdata->default_political_business_id)->where('pb_is_deleted', 1)->first();
            if (!empty($checkOldBusines)) {
                User::where('id', $user_id)->update(array(
                    'default_political_business_id' => $business_id,
                ));
            }
        }


        $partyLogoBackgroundRemove = isset($input['partyLogoBackgroundRemove']) ? $input['partyLogoBackgroundRemove'] : 0;
        $watermarkBackgroundRemove = isset($input['watermarkBackgroundRemove']) ? $input['watermarkBackgroundRemove'] : 0;
        $partyLogoDarkBackgroundRemove = isset($input['partyLogoDarkBackgroundRemove']) ? $input['partyLogoDarkBackgroundRemove'] : 0;
        $watermarkDarkBackgroundRemove = isset($input['watermarkDarkBackgroundRemove']) ? $input['watermarkDarkBackgroundRemove'] : 0;
        $leftImageBackgroundRemove = isset($input['leftImageBackgroundRemove']) ? $input['leftImageBackgroundRemove'] : 0;
        $rightImageBackgroundRemove = isset($input['rightImageBackgroundRemove']) ? $input['rightImageBackgroundRemove'] : 0;

        $backgroundRemoveRequest = BackgroundRemoveRequest::where('business_type', 2)->where('business_id', $business_id)->first();

        if(
            $partyLogoBackgroundRemove == 0 &&
            $watermarkBackgroundRemove == 0 &&
            $leftImageBackgroundRemove == 0 &&
            $rightImageBackgroundRemove == 0 &&
            $partyLogoDarkBackgroundRemove == 0 &&
            $watermarkDarkBackgroundRemove == 0
        ){
            if(!empty($backgroundRemoveRequest)) {
                $backgroundRemoveRequest->delete();
            }
        }
        else {
            if(empty($backgroundRemoveRequest)) {
                $backgroundRemoveRequest = new BackgroundRemoveRequest;
                $backgroundRemoveRequest->user_id = $user_id;
                $backgroundRemoveRequest->business_type = 2;
                $backgroundRemoveRequest->business_id = $business_id;
            }
            $backgroundRemoveRequest->remove_logo = $partyLogoBackgroundRemove;
            $backgroundRemoveRequest->remove_watermark = $watermarkBackgroundRemove;
            $backgroundRemoveRequest->remove_logo_dark = $partyLogoDarkBackgroundRemove;
            $backgroundRemoveRequest->remove_watermark_dark = $watermarkDarkBackgroundRemove;
            $backgroundRemoveRequest->remove_left_image = $leftImageBackgroundRemove;
            $backgroundRemoveRequest->remove_right_image = $rightImageBackgroundRemove;
            $backgroundRemoveRequest->save();
        }

        return response()->json(['status' => true, 'message' => 'Data successfully Added']);
    }

    public function updatePoliticalbusiness(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $getBusiness = PoliticalBusiness::where('pb_id', '=', $input['id'])->where('user_id', $user_id)->first();
        if (empty($getBusiness)) {
            return response()->json(['status' => false, 'message' => 'Something goes wrong']);
        }

        $business_id = $input['id'];

        $name = $input['name'];
        $designation = isset($input['designation']) ? $input['designation'] : '';
        $mobile = isset($input['mobile']) ? $input['mobile'] : '';
        $pb_mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $hashtag = (isset($input['hashtag'])) ? $input['hashtag'] : '';
        $party_id = $input['party_id'];

        $logo = $request->file('party_logo');
        $watermark = $request->file('watermark');
        $logo_dark = $request->file('party_logo_dark');
        $watermark_dark = $request->file('watermark_dark');
        $left_image = $request->file('left_image');
        $right_image = $request->file('right_image');

        $facebook = $input['facebook'];
        $twitter = $input['twitter'];
        $instagram = $input['instagram'];
        $linkedin = $input['linkedin'];
        $youtube = $input['youtube'];

        $logo_path = '';
        $watermark_path = '';
        $logo_path_dark = '';
        $watermark_path_dark = '';
        $left_image_path = '';
        $right_image_path = '';

        if ($watermark != null) {
            $watermark_path  =  $this->uploadFile($request, null, "watermark", 'political-business-img');
        } else {
            $watermark_path = $getBusiness->pb_watermark;
        }

        if ($logo != null) {
            $logo_path  =  $this->uploadFile($request, null, "party_logo", 'political-business-img');
        } else {
            $logo_path = $getBusiness->pb_party_logo;
        }

        if ($watermark_dark != null) {
            $watermark_path_dark  =  $this->uploadFile($request, null, "watermark_dark", 'political-business-img');
        } else {
            $watermark_path_dark = $getBusiness->pb_watermark_dark;
        }

        if ($logo_dark != null) {
            $logo_path_dark  =  $this->uploadFile($request, null, "party_logo_dark", 'political-business-img');
        } else {
            $logo_path_dark = $getBusiness->pb_party_logo_dark;
        }

        if ($left_image != null) {
            $left_image_path  =  $this->uploadFile($request, null, "left_image", 'political-business-img');
        } else {
            $left_image_path = $getBusiness->pb_left_image;
        }

        if ($right_image != null) {
            $right_image_path  =  $this->uploadFile($request, null, "right_image", 'political-business-img');
        } else {
            $right_image_path = $getBusiness->pb_right_image;
        }

        $_isPremiumUser = DB::table('purchase_plan')->where('purc_business_type', 2)->where('purc_business_id', '=', $business_id)->where('purc_plan_id', '!=', 3)->first();

        if (!empty($_isPremiumUser) || $_isPremiumUser != '' || $_isPremiumUser != null) {

            if ($name != $getBusiness->pb_name) {

                PoliticalBusinessApprovalList::updateOrCreate(
                    ['pb_id' => $business_id],
                    [
                        'pbal_name' => $name,
                        'user_id' => $user_id,
                        'pbal_designation' => $designation,
                        'pbal_mobile' => $mobile,
                        'pbal_pc_id' => $party_id,
                        'pbal_party_logo' => $logo_path,
                        'pbal_watermark' => $watermark_path,
                        'pbal_left_image' => $left_image_path,
                        'pbal_right_image' => $right_image_path,
                        'pbal_facebook' => $facebook,
                        'pbal_twitter' => $twitter,
                        'pbal_instagram' => $instagram,
                        'pbal_linkedin' => $linkedin,
                        'pbal_youtube' => $youtube
                    ]
                );
            }


            PoliticalBusiness::where('pb_id', '=', $business_id)->update([
                'user_id' => $user_id,
                'pb_designation' => $designation,
                'pb_mobile' => $mobile,
                'pb_mobile_second' => $pb_mobile_second,
                'pb_pc_id' => $party_id,
                'pb_party_logo' => $logo_path,
                'pb_watermark' => $watermark_path,
                'pb_party_logo_dark' => $logo_path_dark,
                'pb_watermark_dark' => $watermark_path_dark,
                'pb_left_image' => $left_image_path,
                'pb_right_image' => $right_image_path,
                'hashtag' => $hashtag,
                'pb_facebook' => $facebook,
                'pb_twitter' => $twitter,
                'pb_instagram' => $instagram,
                'pb_linkedin' => $linkedin,
                'pb_youtube' => $youtube,
            ]);
            if ($right_image != null || $left_image != null || $logo != null || $name != $getBusiness->pb_name) {
                $message = 'Please wait till admin approves your changes!';
            } else {
                $message = 'Business information update';
            }
        } else {
            PoliticalBusiness::where('pb_id', '=', $business_id)->update([
                'pb_name' => $name,
                'user_id' => $user_id,
                'pb_designation' => $designation,
                'pb_mobile' => $mobile,
                'pb_mobile_second' => $pb_mobile_second,
                'pb_pc_id' => $party_id,
                'pb_party_logo' => $logo_path,
                'pb_watermark' => $watermark_path,
                'pb_party_logo_dark' => $logo_path_dark,
                'pb_watermark_dark' => $watermark_path_dark,
                'pb_left_image' => $left_image_path,
                'pb_right_image' => $right_image_path,
                'hashtag' => $hashtag,
                'pb_facebook' => $facebook,
                'pb_twitter' => $twitter,
                'pb_instagram' => $instagram,
                'pb_linkedin' => $linkedin,
                'pb_youtube' => $youtube,
            ]);

            $message = 'Business information update';
        }

        $partyLogoBackgroundRemove = isset($input['partyLogoBackgroundRemove']) ? $input['partyLogoBackgroundRemove'] : 0;
        $watermarkBackgroundRemove = isset($input['watermarkBackgroundRemove']) ? $input['watermarkBackgroundRemove'] : 0;
        $partyLogoDarkBackgroundRemove = isset($input['partyLogoDarkBackgroundRemove']) ? $input['partyLogoDarkBackgroundRemove'] : 0;
        $watermarkDarkBackgroundRemove = isset($input['watermarkDarkBackgroundRemove']) ? $input['watermarkDarkBackgroundRemove'] : 0;
        $leftImageBackgroundRemove = isset($input['leftImageBackgroundRemove']) ? $input['leftImageBackgroundRemove'] : 0;
        $rightImageBackgroundRemove = isset($input['rightImageBackgroundRemove']) ? $input['rightImageBackgroundRemove'] : 0;

        $backgroundRemoveRequest = BackgroundRemoveRequest::where('business_type', 2)->where('business_id', $business_id)->first();

        if(
            $partyLogoBackgroundRemove == 0 &&
            $watermarkBackgroundRemove == 0 &&
            $leftImageBackgroundRemove == 0 &&
            $rightImageBackgroundRemove == 0 &&
            $partyLogoDarkBackgroundRemove == 0 &&
            $watermarkDarkBackgroundRemove == 0
        ){
            if(!empty($backgroundRemoveRequest)) {
                $backgroundRemoveRequest->delete();
            }
        }
        else {
            if(empty($backgroundRemoveRequest)) {
                $backgroundRemoveRequest = new BackgroundRemoveRequest;
                $backgroundRemoveRequest->user_id = $user_id;
                $backgroundRemoveRequest->business_type = 2;
                $backgroundRemoveRequest->business_id = $business_id;
            }
            $backgroundRemoveRequest->remove_logo = $partyLogoBackgroundRemove;
            $backgroundRemoveRequest->remove_watermark = $watermarkBackgroundRemove;
            $backgroundRemoveRequest->remove_logo_dark = $partyLogoDarkBackgroundRemove;
            $backgroundRemoveRequest->remove_watermark_dark = $watermarkDarkBackgroundRemove;
            $backgroundRemoveRequest->remove_left_image = $leftImageBackgroundRemove;
            $backgroundRemoveRequest->remove_right_image = $rightImageBackgroundRemove;
            $backgroundRemoveRequest->save();
        }

        return response()->json(['status' => true, 'message' => $message]);
    }

    public function getmyAllPoliticalBusinessList(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $businessList = DB::table('political_business')->leftJoin('political_category', 'political_category.pc_id', '=', 'political_business.pb_pc_id')->leftJoin('purchase_plan', 'purchase_plan.purc_business_id', '=', 'political_business.pb_id')->leftJoin('plan', 'plan.plan_id', '=', 'purchase_plan.purc_plan_id')->where('user_id', '=', $user_id)->where('pb_is_deleted', '=', 0)->where('purchase_plan.purc_business_type', '=', 2)->get();

        $defaultBusinessId = User::where('id', '=', $user_id)->select('default_political_business_id')->first();


        foreach ($businessList as &$business) {
            $business->pb_party_logo = ($business->pb_party_logo) ? Storage::url($business->pb_party_logo) : '';
            $business->pb_watermark = ($business->pb_watermark) ? Storage::url($business->pb_watermark) : '';
            $business->pb_party_logo_dark = ($business->pb_party_logo_dark) ? Storage::url($business->pb_party_logo_dark) : '';
            $business->pb_watermark_dark = ($business->pb_watermark_dark) ? Storage::url($business->pb_watermark_dark) : '';
            $business->pb_left_image = ($business->pb_left_image) ? Storage::url($business->pb_left_image) : '';
            $business->pb_right_image = ($business->pb_right_image) ? Storage::url($business->pb_right_image) : '';
            if ($defaultBusinessId->default_political_business_id == $business->pb_id) {
                $business->is_Default = 'yes';
            } else {
                $business->is_Default = 'no';
            }
            $business->purc_order_id = ($business->purc_order_id) ? $business->purc_order_id : '';
            $business->purc_end_date = ($business->purc_end_date) ? $business->purc_end_date : '';
            $business->device = ($business->device) ? $business->device : '';

            $business->plan_information = ($business->plan_information) ? unserialize($business->plan_information) : '';

            if ($business->purc_plan_id != 3) {
                $start_date = strtotime($business->purc_start_date);
                $end_date = strtotime($business->purc_end_date);
                $business->remaining_days = '0 Days';
                $today = strtotime(date('Y-m-d'));
                if ($today > $end_date && ($business->purc_is_expire == 1 || $business->purc_is_expire == "1")) {
                    $business->remaining_days = '0 Days';
                } else {
                    $days = ($end_date - $today) / 60 / 60 / 24;
                    $business->remaining_days = $days . ' Days';
                }
            } else {
                $business->remaining_days = '0 Days';
            }
        }

        if (!$businessList) {
            return response()->json(['status' => false, 'message' => "Business not available"]);
        }

        return response()->json(['status' => true, 'message' => "business list retrived Successfully", 'business_list' => $businessList]);
    }

    public function removePoliticalBusiness(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if (!isset($input['id']) || $input['id'] == '') {
            return response()->json(['status' => false, 'message' => 'post you are looking for is not availabe']);
        }

        $getbusiness = DB::table('political_business')->select('pb_party_logo', 'pb_watermark', 'pb_left_image', 'pb_right_image')->where('pb_id', '=', $input['id'])->where('user_id', $user_id)->first();
        $user_data = User::find($user_id);
        if (empty($getbusiness)) {
            return response()->json(['status' => false, 'message' => 'Something goes wrong']);
        }
        if ($getbusiness) {
            DB::table('political_business')->where('pb_id', $input['id'])->update(['pb_is_deleted' => 1]);
            $getbusiness_approve = DB::table('political_business_approval_list')->select('pbal_party_logo', 'pbal_watermark', 'pbal_left_image', 'pbal_right_image')->where('pb_id', '=', $input['id'])->first();
            if ($getbusiness_approve) {
                DB::table('political_business_approval_list')->where('pb_id', $input['id'])->update(['pbal_is_deleted' => 1]);
            }
        }
        if ($user_data->default_political_business_id == $input['id']) {
            $currntbusiness = PoliticalBusiness::where('user_id','=',$user_id)->where('pb_is_deleted','=',0)->select('pb_id')->first();

            if(!empty($currntbusiness) || !is_null($currntbusiness)){
                User::where('id', $user_id)->update(array(
                    'default_political_business_id' => $currntbusiness->pb_id,
                ));
            } else {
                User::where('id', $user_id)->update(array(
                    'default_political_business_id' => 0,
                ));
            }
        }

        return response()->json(['status' => true, 'message' => "Business successfully removed"]);
    }

    public function markCurrentBusinessForPolitic(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $business_id = $input['business_id'];

        User::where('id', $user_id)->update(array(
            'default_political_business_id' => $business_id,
        ));
        $user_data = User::find($user_id);
        $frameList = DB::table('user_frames')->where('user_id', '=', $user_id)->where('business_id', '=', $user_data->default_business_id)->where('is_deleted', '=', 0)->where('business_type', '=', 2)->orderBy('user_frames_id', 'DESC')->get();

        $frameLists = array();

        if (!empty($frameList)) {
            foreach ($frameList as $key => $value) {
                $data = array();

                $data['business_id'] = strval($value->business_id);
                $data['date_added'] = !empty($value->date_added) ? $value->date_added : "";
                $data['frame_url'] = !empty($value->frame_url) ? Storage::url($value->frame_url) : "";
                $data['user_frames_id'] = strval($value->user_frames_id);
                $data['user_id'] = strval($value->user_id);

                array_push($frameLists, $data);
            }
        }


        $updatedCurrentBusinessDetails = $this->getPoliticalCurrentBusiness($user_data->default_political_business_id, $user_id);
        $retrunData = (object)[];
        if ($updatedCurrentBusinessDetails[0]) {
            $retrunData = $updatedCurrentBusinessDetails[0];
        }

        return response()->json(['status' => true, 'message' => 'Set successfuly', 'frameList' => $frameLists, 'current_business' => $retrunData]);
    }

    function getPoliticalCurrentBusiness($political_business_id, $user_id)
    {
        $currntbusiness = PoliticalBusiness::where('pb_id', '=', $political_business_id)->where('pb_is_deleted', '=', 0)->first();
        $updatedCurrentBusinessDetails = array();

        $ispreminum = false;
        if ($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != '') {
            $priminum = Purchase::where('purc_business_id', '=', $political_business_id)->where('purc_business_type', '=', 2)->select('purc_id', 'purc_plan_id', 'purc_start_date', 'purc_end_date')->first();

            if (!empty($priminum) || $priminum != null || $priminum != '') {
                $start_dates = date('Y-m-d');
                if ($priminum->purc_plan_id != 3) {
                    $plantrial = Plan::where('plan_id', '=', $priminum->purc_plan_id)->select('plan_validity')->first();
                    $start_date = strtotime($start_dates);
                    $end_date = strtotime($priminum->end_date);
                    $days = ($end_date - $start_date) / 60 / 60 / 24;
                    if ($days > $plantrial->plan_validity && $days > 0) {
                        $ispreminum = false;
                    } else {
                        $ispreminum = true;
                    }
                } else {
                    $ispreminum = false;
                }
            } else {
                $ispreminum = false;
            }


            $updatedCurrentBusinessDetails['pb_id'] = strval($currntbusiness->pb_id);
            $updatedCurrentBusinessDetails['user_id'] = strval($currntbusiness->user_id);
            $updatedCurrentBusinessDetails['pb_name'] = !empty($currntbusiness->pb_name) ? $currntbusiness->pb_name : "";
            $updatedCurrentBusinessDetails['pb_mobile'] = !empty($currntbusiness->pb_mobile) ? $currntbusiness->pb_mobile : "";
            $updatedCurrentBusinessDetails['pb_mobile_second'] = !empty($currntbusiness->pb_mobile_second) ? $currntbusiness->pb_mobile_second : "";
            $updatedCurrentBusinessDetails['pb_designation'] = !empty($currntbusiness->pb_designation) ? $currntbusiness->pb_designation : "";
            $updatedCurrentBusinessDetails['pb_party_logo'] = !empty($currntbusiness->pb_party_logo) ? Storage::url($currntbusiness->pb_party_logo) : "";
            $updatedCurrentBusinessDetails['pb_watermark'] = !empty($currntbusiness->pb_watermark) ? Storage::url($currntbusiness->pb_watermark) : "";
            $updatedCurrentBusinessDetails['pb_party_logo_dark'] = !empty($currntbusiness->pb_party_logo_dark) ? Storage::url($currntbusiness->pb_party_logo_dark) : "";
            $updatedCurrentBusinessDetails['pb_watermark_dark'] = !empty($currntbusiness->pb_watermark_dark) ? Storage::url($currntbusiness->pb_watermark_dark) : "";
            $updatedCurrentBusinessDetails['pb_left_image'] = !empty($currntbusiness->pb_left_image) ? Storage::url($currntbusiness->pb_left_image) : "";
            $updatedCurrentBusinessDetails['pb_right_image'] = !empty($currntbusiness->pb_right_image) ? Storage::url($currntbusiness->pb_right_image) : "";

            $updatedCurrentBusinessDetails['pb_facebook'] = !empty($currntbusiness->pb_facebook) ? $currntbusiness->pb_facebook : "";
            $updatedCurrentBusinessDetails['pb_twitter'] = !empty($currntbusiness->pb_twitter) ? $currntbusiness->pb_twitter : "";
            $updatedCurrentBusinessDetails['pb_instagram'] = !empty($currntbusiness->pb_instagram) ? $currntbusiness->pb_instagram : "";
            $updatedCurrentBusinessDetails['pb_linkedin'] = !empty($currntbusiness->pb_linkedin) ? $currntbusiness->pb_linkedin : "";
            $updatedCurrentBusinessDetails['pb_youtube'] = !empty($currntbusiness->pb_youtube) ? $currntbusiness->pb_youtube : "";
            $updatedCurrentBusinessDetails['pb_is_approved'] = strval($currntbusiness->pb_is_approved);
            $updatedCurrentBusinessDetails['pb_is_deleted'] = strval($currntbusiness->pb_is_deleted);

            $p_plan = Purchase::where('purc_user_id', $user_id)->where('purc_business_id', $political_business_id)->where('purc_business_type', '=', 2)->get();
            $plan_name = "";
            if (count($p_plan) != 0) {
                foreach ($p_plan as $key => $value) {
                    if ($value->purc_is_cencal == 0 && $value->purc_is_expire == 0) {

                        if ($value->purc_plan_id != 3) {
                            $plan_name = 'Premium';
                            $updatedCurrentBusinessDetails['status'] = 1;
                        } elseif ($value->purc_plan_id == 3) {
                            $plan_name = 'Free';
                            $updatedCurrentBusinessDetails['status'] = 0;
                        }
                    } else {
                        $plan_name = 'Free';
                        $updatedCurrentBusinessDetails['status'] = 0;
                    }
                }
            } else {
                $plan_name = 'Free';
                $updatedCurrentBusinessDetails['status'] = 0;
            }

            $updatedCurrentBusinessDetails['plan_name'] = $plan_name;
            $cur_status = 1;
            $updatedCurrentBusinessDetails['status'] = strval($cur_status);
        } else {
            $currntbusiness = "you havent't set current business yet";
        }
        $array = array();
        array_push($array, $updatedCurrentBusinessDetails);
        array_push($array, $ispreminum);

        return $array;
    }

    public function GetAllBusinessCategory(Request $request)
    {
        $category_data = DB::table('business_category')->where('is_delete', '=', 0)->get();

        $category = array();

        $keyval = 0;
        foreach ($category_data as $key => $value) {
            $data = array();
            $data['id'] = strval($value->id);
            $data['category_name'] = !empty($value->name) ? $value->name : "";
            $data['image'] = !empty($value->image) ? Storage::url($value->image) : "";
            array_push($category, $data);
        }

        return response()->json(['business_category' => $category]);
    }

    public function sendOTP($country_code, $mobile, $otp)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://2factor.in/API/V1/5ac4e318-8b73-11ea-9fa5-0200cd936042/SMS/' . $country_code . $mobile . '/' . $otp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = json_decode(curl_exec($ch), true);

        curl_close($ch);
        if ($server_output['Status'] == "Success") {
            return true;
        }
        return false;
    }

    public function getStickerCategory(Request $request)
    {
        $categories = StickerCategory::select('id', 'name')->whereNotNull('order_number')->orderBy('order_number', "ASC")->where('is_delete', 0)->get()->toArray();
        $categories1 = StickerCategory::select('id', 'name')->whereNull('order_number')->where('is_delete', 0)->get()->toArray();
        $data = array_merge($categories, $categories1);
        return response()->json(['status' => true, 'data' => $data, 'message' => "Sticker Category fetched successfully"]);
    }

    public function getBackgroundCategory(Request $request)
    {
        $categories = BackgroundCategory::select('id', 'name')->whereNotNull('order_number')->orderBy('order_number', "ASC")->where('is_delete', 0)->get()->toArray();
        $categories1 = BackgroundCategory::select('id', 'name')->whereNull('order_number')->where('is_delete', 0)->get()->toArray();
        $data = array_merge($categories, $categories1);
        return response()->json(['status' => true, 'data' => $data, 'message' => "Background Category fetched successfully"]);
    }

    public function getSticker(Request $request)
    {
        $stickers = StickerCategory::where('is_delete', 0)->whereNotNull('order_number')->orderBy('order_number', "ASC")->with(['stickers' => function ($q) {
            $q->orderBy('id', "DESC");
        }])->whereHas('stickers')->get();
        foreach ($stickers as $sticker) {
            foreach ($sticker->stickers as $stic) {
                $stic->image = Storage::url($stic->image);
            }
        }
        $stickers1 = StickerCategory::where('is_delete', 0)->whereNull('order_number')->with(['stickers' => function ($q) {
            $q->orderBy('id', "DESC");
        }])->whereHas('stickers')->get();
        foreach ($stickers1 as $sticker1) {
            foreach ($sticker1->stickers as $stic) {
                $stic->image = Storage::url($stic->image);
            }
        }
        $data = array_merge($stickers->toArray(), $stickers1->toArray());
        return response()->json(['status' => true, 'data' => $data, 'message' => "Stickers fetched successfully"]);
    }

    public function getBackground(Request $request)
    {
        $backgrounds = BackgroundCategory::where('is_delete', 0)->whereNotNull('order_number')->orderBy('order_number', "ASC")->with(['backgrounds' => function ($q) {
            $q->orderBy('id', "DESC");
        }])->whereHas('backgrounds')->get();
        foreach ($backgrounds as $background) {
            foreach ($background->backgrounds as $back) {
                $back->thumbnail_image = Storage::url($back->thumbnail_image);
                $back->image = Storage::url($back->image);
            }
        }
        $backgrounds1 = BackgroundCategory::where('is_delete', 0)->whereNull('order_number')->with(['backgrounds' => function ($q) {
            $q->orderBy('id', "DESC");
        }])->whereHas('backgrounds')->get();
        foreach ($backgrounds1 as $background1) {
            foreach ($background1->backgrounds as $back1) {
                $back1->thumbnail_image = Storage::url($back1->thumbnail_image);
                $back1->image = Storage::url($back1->image);
            }
        }
        $data = array_merge($backgrounds->toArray(), $backgrounds1->toArray());
        return response()->json(['status' => true, 'data' => $data, 'message' => "Backgrounds fetched successfully"]);
    }

    public function getGraphic(Request $request)
    {

        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $graphics = GraphicCategory::where('is_delete', 0)->whereNotNull('order_number')->orderBy('order_number', "ASC")->with(['graphics' => function ($q) {
            $q->orderBy('id', "DESC");
        }])->whereHas('graphics')->get();

        foreach ($graphics as $background) {
            foreach ($background->graphics as $back) {
                $back->thumbnail_image = Storage::url($back->thumbnail_image);
                $back->image = Storage::url($back->image);
            }
        }
        $graphics1 = GraphicCategory::where('is_delete', 0)->whereNull('order_number')->with(['graphics' => function ($q) {
            $q->orderBy('id', "DESC");
        }])->whereHas('graphics')->get();
        foreach ($graphics1 as $background1) {
            foreach ($background1->graphics as $back1) {
                $back1->thumbnail_image = Storage::url($back1->thumbnail_image);
                $back1->image = Storage::url($back1->image);
            }
        }
        $data = array_merge($graphics->toArray(), $graphics1->toArray());
        return response()->json(['status' => true, 'data' => $data, 'message' => "graphics fetched successfully"]);
    }

    // -------------------- Social Media API Start

    public function getInstagramAccount(Request $request)
    {
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $profile = Helper::getFacebookProfile($request->auth_token);
        $profile_id = $profile['id'];
        $pages = Helper::getUserFacebookPages($request->auth_token);
        $pagesData = array();
        foreach ($pages->data as $key => $page) {
            $insta_info = $this->facebook->getInstaBusinessAccountId($page->id, $page->access_token);
            if (isset($insta_info['instagram_business_account'])) {
                $insta_id = $insta_info['instagram_business_account']['id'];
                $endpoint = $insta_id . '?fields=biography%2Cid%2Cusername%2Cwebsite%2Cprofile_picture_url';
                $get_post_status = $this->facebook->InstaGetData($request->auth_token, $endpoint);
                $get_post_status['profile_id'] = $profile_id;
                $get_post_status['access_token'] = $page->access_token;
                array_push($pagesData, $get_post_status);
            }
        }
        $accounts = SocialLogin::where('user_id', $user_id)->where('type', 'instagram')->get();
        if (count($pagesData) === 0) {
            return response()->json(['status' => false, 'message' => 'Instagram Page List Not Found', 'data' => $pagesData, 'access_token' => $request->auth_token, 'linkedAccounts' => $accounts]);
        } else {
            return response()->json(['status' => true, 'message' => 'Page List', 'data' => $pagesData, 'access_token' => $request->auth_token, 'linkedAccounts' => $accounts]);
        }
    }

    public function SocialLogins(Request $request)
    {

        $default_profile_photo = url('public/images/default-profile.jpg');
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $profile_id = "";
        $profile_urn = "";
        $profile_name = "";
        $profile_photo = "";
        $auth_token = "";
        $access_token_twitter = "";
        $access_token_secret_twitter = "";
        if ($request->type == 'twitter') {
            $access_token_twitter = $request->access_token_twitter;
            $access_token_secret_twitter = $request->access_token_secret_twitter;
            $profile = Twitter::getProfile($access_token_twitter, $access_token_secret_twitter);
            $profile_photo = isset($profile->profile_image_url_https) ? $profile->profile_image_url_https : $default_profile_photo;
            $profile_name = $profile->name;
            $profile_id = $profile->id;
        } elseif ($request->type == "linkedin") {
            $auth_token = $request->auth_token;
            $profile = LinkedIn::getProfile($auth_token);
            $profile_photo = isset($profile['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]['identifier']) ? $profile['profilePicture']['displayImage~']['elements'][0]['identifiers'][0]['identifier'] : $default_profile_photo;
            $profile_name = $profile['localizedFirstName'] . $profile['localizedLastName'];
            $profile_id = $profile['id'];
            $profile_urn = 'urn:li:person:' . $profile_id;
        } elseif ($request->type == "facebook") {
            $auth_token = $request->auth_token;
            $profile = Helper::getFacebookProfile($auth_token);
            $profile_photo = $profile['picture']['url'];
            $profile_name = $profile['name'];
            $profile_id = $profile['id'];
        }
        if ($request->type == "instagram") {
            $ids = explode(',', $request->instagram_ids);
            foreach ($ids as $key => $insta_id) {
                $endpoint = $insta_id . '?fields=biography%2Cid%2Cusername%2Cwebsite%2Cprofile_picture_url';
                $get_post_status = $this->facebook->InstaGetData($request->auth_token, $endpoint);
                $get_post_status['profile_id'] = $profile_id;
                $get_post_status['access_token'] = $request->auth_token;


                $socialLogin = SocialLogin::where('user_id', $user_id)->where('type', $request->type)->where('profile_id', $insta_id)->first();
                if (empty($socialLogin)) {
                    $socialLogin = new SocialLogin;
                }
                $socialLogin->profile_added = 1;
                $socialLogin->user_id = $user_id;
                $socialLogin->type = $request->type;
                $socialLogin->profile_id = $insta_id;
                $socialLogin->profile_urn = "";
                $socialLogin->profile_name = $get_post_status['username'];
                $socialLogin->profile_photo = $get_post_status['profile_picture_url'];
                $socialLogin->access_token_twitter = "";
                $socialLogin->access_token_secret_twitter = "";
                $socialLogin->auth_token = $request->auth_token;
                $socialLogin->save();
            }
            return response()->json(['status' => true, 'message' => 'Acount added successfully']);
        } else {
            $socialLogin = SocialLogin::where('user_id', $user_id)->where('type', $request->type)->where('profile_id', $profile_id)->first();
            if (empty($socialLogin)) {
                $socialLogin = new SocialLogin;
                if ($request->login_for == "profile") {
                    $socialLogin->profile_added = 1;
                }
            } else {
                if ($socialLogin->profile_added == 0) {
                    if ($request->login_for == "profile") {
                        $socialLogin->profile_added = 1;
                    }
                }
            }
            $socialLogin->user_id = $user_id;
            $socialLogin->type = $request->type;
            $socialLogin->profile_id = $profile_id;
            $socialLogin->profile_urn = $profile_urn;
            $socialLogin->profile_name = $profile_name;
            $socialLogin->profile_photo = $profile_photo;
            $socialLogin->access_token_twitter = $access_token_twitter;
            $socialLogin->access_token_secret_twitter = $access_token_secret_twitter;
            $socialLogin->auth_token = $auth_token;
            $socialLogin->save();
            if ($request->type == 'twitter') {
                SocialLogin::where('type', $request->type)->where('profile_id', $profile_id)->update(['access_token_twitter' => $access_token_twitter, 'access_token_secret_twitter' => $access_token_secret_twitter, 'profile_name' => $profile_name, 'profile_photo' => $profile_photo]);
            } else {
                SocialLogin::where('type', $request->type)->where('profile_id', $profile_id)->update(['auth_token' => $auth_token, 'profile_name' => $profile_name, 'profile_photo' => $profile_photo]);
            }

            if ($request->login_for == "page") {
                if ($request->type == "linkedin") {
                    $pages = LinkedIn::getUserPages($auth_token)['elements'];
                    $pageIds = array();
                    foreach ($pages as $key => $page) {
                        $id = explode(":", $page['organization']);
                        array_push($pageIds, $id[3]);
                    }
                    $pageLists = LinkedIn::getPageList($auth_token, $pageIds);

                    $pageData = array();
                    foreach ($pageIds as $id) {
                        $singlepageData = LinkedIn::getPage($auth_token, $id);

                        $data['page_id'] = strval($pageLists['results'][$id]['id']);
                        $data['page_name'] = $pageLists['results'][$id]['localizedName'];
                        $data['page_photo'] = isset($singlepageData['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier']) ? $singlepageData['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier'] : $default_profile_photo;

                        array_push($pageData, $data);
                    }
                    $linkedPages = LinkedInPage::where('user_id', $user_id)->where('profile_id', $profile_id)->pluck('page_id')->toArray();
                    $data = ['pageList' => $pageData, "linkedPages" => $linkedPages, 'profile_id' => $profile_id];
                    if (count($pageData) == 0) {
                        return response()->json(['status' => false, 'message' => 'No page found', 'data' => $data]);
                    }
                    return response()->json(['status' => true, 'message' => 'Page List', 'data' => $data, 'profile_id' => $profile_id]);
                }
                if ($request->type == "facebook") {
                    $pages = Helper::getUserFacebookPages($auth_token);
                    $pageData = $pages->data;
                    $pageList = array();
                    foreach ($pageData as $page) {
                        $page->image = "https://graph.facebook.com/" . $page->id . "/picture?type=large";
                        array_push($pageList, $page);
                    }
                    if (count($pageData) == 0) {
                        return response()->json(['status' => false, 'message' => 'No page found', 'data' => $pageList]);
                    }
                    $facebookPages = FacebookPage::where('user_id', $user_id)->where('profile_id', $profile_id)->pluck('page_id')->toArray();
                    $data = ['pageList' => $pageList, "facebookPages" => $facebookPages, 'profile_id' => $profile_id];
                    return response()->json(['status' => true, 'message' => 'Page List', 'data' => $data]);
                }
            }
            return response()->json(['status' => true, 'message' => 'Acount added successfully']);
        }
    }

    public function getSocialLoginPages(Request $request)
    {

        $default_profile_photo = url('public/images/default-profile.jpg');
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $type = $request->type;
        $profile_id = $request->profile_id;

        $profile = SocialLogin::where('user_id', $user_id)->where('type', $type)->where('profile_id', $profile_id)->first();

        if (empty($profile)) {
            return response()->json(['status' => false, 'message' => 'Account not found']);
        }

        $auth_token = $profile->auth_token;

        if ($type == "linkedin") {
            $pages = LinkedIn::getUserPages($auth_token)['elements'];
            $pageIds = array();
            foreach ($pages as $key => $page) {
                $id = explode(":", $page['organization']);
                array_push($pageIds, $id[3]);
            }
            $pageLists = LinkedIn::getPageList($auth_token, $pageIds);
            $pageData = array();
            foreach ($pageIds as $id) {
                $singlepageData = LinkedIn::getPage($auth_token, $id);

                $data['page_id'] = strval($pageLists['results'][$id]['id']);
                $data['page_name'] = $pageLists['results'][$id]['localizedName'];
                $data['page_photo'] = isset($singlepageData['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier']) ? $singlepageData['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier'] : $default_profile_photo;

                array_push($pageData, $data);
            }
            $linkedPages = LinkedInPage::where('user_id', $user_id)->where('profile_id', $profile_id)->pluck('page_id')->toArray();
            $data = ['pageList' => $pageData, "linkedPages" => $linkedPages, 'profile_id' => $profile_id];
            if (count($pageData) == 0) {
                return response()->json(['status' => false, 'message' => 'No page found', 'data' => $data]);
            }
            return response()->json(['status' => true, 'message' => 'Page List', 'data' => $data]);
        }
        if ($request->type == "facebook") {
            $pages = Helper::getUserFacebookPages($auth_token);
            $pageData = $pages->data;
            if (count($pageData) == 0) {
                return response()->json(['status' => false, 'message' => 'No page found', 'data' => $pageData]);
            }
            return response()->json(['status' => true, 'message' => 'Page List', 'data' => $pageData]);
        } else {
            return response()->json(['status' => false, 'message' => 'Something wrong']);
        }
    }

    public function SocialLoginsLinkedInPage(Request $request)
    {
        $default_profile_photo = url('public/images/default-profile.jpg');
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $profile_id = $request->profile_id;
        $pageIds = explode(',', $request->page_ids);

        $checkProfile = SocialLogin::where('user_id', $user_id)->where('type', "linkedin")->where('profile_id', $profile_id)->first();

        if (empty($checkProfile)) {
            return response()->json(['status' => false, 'message' => 'Profile not found']);
        }

        $auth_token = $checkProfile->auth_token;
        $pageLists = LinkedIn::getPageList($auth_token, $pageIds);
        if (count($pageLists['results']) != count($pageIds)) {
            return response()->json(['status' => false, 'message' => 'Invalid Page']);
        }
        $pageData = array();
        foreach ($pageIds as $id) {

            $singlepageData = LinkedIn::getPage($auth_token, $id);

            $page_id = $pageLists['results'][$id]['id'];
            $organization_id = 'urn:li:organization:' . $page_id;
            $page_name = $pageLists['results'][$id]['localizedName'];
            $page_photo = isset($singlepageData['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier']) ? $singlepageData['logoV2']['original~']['elements'][0]['identifiers'][0]['identifier'] : $default_profile_photo;
            $checkPage = LinkedInPage::where('user_id', $user_id)->where('profile_id', $profile_id)->where('page_id', $page_id)->first();
            if (empty($checkPage)) {
                $checkPage = new LinkedInPage;
                $checkPage->user_id = $user_id;
                $checkPage->profile_id = $profile_id;
                $checkPage->page_id = $page_id;
                $checkPage->organization_id = $organization_id;
            }
            $checkPage->page_name = $page_name;
            $checkPage->page_photo = $page_photo;
            $checkPage->save();

            $data['id'] = $page_id;
            $data['name'] = $page_name;
            array_push($pageData, $data);
        }
        return response()->json(['status' => true, 'message' => 'Page added successfully']);
    }

    public function SocialLoginsFacebookPage(Request $request)
    {
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $profile_id = $request->profile_id;
        $pageIds = explode(',', $request->page_ids);

        $checkProfile = SocialLogin::where('user_id', $user_id)->where('type', "facebook")->where('profile_id', $profile_id)->first();

        if (empty($checkProfile)) {
            return response()->json(['status' => false, 'message' => 'Profile not found']);
        }

        $auth_token = $checkProfile->auth_token;
        $pages = Helper::getUserFacebookPages($auth_token);
        $pageData = $pages->data;
        foreach ($pageData as $page) {
            if (in_array($page->id, $pageIds)) {
                $page_id = $page->id;
                $auth_token = $page->access_token;
                $page_name = $page->name;
                $page_photo = "https://graph.facebook.com/" . $page_id . "/picture?type=large";
                $checkPage = FacebookPage::where('user_id', $user_id)->where('profile_id', $profile_id)->where('page_id', $page_id)->first();
                if (empty($checkPage)) {
                    $checkPage = new FacebookPage;
                    $checkPage->user_id = $user_id;
                    $checkPage->profile_id = $profile_id;
                    $checkPage->page_id = $page_id;
                }
                $checkPage->auth_token = $auth_token;
                $checkPage->page_name = $page_name;
                $checkPage->page_photo = $page_photo;
                $checkPage->save();
            }
        }
        return response()->json(['status' => true, 'message' => 'Page added successfully']);
    }

    public function removeSocialProfile(Request $request)
    {
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $profile_type = $request->profile_type;
        $profile_id = $request->profile_id;
        $checkProfile = SocialLogin::where('type', $profile_type)->where('profile_id', $profile_id)->where('user_id', $user_id)->first();
        if (!empty($checkProfile)) {
            if ($profile_type == "linkedin") {
                $checkPages = LinkedInPage::where('user_id', $user_id)->where('profile_id', $profile_id)->first();
                if (empty($checkPages)) {
                    $checkProfile->delete();
                } else {
                    $checkProfile->profile_added = 0;
                    $checkProfile->save();
                }
            } else {
                $checkProfile->delete();
            }
            return response()->json(['status' => true, 'message' => 'Profile removed']);
        }
        return response()->json(['status' => false, 'message' => 'Profile not found']);
    }

    public function removeSocialPageLinkedIn(Request $request)
    {
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $page_id = $request->page_id;
        $checkPage = LinkedInPage::where('user_id', $user_id)->where('page_id', $page_id)->first();
        if (!empty($checkPage)) {
            $checkPage->delete();
            return response()->json(['status' => true, 'message' => 'Page removed']);
        }
        return response()->json(['status' => false, 'message' => 'Page not found']);
    }

    public function removeSocialPageFacebook(Request $request)
    {
        $user_id = $this->get_userid($request->token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $page_id = $request->page_id;
        $checkPage = FacebookPage::where('user_id', $user_id)->where('page_id', $page_id)->first();
        if (!empty($checkPage)) {
            $checkPage->delete();
            return response()->json(['status' => true, 'message' => 'Page removed']);
        }
        return response()->json(['status' => false, 'message' => 'Page not found']);
    }

    public function getLinkedAccounts(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $twitterProfiles = SocialLogin::where('user_id', $user_id)->where('type', 'twitter')->where('profile_added', 1)->get();
        $linkedInProfiles = SocialLogin::where('user_id', $user_id)->where('type', 'linkedin')->where('profile_added', 1)->get();
        $facebookProfiles = array();
        $instagramProfiles = SocialLogin::where('user_id', $user_id)->where('type', 'instagram')->where('profile_added', 1)->get();

        $linkedInPages = LinkedInPage::where('user_id', $user_id)->get();

        $facebookPages = FacebookPage::where('user_id', $user_id)->get();

        $data = ['twitterProfiles' => $twitterProfiles, 'linkedInProfiles' => $linkedInProfiles, 'facebookProfiles' => $facebookProfiles, 'instagramProfiles' => $instagramProfiles, 'linkedInPages' => $linkedInPages, 'facebookPages' => $facebookPages];

        return response()->json(['status' => true, 'message' => 'Social Account List', 'data' => $data]);
    }

    public function schedulePost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if ($input['date'] == '') {
            return response()->json(['status' => false, 'message' => 'date is missing']);
        }

        if ($input['time'] == '') {
            return response()->json(['status' => false, 'message' => 'time is missing']);
        }

        if (!$request->file("file")) {
            return response()->json(['status' => false, 'message' => 'file is missing']);
        }

        if ($input['media_type'] != 1 && $input['media_type'] != 2) {
            return response()->json(['status' => false, 'message' => 'media type is missing']);
        }

        $date = $input['date'];
        $time = $input['time'];
        $media_type = $input['media_type'];
        $caption = isset($input['caption']) ? $input['caption'] : "";
        $hashtag = isset($input['hashtag']) ? $input['hashtag'] : "";
        $twitter = isset($input['twitter']) ? $input['twitter'] : "";
        $linkedin = isset($input['linkedin']) ? $input['linkedin'] : "";
        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $instagram = isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin_page = isset($input['linkedin_page']) ? $input['linkedin_page'] : "";
        $facebook_page = isset($input['facebook_page']) ? $input['facebook_page'] : "";

        $twitter_list = array();
        $linkedin_list = array();
        $facebook_list = array();
        $instagram_list = array();
        $linkedin_page_list = array();
        $facebook_page_list = array();
        if ($twitter != "") {
            $twitter_list = explode(',', $twitter);
            foreach ($twitter_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'twitter')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($linkedin != "") {
            $linkedin_list = explode(',', $linkedin);
            foreach ($linkedin_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'linkedin')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($facebook != "") {
            $facebook_list = explode(',', $facebook);
            foreach ($facebook_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'facebook')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($instagram != "") {
            $instagram_list = explode(',', $instagram);
            foreach ($instagram_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'instagram')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($linkedin_page != "") {
            $linkedin_page_list = explode(',', $linkedin_page);
            foreach ($linkedin_page_list as $account) {
                $isLinked = LinkedInPage::where('user_id', $user_id)->where('page_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($facebook_page != "") {
            $facebook_page_list = explode(',', $facebook_page);
            foreach ($facebook_page_list as $account) {
                $isLinked = FacebookPage::where('user_id', $user_id)->where('page_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        $sp_media_type = 1;
        $sp_date = date('Y-m-d', strtotime($date));
        $sp_time = $time;
        $path = '';
        if ($media_type == 1) {
            $path  =  $this->uploadFile($request, null, "file", 'schedule-post-img');
            $sp_media_type = 1;
        } else {
            $path  =  $this->uploadFile($request, null, "file", 'schedule-post-video');
            $sp_media_type = 2;
        }

        $sp_date_time = Carbon::parse($sp_date . " " . $sp_time);

        $lastid = DB::table('schedule_post')->insertGetId([
            'sp_user_id' => $user_id,
            'sp_media_type' => $sp_media_type,
            'sp_media_path' => $path,
            'sp_date' => $sp_date,
            'sp_time' => $sp_time,
            'sp_caption' => $caption,
            'sp_hashtag' => $hashtag,
            'sp_date_time' => $sp_date_time,
            'sp_created_at' => date('Y-m-d H:i:s')
        ]);

        foreach ($twitter_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $lastid,
                'social_media_type' => 'twitter',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($linkedin_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $lastid,
                'social_media_type' => 'linkedin',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($facebook_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $lastid,
                'social_media_type' => 'facebook',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($instagram_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $lastid,
                'social_media_type' => 'instagram',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($linkedin_page_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $lastid,
                'social_media_type' => 'linkedin_page',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($facebook_page_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $lastid,
                'social_media_type' => 'facebook_page',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        return response()->json(['status' => true, 'message' => "Post Schedule added Successfully"]);
    }

    public function reSchedulePost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if (!isset($input['id']) || $input['id'] == '') {
            return response()->json(['status' => false, 'message' => 'post missing']);
        }

        $id = $input['id'];
        $checkPost = DB::table('schedule_post')->where('sp_id', $id)->where('sp_user_id', $user_id)->first();
        if (empty($checkPost)) {
            return response()->json(['status' => false, 'message' => 'post you are looking for is not availabe']);
        }

        if ($input['date'] == '') {
            return response()->json(['status' => false, 'message' => 'date is missing']);
        }

        if ($input['time'] == '') {
            return response()->json(['status' => false, 'message' => 'time is missing']);
        }
        $date = $input['date'];
        $time = $input['time'];
        $media_type = $input['media_type'];
        $caption = isset($input['caption']) ? $input['caption'] : "";
        $hashtag = isset($input['hashtag']) ? $input['hashtag'] : "";
        $twitter = isset($input['twitter']) ? $input['twitter'] : "";
        $linkedin = isset($input['linkedin']) ? $input['linkedin'] : "";
        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $instagram = isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin_page = isset($input['linkedin_page']) ? $input['linkedin_page'] : "";
        $facebook_page = isset($input['facebook_page']) ? $input['facebook_page'] : "";

        $twitter_list = array();
        $linkedin_list = array();
        $facebook_list = array();
        $instagram_list = array();
        $linkedin_page_list = array();
        $facebook_page_list = array();
        if ($twitter != "") {
            $twitter_list = explode(',', $twitter);
            foreach ($twitter_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'twitter')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($linkedin != "") {
            $linkedin_list = explode(',', $linkedin);
            foreach ($linkedin_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'linkedin')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($facebook != "") {
            $facebook_list = explode(',', $facebook);
            foreach ($facebook_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'facebook')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($instagram != "") {
            $instagram_list = explode(',', $instagram);
            foreach ($instagram_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'instagram')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($linkedin_page != "") {
            $linkedin_page_list = explode(',', $linkedin_page);
            foreach ($linkedin_page_list as $account) {
                $isLinked = LinkedInPage::where('user_id', $user_id)->where('page_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($facebook_page != "") {
            $facebook_page_list = explode(',', $facebook_page);
            foreach ($facebook_page_list as $account) {
                $isLinked = FacebookPage::where('user_id', $user_id)->where('page_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        $sp_media_type = 1;
        $sp_date = date('Y-m-d', strtotime($date));
        $sp_time = $time;
        $sp_date_time = Carbon::parse($sp_date . " " . $sp_time);
        $path = '';
        if ($request->file("file") != null) {
            if ($media_type == 1) {
                $path  =  $this->uploadFile($request, null, "file", 'schedule-post-img');
                $sp_media_type = 1;
            } else {
                $path  =  $this->uploadFile($request, null, "file", 'schedule-post-video');
                $sp_media_type = 2;
            }
        }

        if ($request->file("file") != null) {
            DB::table('schedule_post')
                ->where('sp_id', $id)
                ->update([
                    'sp_media_type' => $sp_media_type,
                    'sp_media_path' => $path,
                    'sp_date' => $sp_date,
                    'sp_time' => $sp_time,
                    'sp_caption' => $caption,
                    'sp_hashtag' => $hashtag,
                    'sp_date_time' => $sp_date_time,
                    'sp_created_at' => date('Y-m-d H:i:s')
                ]);
        } else {
            DB::table('schedule_post')
                ->where('sp_id', $id)
                ->update([
                    'sp_date' => $sp_date,
                    'sp_time' => $sp_time,
                    'sp_caption' => $caption,
                    'sp_hashtag' => $hashtag,
                    'sp_date_time' => $sp_date_time,
                    'sp_updated_at' => date('Y-m-d H:i:s')
                ]);
        }

        DB::table('schedule_post_type')->where('sp_id', '=', $id)->delete();

        foreach ($twitter_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $id,
                'social_media_type' => 'twitter',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($linkedin_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $id,
                'social_media_type' => 'linkedin',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($facebook_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $id,
                'social_media_type' => 'facebook',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($instagram_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $id,
                'social_media_type' => 'instagram',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($linkedin_page_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $id,
                'social_media_type' => 'linkedin_page',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($facebook_page_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $id,
                'social_media_type' => 'facebook_page',
                'profile_page_id' => $profile_page_id,
            ]);
        }


        return response()->json(['status' => true, 'message' => "Post Schedule update Successfully"]);
    }

    public function removeSchedulePost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if (!isset($input['id']) || $input['id'] == '') {
            return response()->json(['status' => false, 'message' => 'post you are looking for is not availabe']);
        }

        $getPost = DB::table('schedule_post')->select('sp_media_path', 'is_posted')->where('sp_user_id', $user_id)->where('sp_id', '=', $input['id'])->first();

        if ($getPost) {
            if ($getPost->is_posted == 1) {
                return response()->json(['status' => false, 'message' => 'post you are looking for is already posted']);
            }
            $image_path = $getPost->sp_media_path;
            DB::table('schedule_post')->where('sp_id', '=', $input['id'])->delete();
            DB::table('schedule_post_type')->where('sp_id', '=', $input['id'])->delete();
            Storage::delete($image_path);
        } else {
            return response()->json(['status' => false, 'message' => 'post you are looking for is not availabe']);
        }

        return response()->json(['status' => true, 'message' => "Schedule post successfully removed"]);
    }

    public function sharePost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if (!$request->file("file")) {
            return response()->json(['status' => false, 'message' => 'file is missing']);
        }

        if ($input['media_type'] != 1 && $input['media_type'] != 2) {
            return response()->json(['status' => false, 'message' => 'media type is missing']);
        }

        $media_type = $input['media_type'];
        $caption = isset($input['caption']) ? $input['caption'] : "";
        $hashtag = isset($input['hashtag']) ? $input['hashtag'] : "";
        $twitter = isset($input['twitter']) ? $input['twitter'] : "";
        $linkedin = isset($input['linkedin']) ? $input['linkedin'] : "";
        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $instagram = isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin_page = isset($input['linkedin_page']) ? $input['linkedin_page'] : "";
        $facebook_page = isset($input['facebook_page']) ? $input['facebook_page'] : "";

        $twitter_list = array();
        $linkedin_list = array();
        $facebook_list = array();
        $instagram_list = array();
        $linkedin_page_list = array();
        $facebook_page_list = array();
        if ($twitter != "") {
            $twitter_list = explode(',', $twitter);
            foreach ($twitter_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'twitter')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($linkedin != "") {
            $linkedin_list = explode(',', $linkedin);
            foreach ($linkedin_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'linkedin')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($facebook != "") {
            $facebook_list = explode(',', $facebook);
            foreach ($facebook_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'facebook')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($instagram != "") {
            $instagram_list = explode(',', $instagram);
            foreach ($instagram_list as $account) {
                $isLinked = SocialLogin::where('user_id', $user_id)->where('type', 'instagram')->where('profile_added', 1)->where('profile_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($linkedin_page != "") {
            $linkedin_page_list = explode(',', $linkedin_page);
            foreach ($linkedin_page_list as $account) {
                $isLinked = LinkedInPage::where('user_id', $user_id)->where('page_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        if ($facebook_page != "") {
            $facebook_page_list = explode(',', $facebook_page);
            foreach ($facebook_page_list as $account) {
                $isLinked = FacebookPage::where('user_id', $user_id)->where('page_id', $account)->first();
                if (empty($isLinked)) {
                    return response()->json(['status' => false, 'message' => 'Some account is not linked from your list']);
                }
            }
        }

        $sp_media_type = 1;
        $path = '';
        if ($media_type == 1) {
            $path  =  $this->uploadFile($request, null, "file", 'schedule-post-img');
            $sp_media_type = 1;
        } else {
            $path  =  $this->uploadFile($request, null, "file", 'schedule-post-video');
            $sp_media_type = 2;
        }


        $post_id = DB::table('schedule_post')->insertGetId([
            'sp_user_id' => $user_id,
            'sp_media_type' => $sp_media_type,
            'sp_media_path' => $path,
            'sp_date' => date('Y-m-d'),
            'sp_time' => date('H:i:s'),
            'sp_date_time' => date('Y-m-d H:i:s'),
            'sp_caption' => $caption,
            'sp_hashtag' => $hashtag,
            'sp_created_at' => date('Y-m-d H:i:s')
        ]);

        foreach ($twitter_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $post_id,
                'social_media_type' => 'twitter',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($linkedin_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $post_id,
                'social_media_type' => 'linkedin',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($facebook_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $post_id,
                'social_media_type' => 'facebook',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($instagram_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $post_id,
                'social_media_type' => 'instagram',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($linkedin_page_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $post_id,
                'social_media_type' => 'linkedin_page',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        foreach ($facebook_page_list as $profile_page_id) {
            DB::table('schedule_post_type')->insert([
                'sp_id' => $post_id,
                'social_media_type' => 'facebook_page',
                'profile_page_id' => $profile_page_id,
            ]);
        }

        ShareSocialPostJob::dispatch($post_id);

        return response()->json(['status' => true, 'message' => "Post added Successfully"]);
    }

    public function getScheduledPost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $getPost = DB::table('schedule_post')->where('sp_user_id', '=', $user_id)->where('is_posted', 0)->orderBy('sp_date_time', 'DESC')->get();

        $finalArray = [];
        $finalArray['all'] = [];
        $finalArray['images'] = [];
        $finalArray['videos'] = [];
        foreach ($getPost as &$post) {

            $post->sp_media_path = Storage::url($post->sp_media_path);
            $social_type_data = Helper::getSocialTypeData($post->sp_id);
            $post->sp_social_type = $social_type_data;

            if ($post->sp_media_type == 1) {
                array_push($finalArray['images'], $post);
            } else {
                array_push($finalArray['videos'], $post);
            }
            array_push($finalArray['all'], $post);
        }

        return response()->json(['status' => true, 'message' => "Post Schedule fetched Successfully", 'data' => $finalArray]);
    }

    public function getScheduledHistory(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $offset = 0;
        if (!empty($request->offset)) {
            $offset = $request->offset;
        }
        $postLimit = Helper::GetLimit();

        $getPost = DB::table('schedule_post')->where('sp_user_id', '=', $user_id)->where('is_posted', 1)->orderBy('sp_date_time', 'DESC')->skip($offset)->limit($postLimit)->get();
        $posts = array();
        foreach ($getPost as &$post) {

            $post->sp_media_path = Storage::url($post->sp_media_path);
            $social_type_data = Helper::getSocialTypeData($post->sp_id);
            $post->sp_social_type = $social_type_data;

            array_push($posts, $post);
        }

        $posts_next = DB::table('schedule_post')->where('sp_user_id', '=', $user_id)->where('is_posted', 1)->orderBy('sp_date_time', 'DESC')->skip($offset + count($getPost))->limit($postLimit)->count();

        $next = true;
        if ($posts_next == 0) {
            $next = false;
        }

        $meta = array(
            'offset' => $offset + count($getPost),
            'limit' => intval($postLimit),
            'record' => count($getPost),
            'next' => $next
        );

        return response()->json(['status' => true, 'message' => "Schedule post history fetched Successfully", 'data' => $posts, 'meta' => $meta]);
    }

    // -------------------- Social Media API End

    // -------------------- User Referral API Start

    public function generateReferralLink(Request $request)
    {
        $data = array();
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $checkReferral = UserReferral::where('user_id', $user_id)->first();
        if (!empty($checkReferral)) {
            return response()->json(['status' => false, 'message' => "Referral Link Already generated"]);
        }

        $referral_link = $input['referral_link'];
        $referral = new UserReferral;
        $referral->user_id = $user_id;
        $referral->referral_link = $referral_link;
        $referral->save();

        $data = UserReferral::where('user_id', $user_id)->first();
        return response()->json(['status' => true, 'message' => "Referral Link Generated Succesfully", 'data' => $data]);
    }

    public function getReferralData(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $referralData = UserReferral::where('user_id', $user_id)->first();
        if (empty($referralData)) {
            return response()->json(['status' => false, 'message' => "Referral data not found"]);
        }
        $referralUsersCount = User::where('referral_by', $user_id)->where('is_verified', 1)->count();
        $premiumReferralUsersCount = User::where('referral_by', $user_id)->where('referral_premium', 1)->where('is_verified', 1)->count();
        $referralData->total_referral_users = $referralUsersCount;
        $referralData->total_preminum_referral_users = $premiumReferralUsersCount;
        $banner_image = "";
        $settingData = DB::table('setting')->first();
        $minimum_withdraw_amount = 0;
        if (!empty($settingData)) {
            $minimum_withdraw_amount = $settingData->minimum_withdraw_amount;
            if (!empty($settingData->referral_banner)) {
                $banner_image = url($settingData->referral_banner);
            }
        }
        $referralData->banner = $banner_image;
        $referralData->minimum_withdraw_amount = $minimum_withdraw_amount;
        $pendingWithdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'pending')->first();
        if (empty($pendingWithdraw)) {
            $pendingWithdraw = (object)[];
        }

        $paymentDetail = PaymentDetail::where('user_id', $user_id)->first();
        if (empty($paymentDetail)) {
            $paymentDetail = (object)[];
        }

        $data = ['referralData' => $referralData, 'pendingWithdraw' => $pendingWithdraw, 'paymentDetail' => $paymentDetail];
        return response()->json(['status' => true, 'message' => "Referral Data Fetched Succesfully", 'data' => $data]);
    }

    public function withdrawRequest(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $paymentDetail = PaymentDetail::where('user_id', $user_id)->first();
        if (empty($paymentDetail)) {
            return response()->json(['status' => false, 'message' => 'Payment Detail not found']);
        }
        $referralData = UserReferral::where('user_id', $user_id)->first();
        if (empty($referralData)) {
            return response()->json(['status' => false, 'message' => "Referral data not found"]);
        }
        $pendingWithdraw = WithdrawRequest::where('user_id', $user_id)->where('status', 'pending')->first();
        if (!empty($pendingWithdraw)) {
            return response()->json(['status' => false, 'message' => 'You can not make new withdrawRequest until your previous request is not complete']);
        }
        $minimum_withdraw_amount = 0;
        $settingData = DB::table('setting')->first();
        if (!empty($settingData)) {
            $minimum_withdraw_amount = $settingData->minimum_withdraw_amount;
        }
        if ($referralData->current_balance < $minimum_withdraw_amount) {
            return response()->json(['status' => false, 'message' => "Minimum Withdraw Amount is " . $settingData->minimum_withdraw_amount]);
        }
        $newRequest = new WithdrawRequest;
        $newRequest->user_id = $user_id;
        $newRequest->amount = $referralData->current_balance;
        $newRequest->save();
        $referralData->current_balance = 0;
        $referralData->save();
        return response()->json(['status' => true, 'message' => "Withdraw request added Successfully"]);
    }

    public function withdrawHistory(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $withdrawHistory = WithdrawRequest::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        return response()->json(['status' => true, 'data' => $withdrawHistory, 'message' => "Withdraw history fetched Successfully"]);
    }

    public function updatePaymentDetail(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        if (empty($request->upi_id)) {
            return response()->json(['status' => false, 'message' => 'UPI ID is not valid']);
        }
        $upi_id = $request->upi_id;
        $checkDetail = PaymentDetail::where('user_id', $user_id)->first();
        if (empty($checkDetail)) {
            $checkDetail = new PaymentDetail;
            $checkDetail->user_id = $user_id;
        }
        if (empty($checkDetail->contact_id)) {
            $data = Helper::createRazorPayContact($user_id);
            if (!$data['status']) {
                return response()->json(['status' => false, 'message' => $data['error']]);
            } else {
                $checkDetail->contact_id = $data['contact_id'];
            }
        }
        $contact_id = $checkDetail->contact_id;

        if ($upi_id != $checkDetail->upi_id) {
            $data = Helper::createRazorPayFundAccount($contact_id, $upi_id);
            if (!$data['status']) {
                return response()->json(['status' => false, 'message' => $data['error']]);
            } else {
                $checkDetail->fund_id = $data['fund_id'];
            }
        }

        $fund_id = $checkDetail->fund_id;

        $checkDetail->contact_id = $contact_id;
        $checkDetail->fund_id = $fund_id;
        $checkDetail->upi_id = $upi_id;
        $checkDetail->save();
        return response()->json(['status' => true, 'data' => $checkDetail, 'message' => "Payment detail updated Successfully"]);
    }

    // -------------------- User Referral API End

    public function getFrames(Request $request)
    {
        $input = $request->all();

        $user_id = $this->get_userid($input['token']);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $user = User::find($user_id);
        if ($request->frame_type == "Business") {
            $business = Business::where('busi_id', $user->default_business_id)->first();
            if (empty($business)) {
                return response()->json(['status' => false, 'message' => 'Business not found']);
            }
        } else {
            $business = PoliticalBusiness::where('pb_id', '=', $user->default_political_business_id)->where('pb_is_deleted', '=', 0)->first();
            if (empty($business)) {
                return response()->json(['status' => false, 'message' => 'Business not found']);
            }
        }


        $frame_type = 'Business';
        if ($request->has('frame_type')) {
            $frame_type = $request->frame_type;
        }

        $business_type = 1;
        $business_id = $user->default_business_id;
        if ($request->has('frame_type')) {
            if ($request->frame_type == "Photo") {
                $business_type = 2;
                $business_id = $user->default_political_business_id;
            }
        }


        $light_frames = $this->getModeWiseFrame('light', $frame_type, $business, $user_id, $business_type, $business_id);

        $dark_frames = $this->getModeWiseFrame('dark',  $frame_type, $business, $user_id, $business_type, $business_id);

        return response()->json(['status' => true, 'light_frames' => $light_frames, 'dark_frames' => $dark_frames, 'message' => "Frames fetched successfully"]);
    }

    public function getModeWiseFrame($mode, $frame_type, $business, $user_id, $business_type, $business_id) {
        $frame_data = array();

        $frameLists = DB::table('user_frames')
                        ->where('user_id', $user_id)
                        ->where('business_id', $business_id)
                        ->where('business_type', $business_type)
                        ->where('is_deleted', 0)
                        ->orderBy('user_frames_id', 'DESC')
                        ->get();

        foreach ($frameLists as &$frameList) {

            $frame_image = Storage::url($frameList->frame_url);
            $thumb_image = $frame_image;

            $data = [
                'frame_image' => $frame_image,
                'thumbnail_image' => $thumb_image,
                'civ_height' => "",
                'civ_width' => "",
                'custom_he' => "",
                'custom_wi' => "",
                'custom_x' => "",
                'custom_y' => "",
                'frame_name' => "",
                'overlay_blur' => "",
                'overlay_name' => "",
                'overlay_opacity' => "",
                'profile_type' => "",
                'ration' => '',
                'saveImageHeight' => "",
                'saveImageWidth' => "",
                'seek_value' => "",
                'shap_name' => "",
                'template_id' => "",
                'tempcolor' => "",
                'temp_path' => "",
                'thumb_uri' => "",
                'type' => "",
                'componentInfoJsonArrayList' => array(),
                'textInfoJsonArrayList' => array(),
            ];
            array_push($frame_data, $data);
        }

        $frames = Frame::where('frame_type', $frame_type)
                        ->whereIn('frame_mode', array($mode, 'both'))
                        ->where('is_active', 1)
                        ->orderBy('display_order', 'ASC')
                        ->get();

        foreach ($frames as $frame) {

            $isFrameValid = true;
            $fields = FrameField::where('frame_id', $frame->id)->get();

            // if(count($fields) == 0) {
            //     $isFrameValid = false;
            // }

            foreach($fields as $field){

                $business_field = BusinessField::where('id', $field->field_id)->first();
                if(empty($business_field)) {
                    $isFrameValid = false;
                }
                else {
                    $field_key = $business_field->field_key;
                    if(empty($business[$field_key])) {
                        $isFrameValid = false;
                    }
                }
            }

            if($isFrameValid) {
                $frame_image = Storage::url($frame->frame_image);
                $thumb_image = $frame_image;
                if (!empty($frame->thumbnail_image)) {
                    $thumb_image = Storage::url($frame->thumbnail_image);
                }
                $data = [
                    'frame_image' => $frame_image,
                    'thumbnail_image' => $thumb_image,
                    'civ_height' => "675.0",
                    'civ_width' => "1280.0",
                    'custom_he' => "675.0",
                    'custom_wi' => "675.977600097656",
                    'custom_x' => "262.011169433594",
                    'custom_y' => "0.0",
                    'frame_name' => "frame",
                    'overlay_blur' => "0.0",
                    'overlay_name' => "",
                    'overlay_opacity' => "80",
                    'profile_type' => "Nature",
                    'ration' => '1:1',
                    'saveImageHeight' => "0",
                    'saveImageWidth' => "0",
                    'seek_value' => "378",
                    'shap_name' => "",
                    'template_id' => strval($frame->id),
                    'tempcolor' => "",
                    'temp_path' => "",
                    'thumb_uri' => "",
                    'type' => "user",
                    'componentInfoJsonArrayList' => array(),
                    'textInfoJsonArrayList' => array(),
                ];
                $images = FrameComponent::where('frame_id', $frame->id)->get();

                $image_data = array();
                foreach ($images as &$image) {
                    if ($image->image_for == 0) {
                        if (!empty($image->stkr_path)) {
                            $image->template_id = strval($frame->id);
                            $image->stkr_path = Storage::url($image->stkr_path);
                            $image->order = strval($image->order_);
                            unset($image->order_);
                            array_push($image_data, $image);
                        }
                    } else {
                        $business_field = BusinessField::where('id', $image->image_for)->first();
                        if($business_field->field_key == 'busi_logo' || $business_field->field_key == 'watermark_image' || $business_field->field_key == 'pb_party_logo' || $business_field->field_key == 'pb_watermark') {
                            $image_path = "";
                            if($mode == 'dark') {
                                $image_path = $business[$business_field->field_key];
                                if(empty($image_path)) {
                                    $image_path = $business[$business_field->field_key . '_dark'];
                                }
                            }
                            if($mode == 'light') {
                                $image_path = $business[$business_field->field_key . '_dark'];
                                if(empty($image_path)) {
                                    $image_path = $business[$business_field->field_key];
                                }
                            }
                            if(!empty($image_path)) {
                                $image->template_id = strval($frame->id);
                                $image->stkr_path = Storage::url($image_path);
                                $image->order = strval($image->order_);
                                unset($image->order_);
                                array_push($image_data, $image);
                            }
                        }
                        else {
                            if (!empty($business[$business_field->field_key])) {
                                $image->template_id = strval($frame->id);
                                $image->stkr_path = Storage::url($business[$business_field->field_key]);
                                $image->order = strval($image->order_);
                                unset($image->order_);
                                array_push($image_data, $image);
                            }
                        }
                    }
                }

                $texts = FrameText::where('frame_id', $frame->id)->get();
                $textData = array();
                foreach ($texts as &$text) {
                    $business_field = BusinessField::where('id', $text->text_for)->first();
                    if (!empty($business[$business_field->field_key])) {
                        $text->template_id = strval($frame->id);
                        $text->text = $business[$business_field->field_key];
                        $text->order = strval($text->order_);
                        unset($text->order_);
                        array_push($textData, $text);
                    }
                }
                $data['componentInfoJsonArrayList'] = $image_data;
                $data['textInfoJsonArrayList'] = $textData;
                array_push($frame_data, $data);
            }

        }

        return $frame_data;
    }

    public function getMusicList(Request $request)
    {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $music_list_array = array();
        $music_categories = MusicCategory::whereNotNull('order_number')->where('is_delete', 0)->where('is_active', 1)->orderBy('order_number', 'ASC')->get();

        foreach ($music_categories as $category) {
            $musics = Music::where('category_id', $category->id)->where('is_delete', 0)->whereNotNull('order_number')->orderBy('order_number', 'ASC')->get();
            if (count($musics)) {
                foreach ($musics as &$music) {
                    $music->audio = Storage::url($music->audio);
                    $music->image = Storage::url($music->image);
                }
                $data = $category;
                $data['musics'] = $musics;
                array_push($music_list_array, $data);
            }
            $musics = Music::where('category_id', $category->id)->where('is_delete', 0)->whereNull('order_number')->orderBy('id', 'DESC')->get();
            if (count($musics)) {
                foreach ($musics as &$music) {
                    $music->audio = Storage::url($music->audio);
                    $music->image = Storage::url($music->image);
                }
                $data = $category;
                $data['musics'] = $musics;
                array_push($music_list_array, $data);
            }
        }

        $music_categories = MusicCategory::whereNull('order_number')->where('is_delete', 0)->where('is_active', 1)->orderBy('id', 'DESC')->get();

        foreach ($music_categories as $category) {
            $musics = Music::where('category_id', $category->id)->where('is_delete', 0)->whereNotNull('order_number')->orderBy('order_number', 'ASC')->get();
            if (count($musics)) {
                foreach ($musics as &$music) {
                    $music->audio = Storage::url($music->audio);
                    $music->image = Storage::url($music->image);
                }
                $data = $category;
                $data['musics'] = $musics;
                array_push($music_list_array, $data);
            }
            $musics = Music::where('category_id', $category->id)->where('is_delete', 0)->whereNull('order_number')->orderBy('id', 'v')->get();
            if (count($musics)) {
                foreach ($musics as &$music) {
                    $music->audio = Storage::url($music->audio);
                    $music->image = Storage::url($music->image);
                }
                $data = $category;
                $data['musics'] = $musics;
                array_push($music_list_array, $data);
            }
        }

        return response()->json(['status' => true, 'data' => $music_list_array, 'message' => 'Music List Fetched Successfully']);
    }

    public function getBGRemoveCreditPlan(Request $request)
    {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $plan_data = array();

        $plans = BGCreditPlan::where('status', 'UNBLOCK')->whereNotNull('order_number')->orderBy('order_number', 'ASC')->get();
        foreach ($plans as $plan) {
            $data['id'] = !empty($plan->id) ? $plan->id : 0;
            $data['name'] = !empty($plan->name) ? $plan->name : '';
            $data['price'] = !empty($plan->price) ? $plan->price : 0;
            $data['bg_credit'] = !empty($plan->bg_credit) ? $plan->bg_credit : 0;
            $data['status'] = !empty($plan->status) ? $plan->status : '';
            $data['order_number'] = !empty($plan->order_number) ? $plan->order_number : 0;
            array_push($plan_data, $data);
        }

        $plans = BGCreditPlan::where('status', 'UNBLOCK')->whereNull('order_number')->get();
        foreach ($plans as $plan) {
            $data['id'] = !empty($plan->id) ? $plan->id : 0;
            $data['name'] = !empty($plan->name) ? $plan->name : '';
            $data['price'] = !empty($plan->price) ? $plan->price : 0;
            $data['bg_credit'] = !empty($plan->bg_credit) ? $plan->bg_credit : 0;
            $data['status'] = !empty($plan->status) ? $plan->status : '';
            $data['order_number'] = !empty($plan->order_number) ? $plan->order_number : 0;
            array_push($plan_data, $data);
        }

        $user = User::find($user_id);
        $remaining_bg_credit = $user->bg_credit;
        return response()->json(['status' => 'true', 'remaining_bg_credit' => $remaining_bg_credit, 'data' => $plan_data, 'message' => "Plan list fetched successfully"]);
    }

    public function purchaseBGRemovePlan(Request $request)
    {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $plan_id = $request->plan_id;
        $payment_id = $request->payment_id;
        if (empty($plan_id)) {
            return response()->json(['status' => false, 'message' => 'Plan Id Required']);
        }

        $plan = BGCreditPlan::find($plan_id);
        if (empty($plan)) {
            return response()->json(['status' => false, 'message' => 'Plan not found']);
        }
        if ($plan->status === 'BLOCK') {
            return response()->json(['status' => false, 'message' => 'Plan not available at the moment']);
        }

        if (empty($payment_id)) {
            return response()->json(['status' => false, 'message' => 'Payment Id is required']);
        }

        $credit = !empty($plan->bg_credit) ? $plan->bg_credit : 0;
        $userData = User::find($user_id);
        $user_credit = $userData->bg_credit;
        $new_credit = $credit + $user_credit;
        $userData->bg_credit = $new_credit;
        $userData->save();

        $history = new BGCreditPlanHistory;
        $history->user_id = $user_id;
        $history->plan_id = $plan_id;
        $history->payment_id = $payment_id;
        $history->plan_price = !empty($plan->price) ? $plan->price : 0;
        $history->plan_bg_credit = !empty($plan->bg_credit) ? $plan->bg_credit : 0;
        $history->save();

        $data = [
            'new_credit' => $new_credit,
        ];
        return response()->json(['status' => true, 'data' => $data, 'message' => "BG Remover plan purchased successfully"]);
    }

    public function removeBackground(Request $request)
    {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }
        $userData = User::find($user_id);
        if ($userData->bg_credit < 1) {
            return response()->json(['status' => false, 'message' => 'No credit remaining']);
        }
        $file = $request->image;
        $file_data = Helper::removeBackgroundImage($file);

        $userData->bg_credit = $userData->bg_credit - 1;
        $userData->save();

        return response($file_data->getBody())
        ->withHeaders($file_data->getHeaders());
    }

    public function userDownloadPhoto(Request $request)
    {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if (empty($request->type)) {
            return response()->json(['status' => false, 'message' => 'Type is required']);
        }

        $type = $request->type;
        if ($type < 1 || $type > 7) {
            return response()->json(['status' => false, 'message' => 'Type not valid']);
        }

        if (empty($request->category_id)) {
            return response()->json(['status' => false, 'message' => 'Category Id is required']);
        }
        $category_id = $request->category_id;
        if ($type == 1 || $type == 2) {
            $category = DB::table('business_category')->where('id', $category_id)->where('is_delete', '=', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
        }

        if ($type == 3) {
            $category = Festival::where('fest_id', $category_id)->where('fest_type', 'festival')->where('fest_is_delete', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
        }
        if ($type == 4) {
            $category = Festival::where('fest_id', $category_id)->where('fest_type', 'festival')->where('fest_is_delete', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
            $videoFestival = VideoData::where('video_name', $category->fest_name)->where('video_is_delete', 0)->first();
            $category = VideoData::where('video_id', $videoFestival->video_id)->where('video_type', 'festival')->where('video_is_delete', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
            $category_id = $videoFestival->video_id;
        }

        if ($type == 5) {
            $category = Festival::where('fest_id', $category_id)->where('fest_type', 'incident')->where('fest_is_delete', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
        }

        if ($type == 6) {
            $category = Festival::where('fest_id', $category_id)->where('fest_type', 'incident')->where('fest_is_delete', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
            $videoFestival = VideoData::where('video_name', $category->fest_name)->where('video_is_delete', 0)->first();
            $category = VideoData::where('video_id', $videoFestival->video_id)->where('video_type', 'incident')->where('video_is_delete', 0)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
            $category_id = $videoFestival->video_id;
        }

        if ($type == 7) {
            $category = DB::table('custom_cateogry')->where('is_active', 1)->where('custom_cateogry_id', $category_id)->first();
            if (empty($category)) {
                return response()->json(['status' => false, 'message' => 'Category not found']);
            }
        }

        if (empty($request->business_type)) {
            return response()->json(['status' => false, 'message' => 'Business Type Is Required']);
        }

        $business_type = $request->business_type;
        if ($business_type != 1 && $business_type != 2) {
            return response()->json(['status' => false, 'message' => 'Business Type not valid']);
        }

        $userData = User::find($user_id);

        $business_id = 0;
        if ($business_type == 1) {
            $business_id = $userData->default_business_id;
        } else {
            $business_id = $userData->default_political_business_id;
        }

        if ($business_type == 1) {
            $business = Business::where('busi_id', $business_id)->where('busi_delete', 0)->first();
            if (empty($business)) {
                return response()->json(['status' => false, 'message' => 'Business not found']);
            }
        } else {
            $business = PoliticalBusiness::where('pb_id', $business_id)->where('pb_is_deleted', 0)->first();
            if (empty($business)) {
                return response()->json(['status' => false, 'message' => 'Business not found']);
            }
        }

        $limit = new UserDownloadHistory;
        $limit->user_id = $user_id;
        $limit->type = $type;
        $limit->category_id = $category_id;
        $limit->business_type = $business_type;
        $limit->business_id = $business_id;
        $limit->save();

        return response()->json(['status' => true, 'message' => 'User download history added successfully']);
    }

    public function checkUserRemainingLimit(Request $request)
    {

        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        if (empty($request->type)) {
            return response()->json(['status' => false, 'message' => 'type not found']);
        }

        if (empty($request->category_id)) {
            return response()->json(['status' => false, 'message' => 'category id not found']);
        }

        $type = $request->type;
        $category_id = $request->category_id;

        $data = Helper::getUserRemainingLimit($user_id, $type, $category_id);
        $data['type'] = $type;

        return response()->json(['status' => true, 'data' => $data, 'message' => 'User Remaining Limits']);
    }

    public function addContentCreater(Request $request) {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $creator = ContentCreator::where('user_id', $user_id)->first();
        if(!empty($creator)) {
            return response()->json(['status' => false, 'message' => 'Your request is ' . strtolower($creator->status)]);
        }

        if (empty($request->name) || empty($request->city) || empty($request->work_experience) || empty($request->skills) || empty($request->current_work) || empty($request->contact_no) || empty($request->email)) {
            return response()->json(['status' => false, 'message' => 'Please fill all required fields']);
        }

        $creator = new ContentCreator;
        $creator->user_id = $user_id;
        $creator->name = $request->name;
        $creator->city = $request->city;
        $creator->work_experience = $request->work_experience;
        $creator->skills = $request->skills;
        $creator->current_work = $request->current_work;
        $creator->contact_no = $request->contact_no;
        $creator->email = $request->email;
        $creator->save();

        return response()->json(['status' => true, 'data' => $creator, 'message' => 'Content creator request added sucessfully']);
    }
    public function addDistributor(Request $request) {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $distributor = Distributor::where('user_id', $user_id)->first();
        if(!empty($distributor)) {
            return response()->json(['status' => false, 'message' => 'Your request is ' . strtolower($distributor->status)]);
        }

        if (empty($request->name) || empty($request->city) || empty($request->current_work) || empty($request->contact_no) || empty($request->email)) {
            return response()->json(['status' => false, 'message' => 'Please fill all required fields']);
        }

        $distributor = new Distributor;
        $distributor->user_id = $user_id;
        $distributor->name = $request->name;
        $distributor->city = $request->city;
        $distributor->current_work = $request->current_work;
        $distributor->contact_no = $request->contact_no;
        $distributor->email = $request->email;
        $distributor->save();

        return response()->json(['status' => true, 'data' => $distributor, 'message' => 'Content distributor request added sucessfully']);
    }

    public function getBanners(Request $request) {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $settingData = DB::table('setting')->first();

        $creator_banner = "";
        if(!empty($settingData->creator_banner)) {
            $creator_banner = url($settingData->creator_banner);
        }

        $distributor_banner = "";
        if(!empty($settingData->distributor_banner)) {
            $distributor_banner = url($settingData->distributor_banner);
        }

        $partner_us_banner = "";
        if(!empty($settingData->partner_us_banner)) {
            $partner_us_banner = url($settingData->partner_us_banner);
        }
        $is_content_creator = false;
        $is_distributor = false;
        $checkCreator = ContentCreator::where('user_id', $user_id)->first();
        if(!empty($checkCreator)) {
            $is_content_creator = true;
        }
        $distributor = Distributor::where('user_id', $user_id)->first();
        if(!empty($distributor)) {
            $is_distributor = true;
        }

        $banner = [
            'creator_banner' => $creator_banner,
            'distributor_banner' => $distributor_banner,
            'partner_us_banner' => $partner_us_banner,
            'is_content_creator' => $is_content_creator,
            'is_distributor' => $is_distributor,
        ];

        return response()->json(['status' => true, 'data' => $banner, 'message' => 'Banner fetched sucessfully']);
    }

    public function testFramejson(Request $request) {

        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $user = User::find($user_id);

        $data = [];

        $frame_data = array();

        $business = Business::where('busi_id', $user->default_business_id)->first();

        $frame_type = 'Business';
        $mode = 'light';

        $frames = Frame::where('frame_type', $frame_type)
                        ->whereIn('frame_mode', array($mode, 'both'))
                        ->where('is_active', 1)
                        ->orderBy('display_order', 'ASC')
                        ->limit(1)
                        ->get();

        foreach ($frames as $frame) {

            $isFrameValid = true;
            // $fields = FrameField::where('frame_id', $frame->id)->get();

            // // if(count($fields) == 0) {
            // //     $isFrameValid = false;
            // // }

            // foreach($fields as $field){

            //     $business_field = BusinessField::where('id', $field->field_id)->first();
            //     if(empty($business_field)) {
            //         $isFrameValid = false;
            //     }
            //     else {
            //         $field_key = $business_field->field_key;
            //         if(empty($business[$field_key])) {
            //             $isFrameValid = false;
            //         }
            //     }
            // }

            if($isFrameValid) {
                $frame_image = Storage::url($frame->frame_image);
                $thumb_image = $frame_image;
                if (!empty($frame->thumbnail_image)) {
                    $thumb_image = Storage::url($frame->thumbnail_image);
                }
                $data = [
                    'frame_image' => $frame_image,
                    'thumbnail_image' => $thumb_image,
                    'civ_height' => "675.0",
                    'civ_width' => "1280.0",
                    'custom_he' => "675.0",
                    'custom_wi' => "675.977600097656",
                    'custom_x' => "262.011169433594",
                    'custom_y' => "0.0",
                    'frame_name' => "frame",
                    'overlay_blur' => "0.0",
                    'overlay_name' => "",
                    'overlay_opacity' => "80",
                    'profile_type' => "Nature",
                    'ration' => '1:1',
                    'saveImageHeight' => "0",
                    'saveImageWidth' => "0",
                    'seek_value' => "378",
                    'shap_name' => "",
                    'template_id' => strval($frame->id),
                    'tempcolor' => "",
                    'temp_path' => "",
                    'thumb_uri' => "",
                    'type' => "user",
                    'componentInfoJsonArrayList' => array(),
                    'textInfoJsonArrayList' => array(),
                ];
                $images = FrameComponent::where('frame_id', $frame->id)->get();

                $image_data = array();
                foreach ($images as &$image) {
                    if ($image->image_for == 0) {
                        if (!empty($image->stkr_path)) {
                            $image->template_id = strval($frame->id);
                            $image->stkr_path = Storage::url($image->stkr_path);
                            $image->order = strval($image->order_);
                            unset($image->order_);
                            array_push($image_data, $image);
                        }
                    } else {
                        $business_field = BusinessField::where('id', $image->image_for)->first();
                        if($business_field->field_key == 'busi_logo' || $business_field->field_key == 'watermark_image' || $business_field->field_key == 'pb_party_logo' || $business_field->field_key == 'pb_watermark') {
                            $image_path = "";
                            if($mode == 'dark') {
                                $image_path = $business[$business_field->field_key];
                                if(empty($image_path)) {
                                    $image_path = $business[$business_field->field_key . '_dark'];
                                }
                            }
                            if($mode == 'light') {
                                $image_path = $business[$business_field->field_key . '_dark'];
                                if(empty($image_path)) {
                                    $image_path = $business[$business_field->field_key];
                                }
                            }
                            if(!empty($image_path)) {
                                $image->template_id = strval($frame->id);
                                $image->stkr_path = Storage::url($image_path);
                                $image->order = strval($image->order_);
                                unset($image->order_);
                                array_push($image_data, $image);
                            }
                        }
                        else {
                            if (!empty($business[$business_field->field_key])) {
                                $image->template_id = strval($frame->id);
                                $image->stkr_path = Storage::url($business[$business_field->field_key]);
                                $image->order = strval($image->order_);
                                unset($image->order_);
                                array_push($image_data, $image);
                            }
                        }
                    }
                }

                $texts = FrameText::where('frame_id', $frame->id)->get();
                $textData = array();
                foreach ($texts as &$text) {
                    $business_field = BusinessField::where('id', $text->text_for)->first();
                    if (!empty($business[$business_field->field_key])) {
                        $text->template_id = strval($frame->id);
                        $text->text = $business[$business_field->field_key];
                        $text->order = strval($text->order_);
                        unset($text->order_);
                        array_push($textData, $text);
                    }
                }
                $data['componentInfoJsonArrayList'] = $image_data;
                $data['textInfoJsonArrayList'] = $textData;
                array_push($frame_data, $data);
            }

        }

        return response()->json(['status' => true, 'data' => $frame_data, 'message' => 'Test Frame Json']);

    }

    public function search(Request $request) {

        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $currnt_date = date('Y-m-d');
        $tranding_data = array();
        $trandings = Festival::whereDate('fest_date', $currnt_date)
        ->whereIn('fest_type', array('tranding'))
        ->where('fest_is_delete', 0)
        ->where('fest_name', 'LIKE', '%'  .$request->search . '%')
        ->orderBy('fest_date', 'ASC')
        ->get();
        for ($i = 0; $i < sizeof($trandings); $i++) {
            $trandings[$i]['fest_day'] = date_parse_from_format('Y-m-d', $trandings[$i]['fest_date'])['day'];
            $trandings[$i]['fest_date'] = date("d-m-Y", strtotime($trandings[$i]['fest_date']));
            $data_tranding['fest_id'] = strval($trandings[$i]['fest_id']);
            $data_tranding['fest_name'] = !empty($trandings[$i]['fest_name']) ? $trandings[$i]['fest_name'] : "";
            $data_tranding['fest_info'] = !empty($trandings[$i]['fest_info']) ? $trandings[$i]['fest_info'] : "";
            $data_tranding['fest_image'] = !empty($trandings[$i]['fest_image']) ? Storage::url($trandings[$i]['fest_image']) : "";
            $data_tranding['fest_type'] = !empty($trandings[$i]['fest_type']) ? $trandings[$i]['fest_type'] : "";
            $data_tranding['fest_date'] = $trandings[$i]['fest_date'];
            $data_tranding['fest_day'] = strval($trandings[$i]['fest_day']);
            $data_tranding['fest_is_delete'] = strval($trandings[$i]['fest_is_delete']);
            $data_tranding['img_url'] = array();


                $photo = Post::where('post_category_id', '=', $trandings[$i]['fest_id'])->where('post_is_deleted', '=', 0)->select('post_content', 'post_id', 'image_type', 'post_category_id', 'post_mode')->orderBy('image_type', 'ASC')->orderBy('post_id', 'DESC')->get();

                foreach ($photo as $ph_value) {
                    $tranding_image_data['post_content'] = !empty($ph_value->post_thumb) ? Storage::url($ph_value->post_thumb) : Storage::url($ph_value->post_content);
                    $tranding_image_data['post_id'] = !empty($ph_value->post_id) ? strval($ph_value->post_id) : "0";
                    $tranding_image_data['image_type'] = !empty($ph_value->image_type) ? strval($ph_value->image_type) : "0";
                    $tranding_image_data['post_category_id'] = !empty($ph_value->post_category_id) ? strval($ph_value->post_category_id) : "0";
                    $tranding_image_data['post_mode'] = !empty($ph_value->post_mode) ? strval($ph_value->post_mode) : "light";
                    $tranding_image_data['post_type'] = "image";
                    array_push($data_tranding['img_url'], $tranding_image_data);
                }

                $videoPostCategory = DB::table('video_data')->where('video_name', $trandings[$i]['fest_name'])->where('video_is_delete', 0)->first();
                if(!empty($videoPostCategory)) {

                    $video = DB::table('video_post_data')
                    ->where('video_post_id', '=', $videoPostCategory->video_id)
                    ->where('is_deleted', '=', 0)
                    ->orderBy('image_type', 'ASC')
                    ->orderBy('id', 'DESC')
                    ->get();

                    foreach ($video as $key => $value) {
                        $tranding_video_data = array();

                        $tranding_video_data['id'] = strval($value->id);
                        $tranding_video_data['image'] = !empty($value->thumbnail) ? Storage::url($value->thumbnail) : "";
                        if ($value->video_store == "LOCAL") {
                            $tranding_video_data['video'] = !empty($value->video_url) ? url('/') . '/' . $value->video_url : "";
                        } else {
                            $tranding_video_data['video'] = !empty($value->video_url) ? Storage::url($value->video_url) : "";
                        }
                        $tranding_video_data['image_type'] = strval($value->image_type);
                        $tranding_video_data['color'] = !empty($value->color) ? $value->color : "";
                        $tranding_video_data['post_mode'] = !empty($value->post_mode) ? $value->post_mode : "light";
                        $tranding_video_data['post_type'] = "video";
                        array_push($data_tranding['img_url'], $tranding_video_data);
                    }
                }


            array_push($tranding_data, $data_tranding);
        }

        $festivals_data = array();

        $festivals = Festival::where('fest_date', '>=', $currnt_date)
        ->where('fest_is_delete', 0)
        ->whereIn('fest_type', array('incedent', 'festival'))
        ->where('fest_name', 'LIKE', '%'  .$request->search . '%')
        ->orderBy('fest_date', 'ASC')
        ->get();
        for ($i = 0; $i < sizeof($festivals); $i++) {
            $festival_data['id'] = strval($festivals[$i]['fest_id']);
            $festival_data['name'] = !empty($festivals[$i]['fest_name']) ? $festivals[$i]['fest_name'] : "";
            $festival_data['image'] = !empty($festivals[$i]['fest_image']) ? Storage::url($festivals[$i]['fest_image']) : "";
            $festival_data['date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
            array_push($festivals_data, $festival_data);
        }

        $business_categories_data = array();
        $business_categories = DB::table('business_category')
        ->where('is_delete', 0)
        ->where('name', 'LIKE', '%'  .$request->search . '%')
        ->orderBy('name', 'ASC')
        ->get();

        foreach($business_categories as $categories) {
            $business_data['id'] = strval($categories->id);
            $business_data['name'] = !empty($categories->name) ? $categories->name : "";
            $business_data['image'] = !empty($categories->image) ? Storage::url($categories->image) : "";
            array_push($business_categories_data, $business_data);
        }

        $greetings_data = array();
        $greetings = DB::table('custom_cateogry')
        ->where('is_active', 1)
        ->where('name', 'LIKE', '%'  .$request->search . '%')
        ->orderBy('name', 'ASC')
        ->get();

        foreach($greetings as $greeting) {
            $greeting_data['id'] = strval($greeting->custom_cateogry_id);
            $greeting_data['name'] = !empty($greeting->name) ? $greeting->name : "";
            $greeting_data['image'] = !empty($greeting->slider_img) ? Storage::url($greeting->slider_img) : "";
            array_push($greetings_data, $greeting_data);
        }

        $data = [
            'trandings' => $tranding_data,
            'festivals' => $festivals_data,
            'business_categories' => $business_categories_data,
            'greetings' => $greetings_data,
        ];
        return response()->json(['status' => true, 'data' => $data, 'message' => 'Search complete']);

    }

    public function getBusinessCategoryData(Request $request) {
        $token = $request->token;
        $user_id = $this->get_userid($token);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => 'user not valid']);
        }

        $userdata = User::where('id', '=', $user_id)->select(['default_business_id', 'user_language', 'default_political_business_id'])->first();

        $user_selected_language = explode(',', $userdata->user_language);
        array_push($user_selected_language, "2", "4");

        // $user_language_check = $userdata->user_language != NULL ? true : false;
        $currntbusiness = Business::where('busi_id', '=', $userdata->default_business_id)->where('busi_delete', '=', 0)->first();
        $political_category_name = "";
        $currntbusinessPolitical = PoliticalBusiness::where('pb_id', '=', $userdata->default_political_business_id)->where('pb_is_deleted', '=', 0)->first();
        if(!empty($currntbusinessPolitical)) {
            $partyData = DB::table('political_category')->where('pc_id', '=', $currntbusinessPolitical->pb_pc_id)->first();
            if(!empty($partyData)) {
                $political_category_name = $partyData->pc_name;
            }
        }

        $currntbusiness_photos = (object)[];
        $sub_categories = array();
        $sub_categories_post = array();
        $sub_categories_post_data = array();

        if($request->type == 1) {

            if (!empty($currntbusiness)) {
                $currntbusiness_photos = array();
                $currntbusiness_photo_id = DB::table('business_category')->where('name', $currntbusiness->business_category)->where('is_delete', 0)->first();

                if (!empty($currntbusiness_photo_id)) {
                    $currntbusiness_photo = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', 'image')->where('buss_cat_post_id', '=', $currntbusiness_photo_id->id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->limit(10)->get();
                    $currntbusiness_photos['id'] =  $currntbusiness_photo_id->id;
                    $currntbusiness_photos['cat_name'] =  $currntbusiness->business_category;
                    $currntbusiness_photos['images'] =  [];

                    foreach ($currntbusiness_photo as $img_key => $img_value) {

                        $img_data['image_id'] = strval($img_value->id);
                        $img_data['image_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                        $img_data['image_type'] = strval($img_value->image_type);
                        $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";

                        array_push($currntbusiness_photos['images'], $img_data);
                    }

                    $categoriesIds = DB::table('business_category_post_data')->where('buss_cat_post_id', '=', $currntbusiness_photo_id->id)->where('is_deleted', '=', 0)->where('festival_id', 0)->groupBy('business_sub_category_id')->pluck('business_sub_category_id')->toArray();
                    $sub_categories = BusinessSubCategory::whereIn('id', $categoriesIds)->where('business_category_id', $currntbusiness_photo_id->id)->where('is_delete', 0)->get();
                }
            }
        }
        else {

            if(!empty($currntbusinessPolitical)) {
                $currntbusiness_photo_id = DB::table('business_category')->where('name', $political_category_name)->where('is_delete', 0)->first();
                $currntbusiness_photos = array();
                if (!empty($currntbusiness_photo_id)) {
                    $currntpoliticalbusiness_photoData = DB::table('business_category_post_data')->whereIn('language_id', $user_selected_language)->where('post_type', 'image')->where('buss_cat_post_id', '=', $currntbusiness_photo_id->id)->where('is_deleted', '=', 0)->where('festival_id', 0)->orderBy('image_type', 'ASC')->orderBy('id', 'DESC')->limit(10)->get();
                    $currntbusiness_photos['id'] =  $currntbusiness_photo_id->id;
                    $currntbusiness_photos['cat_name'] =  $political_category_name;
                    $currntbusiness_photos['images'] =  [];

                    foreach ($currntpoliticalbusiness_photoData as $img_key => $img_value) {

                        $img_data['image_id'] = strval($img_value->id);
                        $img_data['image_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                        $img_data['image_type'] = strval($img_value->image_type);
                        $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";

                        array_push($currntbusiness_photos['images'], $img_data);
                    }

                    $categoriesIds = DB::table('business_category_post_data')->where('buss_cat_post_id', '=', $currntbusiness_photo_id->id)->where('is_deleted', '=', 0)->where('festival_id', 0)->groupBy('business_sub_category_id')->pluck('business_sub_category_id')->toArray();
                    $sub_categories = BusinessSubCategory::whereIn('id', $categoriesIds)->where('business_category_id', $currntbusiness_photo_id->id)->where('is_delete', 0)->get();


                }
            }
        }

        foreach($sub_categories as $categories) {
            $categories->image = Storage::url($categories->image);
            $currntpoliticalbusiness_photoData = DB::table('business_category_post_data')
            ->whereIn('language_id', $user_selected_language)
            ->where('post_type', 'image')
            ->where('business_sub_category_id', $categories->id)
            ->where('buss_cat_post_id', '=', $currntbusiness_photo_id->id)
            ->where('is_deleted', '=', 0)
            ->where('festival_id', 0)
            ->orderBy('image_type', 'ASC')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();

            $sub_categories_post['id'] =  $currntbusiness_photo_id->id;
            $sub_categories_post['sub_category_id'] =  $categories->id;
            $sub_categories_post['cat_name'] =  $categories->name;
            $sub_categories_post['images'] =  [];

            foreach ($currntpoliticalbusiness_photoData as $img_key => $img_value) {

                $img_data['image_id'] = strval($img_value->id);
                $img_data['image_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                $img_data['image_type'] = strval($img_value->image_type);
                $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) : "";

                array_push($sub_categories_post['images'], $img_data);
            }
            array_push($sub_categories_post_data, $sub_categories_post);
        }

        $onlycat = DB::table('custom_cateogry')->where('type', $request->type)->where('is_active', 1)->whereIn('highlight', array(0, 1, 2, 3))->orderBy('slider_img_position', 'ASC')->get();


        $greetings = array();


        foreach ($onlycat as $value) {
            $temp = array();
            $temp['custom_cateogry_id'] = strval($value->custom_cateogry_id);
            $temp['name'] = !empty($value->name) ? $value->name : "";
            $temp['custom_image'] = !empty($value->slider_img) ? Storage::url($value->slider_img) : "";

            array_push($greetings, $temp);
        }

        $data = [
            'business_photo' => $currntbusiness_photos,
            'sub_categories' => $sub_categories,
            'sub_categories_post' => $sub_categories_post_data,
            'greetings' => $greetings,

        ];
        return response()->json(['status' => true, 'data' => $data, 'message' => 'Search complete']);
    }

    public function getPoliticalLogo(Request $request){

        $logo = PoliticalLogo::orderBy('order_number', 'ASC')->get();
        foreach($logo as $logos)
            {
                $logos->image = Storage::url($logos->image);
            }
        return response()->json(['status' => true,'message' => 'Political Logo List' ,'data' => $logo]);
    }

    public function Test(Request $request){

        $data = Business::leftJoin('purchase_plan','purchase_plan.purc_business_id', '=' ,'business.busi_id')
        ->where('purchase_plan.purc_business_type',1)
        ->whereNull('purchase_plan.purc_user_id')
        ->first();
        return response()->json(['status' => true,'message' => 'Hiii','data'=>$data ]);
    }



}


