<?php

namespace Modules\Userapi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\User;
use App\Business;
use App\Post;
use App\Festival;
use App\Purchase;
use App\Photos;
use App\Plan;
use App\Language;
use App\VideoData;
use DB;
use GDText\Box;
use GDText\Color;
use App\UserDevice;
use App\Helper;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client as GuzzleHttp;
use App\LinkedIn;
use Twitter;
use Illuminate\Support\Facades\File;
// use Atymic\Twitter\Facade\Twitter;
use Facebook\Facebook;
use App\PoliticalCategory;
use App\PoliticalBusiness;
use App\PoliticalBusinessApprovalList;
use App\Popup;
use Carbon\Carbon;

class UserapiControllerV9 extends Controller
{
    public $successStatus = 200;

    public function sendRegisterOTP(Request $request) {
        $input = $request->all();
        $name = $input['name']; 
        $country_code = $input['country_code'];
        $mobile = $input['mobile'];

        $checkUser = User::where('mobile', $mobile)->first();
        if($checkUser) {
            if($checkUser->status == 1) {
                return response()->json(['status'=>false,'message'=>'You were blocked']);
            }
            if($checkUser->is_verified) {
                if($checkUser->country_code == 0) {
                    $checkUser->country_code = $country_code;
                }
                $checkUser->save();
                return response()->json(['status'=>false,'message'=>'Mobile Already Registered']);
            }
            else {
                $otp = rand(100000, 999999);
                $result = $this->sendOTP($country_code, $mobile, $otp);
                if(!$result) {
                    return response()->json(['status'=>false,'message'=>'OTP not sent']);
                }
                $checkUser->name = $name;
                $checkUser->country_code = $country_code;
                $checkUser->mobile = $mobile;
                $checkUser->otp = $otp;
                $checkUser->password = bcrypt($name.'@123');
                $checkUser->save();
                return response()->json(['status'=>true,'message'=>'OTP sent to you mobile']);
            }
        }
        $otp = rand(100000, 999999);
        $result = $this->sendOTP($country_code, $mobile, $otp);
        if(!$result) {
            return response()->json(['status'=>false,'message'=>'OTP not sent']);
        }
        $user = new User;
        $user->name = $name;
        $user->country_code = $country_code;
        $user->mobile = $mobile;
        $user->otp = $otp;
        $user->password = bcrypt($name.'@123');
        $user->save();
        return response()->json(['status'=>true,'message'=>'OTP sent to you mobile']);
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
        if($user){
            if($user->status == 1) {
                return response()->json(['status'=>false,'message'=>'You were blocked']);
            }
            if($user->otp != $otp) {
                return response()->json(['status'=>false,'message'=>'Invalid OTP']);
            }
            $user->password = bcrypt($input['name'].'@123');
            $user->remember_token = $token;
            $user->device_id = $input['device_id'];
            $user->device = $input['device'];
            $user->device_token = $input['device_token'];
            $user->otp = 0;
            $user->is_verified = 1;
            $user->save();

            $newuserid = $user->id;

            Helper::deleteDuplicateDevice($input['device_id']);

            $userdeviceinsert = UserDevice::where('device_id', $input['device_id'])->first();
            if(empty($userdivece)) {
                $userdeviceinsert = new UserDevice;
                $userdeviceinsert->device_id = $input['device_id'];
                $userdeviceinsert->device_type = $input['device'];
            }

            $userdeviceinsert->user_id = $newuserid;
            $userdeviceinsert->remember_token = $token;
            $userdeviceinsert->device_token = $input['device_token'];;
            $userdeviceinsert->save();

            $user = User::find($newuserid);

            $users = array();
            $user_data = array();

            
                $user_data['id'] = strval($user->id);
                $user_data['name'] =!empty($user->name)?$user->name:"";
                $user_data['mobile'] =!empty($user->mobile)?$user->mobile:"";
                $user_data['email'] =!empty($user->email)?$user->email:"";
                $user_data['device'] =!empty($user->device)?$user->device:"";
                array_push($users, $user_data);

            return response()->json(['data' => $users,'token'=> $token, 'status'=>true,'message'=>'Register Successfully']); 

        } else {
            return response()->json(['status'=>false,'message'=>'Invalid Mobile number']); 
        }

    }

    public function sendLoginOTP(Request $request) {
        $input = $request->all();
        $country_code = $input['country_code'];
        $mobile = $input['mobile'];

        $checkUser = User::where('mobile', $mobile)->where('is_verified', 1)->first();
        if(empty($checkUser)) {
            return response()->json(['status'=>false,'message'=>'user not found']); 
        }
        if($checkUser->status == 1) {
            return response()->json(['status'=>false,'message'=>'You were blocked']);
        }
        if($checkUser->country_code == 0) {
            $checkUser->country_code = $country_code;
        }
        if($mobile == '3030303030') {
            $otp = '123456';
        }
        else {
            $otp = rand(100000, 999999);
            $result = $this->sendOTP($country_code, $mobile, $otp);
            if(!$result) {
                return response()->json(['status'=>false,'message'=>'OTP not sent']);
            }
        }
        $checkUser->otp = $otp;
        $checkUser->save();
        return response()->json(['status'=>true,'message'=>'OTP sent to you mobile']);
    }

    public function login(Request $request){ 
         $input = $request->all(); 
         $country_code = $input['country_code'];
         $mobile = $input['mobile'];
         $otp = $input['otp'];
         $user = User::where('mobile','=',$mobile)->where('country_code', $country_code)->where('is_verified', 1)->first();

        if(!empty($user) || $user != ''){
            if($user->status == 0){
                $token = Hash::make($user->email, [
                    'rounds' => 12
                ]);
                if($user->otp != $otp) {
                    return response()->json(['status'=>false,'message'=>'Invalid OTP']);
                }
                $user->otp = 0;
                $user->is_verified = 1;
                // $userdivece = UserDevice::where('user_id',$user->id)
                //                 ->where('device_id',$input['device_id'])
                //                 ->where('device_token',$input['device_token'])
                //                 ->first();

                Helper::deleteDuplicateDevice($input['device_id']);

                $userdeviceinsert = UserDevice::where('device_id',$input['device_id'])->first();

                if(empty($userdeviceinsert) || $userdeviceinsert == '')
                {
                    $userdeviceinsert = new UserDevice;
                    $userdeviceinsert->device_id = $input['device_id'];
                    $userdeviceinsert->device_type = $input['device'];
                }
                $userdeviceinsert->user_id = $user->id;
                $userdeviceinsert->remember_token = $token;
                $userdeviceinsert->device_token = $input['device_token'];
                $userdeviceinsert->save();
                
                $isbusiness = false;
                
                if($user->default_business_id != '' || $user->default_business_id != 0){
                    $isbusiness = true;
                }
                $data = array();
                $users = array();

                $data['id'] = strval($user->id);
                $data['name'] = !empty($user->name)?$user->name:"";
                $data['mobile'] = !empty($user->mobile)?$user->mobile:"";
                $data['email'] = !empty($user->email)?$user->email:"";
                $data['device'] = !empty($input['device'])?$input['device']:"";
                array_push($users, $data);
                $user->save();

                return response()->json(['data' => $users, 'token'=> $token, 'status'=>true,'message'=>'Login Successfully', 'isbusiness' => $isbusiness]); 
            } else if($user->status == 1){
                return response()->json(['status'=>false,'message'=>'You were blocked']); 
            } else {
                return response()->json(['status'=>false,'message'=>'You were removed']); 
            }
          
        } 
        else{ 
            return response()->json(['status'=>false,'message'=>'Mobile number not registered. Please register first']); 
        } 
    }

    public function logout(Request $request){
            $input = $request->all();

            /*User::where('remember_token', $input['token'])->update(array(
                'user_id' => 0,
                'remember_token' => '',
                'device_token' => ''
            ));*/
            $user = UserDevice::where('remember_token', $input['token'])->first();
            if(!empty($user)) {
                $user->delete();
            }

          return response()->json(['status'=>true,'message'=>'Logout Successfully']); 
    }
    
    public function checkMobile(Request $request){
        $input = $request->all(); 

        $user = User::where('mobile', '=', $input['mobile'])->first();
        if(!empty($user)){
             return response()->json(['status'=>false,'message'=>'mobile number already exist']); 
        } else {
            return response()->json(['status'=>true,'message'=>'mobile number not exist']); 
        }
    }
    // ------------------------------------ Profile Apis -------------------------------------------------

    public function editMyProfile(Request $request){
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        } else {
            if ($request['email'] != "") 
            {
                User::where('id', $user_id)->update(array(
                    'name'=>$request['name'],
                   /* 'mobile'=>$request['mobile'],*/
                    'email'=>$request['email'],
                ));
            }
            else
            {
                User::where('id', $user_id)->update(array(
                    'name'=>$request['name'],
                ));
            }

            $data = array();

            $data['name'] =!empty($request['name'])?$request['name']:"" ;
            $data['email'] =!empty($request['email'])?$request['email']:"" ;
            
            return response()->json(['status'=>true,'message'=>'Account Information Successfully Update','data'=>$data]); 

        }
        
    }
    public function getMyProfile(Request $request){

        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        //$userdata = User::where('remember_token','=',$input['token'])->first()->toArray();
        $userdata = User::where('id','=',$user_id)->first()->toArray();

        // foreach ($userdata as $key => $value) {
        //     if ($value == '' || is_null($value)) {
        //          $userdata[$key] = "";
        //          echo $userdata[$key];
        //     }
        // }
        $newdata = array_map(function($v){
            return (is_null($v)) ? "" : $v;
        },$userdata);
        
        // print_r($userdata);die();
       
          if($userdata != null || !empty($userdata) || $userdata != ''){

            return response()->json(['data' => $newdata,'status'=>true,'message'=>'user valid']);

          } else {
            return response()->json(['status'=>false,'message'=>'user not valid']);

          }

    }

    public function get_userid($token){
       /* $userdata = User::where('remember_token','=',$token)->select('id')->first();
        if($userdata != null || !empty($userdata) || $userdata != ''){
            $user_id = $userdata->id;
        } else {
            $user_id = 0;
        }
        return $user_id;*/

        $userdata = UserDevice::where('remember_token','=',$token)->select('user_id')->first();
        if($userdata != null || !empty($userdata) || $userdata != ''){
            $user_id = $userdata->user_id;
            $user = User::where('id', $user_id)->where('status', 0)->first();
            if(empty($user)) {
                $user_id = 0;
            }
        } else {
            $user_id = 0;
        }
        return $user_id;
    }

    // ------------------------------------ Business Apis -------------------------------------------------

    public function addBusiness(Request $request){
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $name = $input['name'];
        $email = $input['email'];
        $mobile = $input['mobile'];
        $mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $website = $input['website'];
        $address = $input['address'];
        $logo = $request->file('logo');
        $watermark = $request->file('watermark');
        $business_category = $input['business_category'];
        $path = '';
        $watermark_path = '';

        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $twitter =  isset($input['twitter']) ? $input['twitter'] : "";
        $instagram =  isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin =  isset($input['linkedin']) ? $input['linkedin'] : "";
        $youtube =  isset($input['youtube']) ? $input['youtube'] : "";

        if($watermark != null){
            $watermark_path  =  $this->uploadFile($request, null,"watermark", 'business-img');
        }
        if($logo != null){
            /*$filename = Str::random(7).time().'.'.$logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $filename);

            $path = url('/').'/public/images/'.$filename;*/
            $path  =  $this->uploadFile($request, null,"logo", 'business-img');
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
            $business->business_category = $business_category;
            $business->busi_facebook = $facebook;
            $business->busi_twitter = $twitter;
            $business->busi_instagram = $instagram;
            $business->busi_linkedin = $linkedin;
            $business->busi_youtube = $youtube;
            $business->save();
            
            $business_id = $business->id;

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
            return response()->json(['status'=>true,'message'=>'Data successfully Added']);
        // } else {
        //     return response()->json(['status'=>false,'message'=>'Some Error']);
        // }

    }
    
    public function getcurrntbusinesspreornot(Request $request){
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $userdata = User::where('id','=',$user_id)->select('default_business_id')->first();
        
        
        $currntbusiness = Business::where('busi_id','=',$userdata->default_business_id)->first();
        
        $ispreminum = false;
        if($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != ''){
              
            $priminum = Purchase::where('purc_business_id','=',$userdata->default_business_id)->where('purc_plan_id','=',2)->first();
            
            
            
            if(!empty($priminum) || $priminum != null || $priminum != ''){
                 $ispreminum = true;
            } else{
                $ispreminum = false;
            }
    
            return response()->json(['data' => $currntbusiness,'status'=>true,'message'=>'data recived', 'premium' => $ispreminum]);

        } else {
            return response()->json(['status'=>false,'message'=>"you havent't set current business yet"]);

        }

        
    }
    
   public function markascurrentbusiness(Request $request){
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        
        $business_id = $input['business_id'];
        
        User::where('id', $user_id)->update(array(
            'default_business_id' => $business_id,
        ));
        $user_data = User::find($user_id);
        $frameList = DB::table('user_frames')->where('user_id','=',$user_id)->where('business_id','=',$user_data->default_business_id)->where('is_deleted','=',0)->orderBy('user_frames_id','DESC')->get();
        
        $frameLists = array();

        foreach ($frameList as $key => $value) 
        {
           $data = array();

           $data['business_id'] = strval($value->business_id);
           $data['date_added'] = !empty($value->date_added)?$value->date_added:"";
           $data['frame_url'] = !empty($value->frame_url)?Storage::url($value->frame_url):"";
           $data['user_frames_id'] = strval($value->user_frames_id);
           $data['user_id'] = strval($value->user_id);

           array_push($frameLists, $data);

        }

        
        $currntbusiness = Business::where('busi_id','=',$user_data->default_business_id)->where('busi_delete','=',0)->first();

        $updatedCurrentBusinessDetails = array();

        $ispreminum = false;
        if($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != ''){
            $priminum = Purchase::where('purc_business_id','=',$user_data->default_business_id)->select('purc_id','purc_plan_id','purc_start_date','purc_end_date')->first();
            
            if(!empty($priminum) || $priminum != null || $priminum != ''){
                $start_dates = date('Y-m-d');
                if($priminum->purc_plan_id == 1){
                    $plantrial = Plan::where('plan_sku','=','000FREESKU')->select('plan_validity')->first();
                    $start_date = strtotime($start_dates); 
                    $end_date = strtotime($priminum->end_date); 
                    $days = ($end_date - $start_date)/60/60/24;
                    if($days > $plantrial->plan_validity && $days > 0){
                        $ispreminum = false;
                    } else {
                        $ispreminum = true;
                    }
                }
                if($priminum->purc_plan_id == 3){
                   
                     $ispreminum = false;
                        
                }
                
                if($priminum->purc_plan_id == 2){
                    $ispreminum = true;
                }
                 
            } else{
                $ispreminum = false;
            }


            $updatedCurrentBusinessDetails['busi_id'] = strval($currntbusiness->busi_id);
            $updatedCurrentBusinessDetails['user_id'] = strval($currntbusiness->user_id);
            $updatedCurrentBusinessDetails['busi_name'] = !empty($currntbusiness->busi_name)?$currntbusiness->busi_name:"";
            $updatedCurrentBusinessDetails['busi_logo'] = !empty($currntbusiness->busi_logo)?Storage::url($currntbusiness->busi_logo):"";
            $updatedCurrentBusinessDetails['busi_mobile'] = !empty($currntbusiness->busi_mobile)?$currntbusiness->busi_mobile:"";
            $updatedCurrentBusinessDetails['busi_mobile_second'] = !empty($currntbusiness->busi_mobile_second)?$currntbusiness->busi_mobile_second:"";
            $updatedCurrentBusinessDetails['busi_email'] = !empty($currntbusiness->busi_email)?$currntbusiness->busi_email:"";
            $updatedCurrentBusinessDetails['busi_address'] = !empty($currntbusiness->busi_address)?$currntbusiness->busi_address:"";
            $updatedCurrentBusinessDetails['busi_website'] = !empty($currntbusiness->busi_website)?$currntbusiness->busi_website:"";
            $updatedCurrentBusinessDetails['business_category'] = !empty($currntbusiness->business_category)?$currntbusiness->business_category:"";
            $updatedCurrentBusinessDetails['busi_is_approved'] = strval($currntbusiness->busi_is_approved);
            $updatedCurrentBusinessDetails['busi_delete'] = strval($currntbusiness->busi_delete);
            $updatedCurrentBusinessDetails['busi_facebook'] = strval($currntbusiness->busi_facebook);
            $updatedCurrentBusinessDetails['busi_twitter'] = strval($currntbusiness->busi_twitter);
            $updatedCurrentBusinessDetails['busi_instagram'] = strval($currntbusiness->busi_instagram);
            $updatedCurrentBusinessDetails['busi_linkedin'] = strval($currntbusiness->busi_linkedin);
            $updatedCurrentBusinessDetails['busi_youtube'] = strval($currntbusiness->busi_youtube);

            $p_plan = Purchase::where('purc_user_id',$user_id)->where('purc_business_id',$user_data->default_business_id)->get();
            $plan_name = "";
            if (count($p_plan) != 0) 
            {
                foreach ($p_plan as $key => $value) 
                {
                    if ($value->purc_is_cencal == 0 && $value->purc_is_expire == 0) 
                    {
                       if ($value->purc_plan_id == 2) 
                       {
                           $plan_name = 'Premium';
                       }
                       elseif ($value->purc_plan_id == 3) 
                       {
                           $plan_name = 'Free';
                       }
                    }
                    else
                    {
                        $plan_name = 'Free';
                    }
                }
            }
            else
            {
                $plan_name = 'Free';
            }

            $updatedCurrentBusinessDetails['plan_name'] = $plan_name;


        } else {
           $currntbusiness = "you havent't set current business yet";

        }



        return response()->json(['status'=>true,'message'=>'Set successfuly','frameList' => $frameLists, 'current_business'=> $updatedCurrentBusinessDetails]);
    }

    public function updateBusiness(Request $request){
        
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $getBusiness = Business::where('busi_id','=',$input['id'])->where('user_id', $user_id)->first();
        if(empty($getBusiness)){
            return response()->json(['status'=>false,'message'=>'Something goes wrong']);
        }
        $id = $input['id'];

        $name = $input['name'];
        $email = $input['email'];
        $mobile = $input['mobile'];
        $website = $input['website'];
        $address = $input['address'];
        $mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $logo = $request->file('logo');
        $watermark = $request->file('watermark');
        $business_category = (isset($input['business_category'])) ? $input['business_category'] : "";
        $currntbusiness = Business::where('busi_id','=',$id)->select('busi_name','busi_logo','watermark_image')->first();
        $watermark_path = '';

        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $twitter =  isset($input['twitter']) ? $input['twitter'] : "";
        $instagram =  isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin =  isset($input['linkedin']) ? $input['linkedin'] : "";
        $youtube =  isset($input['youtube']) ? $input['youtube'] : "";

        if(!is_null($currntbusiness)){
           
            $namechange = false;
            if($currntbusiness->busi_name != $name){
                $namechange = true;
                $name = $input['name'];
            } else {
                $namechange = false;
                $name = $currntbusiness->busi_name;
            }

            if($watermark != null){
                $watermark_path  =  $this->uploadFile($request, null,"watermark", 'business-img');
            } else {
                $watermark_path = $currntbusiness->watermark_image;
            }

            if($logo != null){
               /* $filename = Str::random(7).time().'.'.$logo->getClientOriginalExtension();
                $logo->move(public_path('images'), $filename);
                $path = url('/').'/public/images/'.$filename;*/
                $path  =  $this->uploadFile($request, null,"logo", 'business-img');
            } else {
                $path = $currntbusiness->busi_logo;
            }
            // if(($logo != null && $namechange) || ($logo != null && !$namechange) || $namechange){
            if($namechange){

                    
                Business::where('busi_id', $id)->update(array(
                    'busi_is_approved' => 0
                ));
                
                $_isBusinessAvail = DB::table('business_new')->where('busi_id_old','=', $id)->select('user_id_new')->first();
                $_isPremiumUser = DB::table('purchase_plan')->where('purc_business_type', 1)->where('purc_business_id','=', $id)->where('purc_plan_id','!=',3)->first();

                if(!empty($_isPremiumUser) || $_isPremiumUser != '' || $_isPremiumUser != null){

                    if(is_null($_isBusinessAvail)){
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
                            'busi_logo' => $path,
                            'busi_website' => $website,
                            'busi_mobile' => $mobile,
                            'busi_mobile_second' => $mobile_second,
                            'busi_address' => $address,
                            'business_category' => $business_category,
                            'watermark_image' => $watermark_path,
                            'busi_facebook' => $facebook,
                            'busi_twitter' => $twitter,
                            'busi_instagram' => $instagram,
                            'busi_linkedin' => $linkedin,
                            'busi_youtube' => $youtube,

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
                            'watermark_image' => $watermark_path,
                            'busi_facebook' => $facebook,
                            'busi_twitter' => $twitter,
                            'busi_instagram' => $instagram,
                            'busi_linkedin' => $linkedin,
                            'busi_youtube' => $youtube,
                            'busi_logo' => $path,

                        ));
                    }
                
                    return response()->json(['status'=>true,'message'=>'Please wait till admin approves your changes!']);
                } else {
                    Business::where('busi_id', $id)->update(array(
                        'busi_name' => $name,
                        'busi_email' => $email,
                        'user_id' => $user_id,
                        'busi_website' => $website,
                        'busi_logo' => $path,
                        'busi_mobile' => $mobile,
                        'busi_mobile_second' => $mobile_second,
                        'busi_address' => $address,
                        'business_category' => $business_category,
                        'watermark_image' => $watermark_path,
                        'busi_facebook' => $facebook,
                        'busi_twitter' => $twitter,
                        'busi_instagram' => $instagram,
                        'busi_linkedin' => $linkedin,
                        'busi_youtube' => $youtube,

                    ));
                    return response()->json(['status'=>true,'message'=>'Business Information Update']);
                }

            } else {
                Business::where('busi_id', $id)->update(array(
                    'busi_email' => $email,
                    'user_id' => $user_id,
                    'busi_logo' => $path,
                    'busi_website' => $website,
                    'busi_mobile' => $mobile,
                    'busi_mobile_second' => $mobile_second,
                    'busi_address' => $address,
                    'business_category' => $business_category,
                    'watermark_image' => $watermark_path,
                    'busi_facebook' => $facebook,
                    'busi_twitter' => $twitter,
                    'busi_instagram' => $instagram,
                    'busi_linkedin' => $linkedin,
                    'busi_youtube' => $youtube,

                ));

                return response()->json(['status'=>true,'message'=>'Business Information Update']);

            }
        } else{
             return response()->json(['status'=>false,'message'=>'Record not Found']);
        }
        
    }


    public function getmyallbusiness(Request $request){

        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $user = User::where('id',$user_id)->first();

        // $listofbusiness = Business::where('user_id','=',$user_id)->where('busi_delete','=',0)->get();
        $listofbusiness = DB::table('business')->where('business.user_id','=',$user_id)->where('business.busi_delete','=',0)->leftJoin('purchase_plan','business.busi_id','=','purchase_plan.purc_business_id')->leftJoin('plan','purchase_plan.purc_plan_id',
            '=','plan.plan_id')->select('business.busi_id','business.busi_name','business.business_category','business.busi_email','business.busi_address','business.busi_mobile', 'business.busi_mobile_second','business.busi_logo','business.watermark_image','business.busi_website','plan.plan_name','plan.plan_id','purchase_plan.purc_start_date','purchase_plan.purc_end_date','purchase_plan.purc_plan_id','business.watermark_image','business.busi_facebook','business.busi_instagram','business.busi_twitter','business.busi_linkedin','business.busi_youtube','purchase_plan.purc_is_expire')->distinct()->get()->toArray();
        
        // print_r($listofbusiness);die();
        $listofbusiness = array_map(function ($value) {
            return (array)$value;
        }, $listofbusiness);
        
        // echo count($listofbusiness);
        $finalarr = array();
        for ($i = 0; $i < count($listofbusiness); $i++) {
        //     for ($j = 0; $j < count($listofbusiness[$i]); $j++) {
               
                $newdata = array_map(function($v){
                    return (is_null($v)) ? "" : $v;
                },$listofbusiness[$i]);
                // print_r($listofbusiness[$i]);
                
                array_push($finalarr,$newdata);
        //     }
        }
        
        $finale_array = array();
        $start_dates = date('Y-m-d');
        foreach($finalarr as $business){
            // Update Business s3 url
            if(!empty($business['busi_logo'])){
                $business['busi_logo'] = Storage::url($business['busi_logo']);
            }
            if(!empty($business['watermark_image'])){
                $business['watermark_image'] = Storage::url($business['watermark_image']);
            }

            if($business['plan_id'] == 1 || $business['plan_id'] == 3 ){
                $business['need_to_upgrade'] = 1;
            } else {
                $business['need_to_upgrade'] = 0;
            }

            if ($business['busi_id'] == $user->default_business_id) 
            {
                $val_busi = 1;
               $business['is_current_business'] = strval($val_busi);
            }
            else
            {
                $val_busi = 0;
               $business['is_current_business'] = strval($val_busi);
            }

            if($business['purc_plan_id'] != 3 || $business['purc_plan_id'] != "3"){
                $plantrial = Plan::where('plan_sku','=','Free')->select('plan_validity')->first();
                $start_date = strtotime($business['purc_start_date']);
                $end_date = strtotime($business['purc_end_date']);
                $today = strtotime(date('Y-m-d'));
                if($today > $end_date && ($business['purc_is_expire'] == 1 || $business['purc_is_expire'] == "1")){
                    $business['remaining_days'] = '0 Days';
                } else {
                    $days = ($end_date - $today)/60/60/24;
                    $business['remaining_days'] = $days. ' Days';
                }

            } else {
                $business['remaining_days'] = '0 Days';
            }
           
        

             //print_r($business);
            array_push($finale_array,$business);
            // echo $business['plan_id'];
            // die;
        }
        
        return response()->json(['data' => $finale_array,'status' => true,'message'=>'List of all business']);

    }

    public function removeMyBusiness(Request $request){

        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $getbusiness = Business::where('busi_id', $input['id'])->where('user_id', $user_id)->first();
        if(empty($getbusiness)){
            return response()->json(['status'=>false,'message'=>'Something goes wrong']);
        }
        $userdata = User::where('id','=',$user_id)->select('default_business_id')->first();
        
        if($userdata->default_business_id != $input['id']){

            Business::where('busi_id', $input['id'])->update(array(
                'busi_delete' => 1,
            ));
            Photos::where('photo_business_id', $input['id'])->update(array(
                'photo_is_delete' => 1,
            ));

            // $currntbusiness = Business::where('user_id','=',$user_id)->where('busi_delete','=',0)->select('busi_id')->first();
            
            // if(!empty($currntbusiness) || !is_null($currntbusiness)){
            //     User::where('id', $user_id)->update(array(
            //         'default_business_id' => $currntbusiness->busi_id,
            //     ));
            // } else {
                /*User::where('id', $user_id)->update(array(
                    'default_business_id' => 0,
                ));*/
            // }
            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        } else {
            
            Business::where('busi_id', $input['id'])->update(array(
                'busi_delete' => 1,
            ));
            Photos::where('photo_business_id', $input['id'])->update(array(
                'photo_is_delete' => 1,
            ));

            $currntbusiness = Business::where('user_id','=',$user_id)->where('busi_delete','=',0)->select('busi_id')->first();
            
            if(!empty($currntbusiness) || !is_null($currntbusiness)){
                User::where('id', $user_id)->update(array(
                    'default_business_id' => $currntbusiness->busi_id,
                ));
            } else {
                User::where('id', $user_id)->update(array(
                    'default_business_id' => 0,
                ));
            }
            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        }
        
        //DB::delete('delete from photos where photo_business_id = ?',$input['id']);

    }

    // ------------------------------------ Homepage Apis -------------------------------------------------


    public function getthisMonthsFestival(Request $request){

        $date = date('Y-m');

        $currnt_date = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime($currnt_date .' -1 day'));
        $next_date = date('Y-m-d', strtotime($currnt_date .' +1 day'));

    
        // $slider = Festival::where('fest_date', '=', $currnt_date)->orWhere('fest_date', '=', $prev_date)->orWhere('fest_date', '=', $next_date)->where('fest_type','=','festival')->where('fest_is_delete','=',0)->limit(3)->get();
        $slider = Festival::whereDate('fest_date', '>=', $currnt_date)->where('fest_type','festival')->where('fest_is_delete',0)->orderBy('fest_date','asc')->get();

        for ($i=0; $i < sizeof($slider); $i++) { 
            if($slider[$i]['fest_date'] == $currnt_date){
                $slider[$i]['current_date'] = true;
            } else {
                $slider[$i]['current_date'] = false;
            }
            $slider[$i]['fest_day'] = date_parse_from_format('Y-m-d', $slider[$i]['fest_date'])['day'];
            $slider[$i]['fest_date'] = date("d-m-Y", strtotime($slider[$i]['fest_date']));
        }

        $festivals = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get();

        for ($i=0; $i < sizeof($festivals); $i++) { 
            $festivals[$i]['fest_day'] = date_parse_from_format('Y-m-d', $festivals[$i]['fest_date'])['day'];
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
        }

        $incedents = Festival::where('fest_type','=','incident')->where('fest_is_delete','=',0)->get();
        $incedentsArray = array();
        for ($i=0; $i < sizeof($incedents); $i++) { 
            $incedents[$i]['fest_day'] = date_parse_from_format('Y-m-d', $incedents[$i]['fest_date'])['day'];
            $photo = Post::where('post_category_id','=',$incedents[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','post_category_id')->orderBy('post_id','DESC')->get();
            $temp['title'] = $incedents[$i]['fest_name'];
            $temp['img_url'] = $photo;
            $temp['information'] = $incedents[$i]['fest_info'];
            $temp['fest_image'] = $incedents[$i]['fest_image'];
            $temp['fest_id'] = $incedents[$i]['fest_id'];
            array_push($incedentsArray,$temp);
        }
        
            // ----------------------------- Get current business
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $userdata = User::where('id','=',$user_id)->select('default_business_id')->first();
        
        $currntbusiness = Business::where('busi_id','=',$userdata->default_business_id)->where('busi_delete','=',0)->first();

        $updatedCurrentBusinessDetails = array();
        $preference = DB::table('user_preference')->where('user_id', '=', $user_id)->get();

        $ispreminum = false;
        if($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != ''){
            // ->where('purc_plan_id','=',2)->orWhere('purc_plan_id','=',1)
            $priminum = Purchase::where('purc_business_id','=',$userdata->default_business_id)->select('purc_id','purc_plan_id','purc_start_date','purc_end_date')->first();
            
            if(!empty($priminum) || $priminum != null || $priminum != ''){
                $start_dates = date('Y-m-d');
                if($priminum->purc_plan_id == 1){
                    $plantrial = Plan::where('plan_sku','=','000FREESKU')->select('plan_validity')->first();
                    $start_date = strtotime($start_dates); 
                    $end_date = strtotime($priminum->end_date); 
                    $days = ($end_date - $start_date)/60/60/24;
                    if($days > $plantrial->plan_validity && $days > 0){
                        $ispreminum = false;
                    } else {
                        $ispreminum = true;
                    }
                }
                if($priminum->purc_plan_id == 3){
                    // $plantrial = Plan::where('plan_sku','=','premium_2599')->select('plan_validity')->first();
                    // $start_date = strtotime($start_dates); 
                    // $end_date = strtotime($priminum->end_date); 
                    // $days = ($end_date - $start_date)/60/60/24;
                    // if($days > $plantrial->plan_validity && $days > 0){
                        $ispreminum = false;
                        // Purchase::where('purc_id',$priminum->purc_id)->update([
                        //     'purc_is_cencal'=>1,
                        // ]);
                }
                
                if($priminum->purc_plan_id == 2){
                    $ispreminum = true;
                }
                 
            } else{
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
            if(!empty($currntbusiness['watermark_image'])){
                $updatedCurrentBusinessDetails['watermark_image'] = Storage::url($currntbusiness['watermark_image']);
            }

            if(!empty($preference)){
                
                foreach ($preference as $value) {
                    if($value->preference_value == 1){
                        // $currntbusiness->bus_logo = '';
                        $updatedCurrentBusinessDetails['busi_logo'] = '';
                    }
                    if($value->preference_value == 2){
                        // $currntbusiness->bus_mobile = '';
                        $updatedCurrentBusinessDetails['busi_mobile'] = '';
                    }
                    if($value->preference_value == 3){
                        // $currntbusiness->bus_email = '';
                        $updatedCurrentBusinessDetails['busi_email'] = '';
                    }
                    if($value->preference_value == 4){
                        // $currntbusiness->bus_address = '';
                        $updatedCurrentBusinessDetails['busi_address'] = '';
                    }
                    if($value->preference_value == 5){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_website'] = '';
                    }
                    if($value->preference_value == 6){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_name'] = '';
                    }

                }
            }

        } else {
           $currntbusiness = "you havent't set current business yet";

        }
        
        $userstatus = User::where('remember_token','=',$input['token'])->select('status')->first();
        
        $logout = false;
        
        if($userstatus->status == 1 || $userstatus->status == 2){
            $logout = true;
        }

        $frameList = DB::table('user_frames')->where('user_id','=',$user_id)->where('business_id','=',$userdata->default_business_id)->where('is_deleted','=',0)->orderBy('user_frames_id','DESC')->get();

        if(!empty($frameList)){
            foreach ($frameList as &$frame) {
                $frame->frame_url = Storage::url($frame->frame_url);
            }
        }

        $sharemsg = '';
        $credit = DB::table('setting')->where('setting_id','=',1)->select('whatsapp')->first();
        if($credit->whatsapp == '' || is_null($credit->whatsapp)){
            $sharemsg = '';
        } else {
            $sharemsg = $credit->whatsapp;
        }
        if(!empty($festivals) || !empty($incedents)){
            return response()->json(['slider' => $slider, 'festival' => $festivals, 'incidents' => $incedentsArray,'status' => true,'message'=>'List of all festival','current_business'=>$updatedCurrentBusinessDetails,'premium' => $ispreminum,'current_date' => $currnt_date, 'logout' => $logout,'frameList' => $frameList, 'preference' => $preference,'share_message' => $sharemsg,'current_business_new' => $currntbusiness]);
        } else {
            return response()->json(['status' => fasle,'message'=>'There is no festival in this month','current_date' => $currnt_date]);

        }
    }
    public function getHomePage(Request $request)
    {
        $user_language_check = false;
        $date = date('Y-m');

        $currnt_date = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime($currnt_date .' -1 day'));
        $next_date = date('Y-m-d', strtotime($currnt_date .' +1 day'));

    
        
        /*$slider = Festival::whereDate('fest_date', '>=', $currnt_date)->where('fest_type','festival')->where('fest_is_delete',0)->orderBy('fest_date','asc')->get();

        $sliders = array();
        $data = array();
        for ($i=0; $i < sizeof($slider); $i++) { 
            if($slider[$i]['fest_date'] == $currnt_date){
                $slider[$i]['current_date'] = "true";
            } else {
                $slider[$i]['current_date'] = "false";
            }
            $slider[$i]['fest_day'] = date_parse_from_format('Y-m-d', $slider[$i]['fest_date'])['day'];
            $slider[$i]['fest_date'] = date("d-m-Y", strtotime($slider[$i]['fest_date']));

            $data['fest_id'] = strval($slider[$i]['fest_id']);
            $data['fest_name'] = !empty($slider[$i]['fest_name'])?$slider[$i]['fest_name']:"";
            $data['fest_info'] = !empty($slider[$i]['fest_info'])?$slider[$i]['fest_info']:"";
            $data['fest_image'] = !empty($slider[$i]['fest_image'])?$slider[$i]['fest_image']:"";
            $data['fest_type'] = !empty($slider[$i]['fest_type'])?$slider[$i]['fest_type']:"";
            $data['fest_date'] = $slider[$i]['fest_date'];
            $data['current_date'] = $slider[$i]['current_date'];
            $data['fest_day'] = strval($slider[$i]['fest_day']);
            $data['fest_is_delete'] = strval($slider[$i]['fest_is_delete']);

            array_push($sliders, $data);
            
        }
            */
        $adv_datas = DB::table('advetisement')->where('is_delete','=',0)->get();
        $advetisement = array();

        foreach ($adv_datas as $key => $value) 
        {
            $data = array();
            $data['id'] = strval($value->id);
            $data['adv_image'] = !empty($value->adv_image)?Storage::url($value->adv_image):"";
            $data['adv_number'] = !empty($value->adv_number)?$value->adv_number:"";
            $data['adv_link'] = !empty($value->adv_link)?$value->adv_link:"";

            array_push($advetisement, $data);
        }

        //$festivals = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get();
         $festivals = Festival::whereDate('fest_date', '>=', $currnt_date)->where('fest_type','festival')->where('fest_is_delete',0)->orderBy('fest_date','asc')->offset(0)->limit(10)->get();
        $festival = array();
        $data_festival = array();
        for ($i=0; $i < sizeof($festivals); $i++) { 
            $festivals[$i]['fest_day'] = date_parse_from_format('Y-m-d', $festivals[$i]['fest_date'])['day'];
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
            $data_festival['fest_id'] = strval($festivals[$i]['fest_id']);
            $data_festival['fest_name'] = !empty($festivals[$i]['fest_name'])?$festivals[$i]['fest_name']:"";
            $data_festival['fest_info'] = !empty($festivals[$i]['fest_info'])?$festivals[$i]['fest_info']:"";
            $data_festival['fest_image'] = !empty($festivals[$i]['fest_image'])?Storage::url($festivals[$i]['fest_image']):"";
            $data_festival['fest_type'] = !empty($festivals[$i]['fest_type'])?$festivals[$i]['fest_type']:"";
            $data_festival['fest_date'] = $festivals[$i]['fest_date'];
            $data_festival['fest_day'] = strval($festivals[$i]['fest_day']);
            $data_festival['fest_is_delete'] = strval($festivals[$i]['fest_is_delete']);

            array_push($festival, $data_festival);

        }

        $incedents = Festival::where('fest_type','=','incident')->where('fest_is_delete','=',0)->where('new_cat',0)->orderBy('position_no','ASC')->get();

        $incedent = array();
        $data_incedent = array();
        for ($i=0; $i < sizeof($incedents); $i++) { 
            $incedents[$i]['fest_day'] = date_parse_from_format('Y-m-d', $incedents[$i]['fest_date'])['day'];
            
            $incedents[$i]['fest_date'] = date("d-m-Y", strtotime($incedents[$i]['fest_date']));
            $data_incedent['fest_id'] = strval($incedents[$i]['fest_id']);
            $data_incedent['fest_name'] = !empty($incedents[$i]['fest_name'])?$incedents[$i]['fest_name']:"";
            $data_incedent['fest_info'] = !empty($incedents[$i]['fest_info'])?$incedents[$i]['fest_info']:"";
            $data_incedent['fest_image'] = !empty($incedents[$i]['fest_image'])?Storage::url($incedents[$i]['fest_image']):"";
            $data_incedent['fest_type'] = !empty($incedents[$i]['fest_type'])?$incedents[$i]['fest_type']:"";
            $data_incedent['fest_date'] = $incedents[$i]['fest_date'];
            $data_incedent['fest_day'] = strval($incedents[$i]['fest_day']);
            $data_incedent['fest_is_delete'] = strval($incedents[$i]['fest_is_delete']);

            array_push($incedent, $data_incedent);
        }

        
        
            // ----------------------------- Get current business
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $userdata = User::where('id','=',$user_id)->select(['default_business_id','user_language','default_political_business_id'])->first();
        $user_language_check = $userdata->user_language!=NULL ? true : false;
        $currntbusiness = Business::where('busi_id','=',$userdata->default_business_id)->where('busi_delete','=',0)->first();

        $updatedCurrentBusinessDetails = array();
        $preference = DB::table('user_preference')->where('user_id', '=', $user_id)->get();

        $ispreminum = false;
        if($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != ''){
            $priminum = Purchase::where('purc_business_id','=',$userdata->default_business_id)->select('purc_id','purc_plan_id','purc_start_date','purc_end_date')->first();
            
            if(!empty($priminum) || $priminum != null || $priminum != ''){
                $start_dates = date('Y-m-d');
                if($priminum->purc_plan_id == 1){
                    $plantrial = Plan::where('plan_id','=',$priminum->purc_plan_id)->select('plan_validity')->first();
                    $start_date = strtotime($start_dates); 
                    $end_date = strtotime($priminum->end_date); 
                    $days = ($end_date - $start_date)/60/60/24;
                    if($days > $plantrial->plan_validity && $days > 0){
                        $ispreminum = false;
                        // Purchase::where('purc_id',$priminum->purc_plan_id)->update(array(
                        //     'purc_is_expire' => 1,
                        // ));
                    } else {
                        $ispreminum = true;
                    }
                }
                if($priminum->purc_plan_id == 3){
                   
                     $ispreminum = false;
                        
                }
                else
                {
                    $ispreminum = true;
                }
                
                /*if($priminum->purc_plan_id == 2){
                    $ispreminum = true;
                }*/
                 
            } else{
                $ispreminum = false;
            }

            
                
                $updatedCurrentBusinessDetails['busi_id'] = strval($currntbusiness->busi_id);
                $updatedCurrentBusinessDetails['user_id'] = strval($currntbusiness->user_id);
                $updatedCurrentBusinessDetails['busi_name'] = !empty($currntbusiness->busi_name)?$currntbusiness->busi_name:"";
                $updatedCurrentBusinessDetails['busi_logo'] = !empty($currntbusiness->busi_logo)?Storage::url($currntbusiness->busi_logo):"";
                $updatedCurrentBusinessDetails['busi_mobile'] = !empty($currntbusiness->busi_mobile)?$currntbusiness->busi_mobile:"";
                $updatedCurrentBusinessDetails['busi_mobile_second'] = !empty($currntbusiness->busi_mobile_second)?$currntbusiness->busi_mobile_second:"";
                $updatedCurrentBusinessDetails['busi_email'] = !empty($currntbusiness->busi_email)?$currntbusiness->busi_email:"";
                $updatedCurrentBusinessDetails['busi_address'] = !empty($currntbusiness->busi_address)?$currntbusiness->busi_address:"";
                $updatedCurrentBusinessDetails['busi_website'] = !empty($currntbusiness->busi_website)?$currntbusiness->busi_website:"";
                $updatedCurrentBusinessDetails['business_category'] = !empty($currntbusiness->business_category)?$currntbusiness->business_category:"";
                $updatedCurrentBusinessDetails['busi_is_approved'] = strval($currntbusiness->busi_is_approved);
                $updatedCurrentBusinessDetails['busi_delete'] = strval($currntbusiness->busi_delete);
                $updatedCurrentBusinessDetails['busi_facebook'] = strval($currntbusiness->busi_facebook);
                $updatedCurrentBusinessDetails['busi_twitter'] = strval($currntbusiness->busi_twitter);
                $updatedCurrentBusinessDetails['busi_instagram'] = strval($currntbusiness->busi_instagram);
                $updatedCurrentBusinessDetails['busi_linkedin'] = strval($currntbusiness->busi_linkedin);
                $updatedCurrentBusinessDetails['busi_youtube'] = strval($currntbusiness->busi_youtube);
                $updatedCurrentBusinessDetails['watermark_image'] = ($currntbusiness->watermark_image) ? Storage::url(strval($currntbusiness->watermark_image)) : '';

                $p_plan = Purchase::where('purc_user_id',$user_id)->where('purc_business_id',$userdata->default_business_id)->get();
                $plan_name = "";
                if (count($p_plan) != 0 && !empty($p_plan) && $p_plan != "") 
                {
                    foreach ($p_plan as $key => $value) 
                    {
                        if ($value->purc_is_cencal == 0 && $value->purc_is_expire == 0) 
                        {
              
                          /* if ($value->purc_plan_id == 2) 
                           {
                               $plan_name = 'Premium';
                           }
                           elseif ($value->purc_plan_id == 3) 
                           {
                               $plan_name = 'Free';
                           }*/
                           $plan_names = Plan::where('plan_id',$value->purc_plan_id)
                                        ->select('plan_name')
                                        ->first();
                                        //dd($plan_names);
                            if(!empty($plan_names))
                            {
                                $plan_name = $plan_names->plan_name;
                                $cur_status = 1;
                            }
                            else
                            {
                                $plan_name = 'Free';
                                $cur_status = 0;
                            }
                           
                        }
                        else
                        {
                            $plan_name = 'Free';
                            $cur_status = 0;
                        }
                    }
                }
                else
                {
                    $plan_name = 'Free';
                    $cur_status = 0;
                }

                $updatedCurrentBusinessDetails['plan_name'] = $plan_name;
                $cur_status = 1;
                $updatedCurrentBusinessDetails['status'] = strval($cur_status);
           

            /*if(!empty($preference)){
                
                foreach ($preference as $value) {
                    if($value->preference_value == 1){
                        // $currntbusiness->bus_logo = '';
                        $updatedCurrentBusinessDetails['busi_logo'] = '';
                    }
                    if($value->preference_value == 2){
                        // $currntbusiness->bus_mobile = '';
                        $updatedCurrentBusinessDetails['busi_mobile'] = '';
                    }
                    if($value->preference_value == 3){
                        // $currntbusiness->bus_email = '';
                        $updatedCurrentBusinessDetails['busi_email'] = '';
                    }
                    if($value->preference_value == 4){
                        // $currntbusiness->bus_address = '';
                        $updatedCurrentBusinessDetails['busi_address'] = '';
                    }
                    if($value->preference_value == 5){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_website'] = '';
                    }
                    if($value->preference_value == 6){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_name'] = '';
                    }

                }
            }*/

        } else {
           //$currntbusiness = "you havent't set current business yet";
           $cur_status = 0;
            $updatedCurrentBusinessDetails['status'] = strval($cur_status);

        }
        
        //$userstatus = User::where('remember_token','=',$input['token'])->select('status')->first();
        $userstatus = User::where('id','=',$user_id)->select('status')->first();;
        
        $logout = false;
        
        if($userstatus->status == 1 || $userstatus->status == 2){
            $logout = true;
        }

        // $frameList = DB::table('user_frames')->where('user_id','=',$user_id)->where('business_id','=',$userdata->default_business_id)->where('is_deleted','=',0)->orderBy('user_frames_id','DESC')->get();

        $frameList = DB::table('user_frames')->where('user_id','=',$user_id)->where(function ($query) use($userdata) {
            $query->where('business_id', '=', $userdata->default_business_id)
                  ->orWhere('business_id', '=', $userdata->default_political_business_id);
        })->where('is_deleted','=',0)->orderBy('user_frames_id','DESC')->get();
        
       

        if(!empty($frameList)){
            foreach ($frameList as &$frame) {
                $frame->frame_url = Storage::url($frame->frame_url);
            }
        }

        $sharemsg = '';
        $credit = DB::table('setting')->where('setting_id','=',1)->select('whatsapp')->first();
        if($credit->whatsapp == '' || is_null($credit->whatsapp)){
            $sharemsg = '';
        } else {
            $sharemsg = $credit->whatsapp;
        }
        $category_data = DB::table('business_category')->where('is_delete','=',0)->limit(10)->get();

        $category = array();

        $keyval = 0;
        foreach ($category_data as $key => $value) 
        {
            $data = array();    
            $data['id'] = strval($value->id);
            $data['category_name'] = !empty($value->name)?$value->name:"";
            $data['image'] = !empty($value->image)? Storage::url($value->image):"";
            array_push($category,$data);
            if(!empty($currntbusiness))
            {
                if($value->name == $currntbusiness->business_category)
                {
                    $keyval = $key;
                }
            }
            
            
        }

        $buss_category = $this->moveElement($category,$keyval,0);
        $currntbusiness_photos = array();
        if (!empty($currntbusiness)) 
        {
           
        
            $currntbusiness_photo_id = DB::table('business_category')->where('name', $currntbusiness->business_category)->where('is_delete',0)->first();

            if(!empty($currntbusiness_photo_id))
            {
                $currntbusiness_photo = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$currntbusiness_photo_id->id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->limit(10)->get();
                /* ->orderBy('id','DESC') ->inRandomOrder()*/
                if(!empty($currntbusiness))
                {
                   $currntbusiness_photos['id'] =  $currntbusiness_photo_id->id;
                   $currntbusiness_photos['cat_name'] =  $currntbusiness->business_category;
                   $currntbusiness_photos['images'] =  [];

                    /*foreach ($currntbusiness_photo as $key => $value) 
                    {
                       $data = array();
                       $data['url'] = $value;

                       array_push($currntbusiness_photos['images'] , $data);
                    }*/
                    foreach ($currntbusiness_photo as $img_key => $img_value) 
                    {
                
                        $img_data['image_id'] = strval($img_value->id);
                        //$img_data['image_url'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) :"";
                        $img_data['image_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                        $img_data['image_type'] = strval($img_value->image_type);
                        $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) :"";

                        array_push( $currntbusiness_photos['images'], $img_data);
                    }
                }
            }
            
        }
        

        


        $new_category_data = Festival::where('fest_type','=','incident')->where('fest_is_delete','=',0)->where('new_cat','!=',0)->orderBy('position_no','ASC')->get();
        $new_category_dataArray = array();
        $user_language = User::where('id',$user_id)->value('user_language');
        for ($i=0; $i < sizeof($new_category_data); $i++) { 
           
            if($new_category_data[$i]['new_cat'] == 1)
            {
                $checkFestival = Festival::where('fest_id', $new_category_data[$i]['fest_id'])->first();
                if($checkFestival->fest_name == "Trending") {
                    $photo = Post::where('post_category_id','=',$new_category_data[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','image_type','post_category_id')->orderBy('image_type','ASC')->orderBy('post_id','DESC')->limit(10)->get();
                }
                else {
                    $photo = Post::where('post_category_id','=',$new_category_data[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','image_type','post_category_id')->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('post_id','DESC')->limit(10)->get();
                }
            }
            else
            {
                $checkFestival = Festival::where('fest_id', $new_category_data[$i]['fest_id'])->first();
                if($checkFestival->fest_name == "Trending") {
                    $photo = Post::where('post_category_id','=',$new_category_data[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','image_type','post_category_id')->orderBy('image_type','ASC')->orderBy('post_id','DESC')->limit(10)->get();
                }
                else {
                    $photo = Post::where('post_category_id','=',$new_category_data[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','image_type','post_category_id')->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('post_id','DESC')->limit(10)->get();
                }
                /* ->orderBy('post_id','DESC') ->inRandomOrder()*/
            }
            $temp['id'] = $new_category_data[$i]['fest_id'];
            $temp['title'] = $new_category_data[$i]['fest_name'];
            $temp['type'] = $new_category_data[$i]['new_cat'];

            $temp['img_url'] = array();
            foreach($photo as $ph_value)
            {
                //$data_ph['post_content'] = !empty($ph_value->post_content) ? Storage::url($ph_value->post_content) :"";
                $data_ph['post_content'] = !empty($ph_value->post_thumb) ? Storage::url($ph_value->post_thumb) : Storage::url($ph_value->post_content);
                $data_ph['post_id'] = !empty($ph_value->post_id) ? strval($ph_value->post_id) :0;
                $data_ph['image_type'] = !empty($ph_value->image_type) ? strval($ph_value->image_type) :0;
                $data_ph['post_category_id'] = !empty($ph_value->post_category_id) ? strval($ph_value->post_category_id) :0;
                array_push($temp['img_url'],$data_ph);
            }
            
            array_push($new_category_dataArray,$temp);
        }

        $new_category_data_greetings = DB::table('custom_cateogry')->whereIn('highlight',array(1,3))->orderBy('slider_img_position','ASC')->get();
        $new_category_data_greetingsArray = array();
        foreach ($new_category_data_greetings as $greeting) {

            $photo = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$greeting->custom_cateogry_id)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderBy('custom_cateogry_data_id','DESC')->limit(10)->get();
            
            $temp1['id'] = $greeting->custom_cateogry_id;
            $temp1['title'] = $greeting->name;
            // $temp1['type'] = $greeting[$i]['new_cat'];

            $temp1['img_url'] = array();
            foreach($photo as $ph_value)
            {
                $data_ph1['custom_cateogry_id'] = !empty($ph_value->custom_cateogry_id) ? strval($ph_value->custom_cateogry_id) :0;
                $data_ph1['banner_image'] = !empty($ph_value->banner_image) ?Storage::url($ph_value->banner_image) : "";
                $data_ph1['image'] = !empty($ph_value->image_one) ?Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['image_one'] = !empty($ph_value->image_one) ?Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['position_x'] = $ph_value->position_x;
                $data_ph1['images']['position_y'] = $ph_value->position_y;
                $data_ph1['images']['img_position_x'] = $ph_value->img_position_x;
                $data_ph1['images']['img_position_y'] = $ph_value->img_position_y;
                $data_ph1['images']['img_height'] = $ph_value->img_height;
                $data_ph1['images']['img_width'] = $ph_value->img_width;
                array_push($temp1['img_url'],$data_ph1);
            }
            
            array_push($new_category_data_greetingsArray,$temp1);
        }

        /*$is_mark_data = Festival::where('fest_type','=','incident')->where('fest_is_delete','=',0)->where('is_mark',1)->get();
        $is_mark_dataArray = array();
        for ($i=0; $i < sizeof($is_mark_data); $i++) { 
           
            $photo = Post::where('post_category_id','=',$is_mark_data[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','image_type','post_category_id')->orderBy('post_id','DESC')->get();
            $is_mark_temp['id'] = $is_mark_data[$i]['fest_id'];
            $is_mark_temp['title'] = $is_mark_data[$i]['fest_name'];
            $is_mark_temp['img_url'] = $photo;
            
            array_push($is_mark_dataArray,$is_mark_temp);
        }*/
        

        /*$cateogry_data = DB::table('custom_cateogry')->get();
        $cateogry = array();

        foreach ($cateogry_data as $key => $value) 
        {
            $data['id'] = $value->custom_cateogry_id;
            $data['cateogry_name'] = $value->name;
            $data['cateogry_image'] = url('/'). $value->slider_img;
            array_push($cateogry, $data);
        }*/

        $politicalCurrentBusinessDetails = $this->getPoliticalCurrentBusiness($userdata->default_political_business_id, $user_id);
        $retrunData;
        if($politicalCurrentBusinessDetails[0]){
            $retrunData = $politicalCurrentBusinessDetails[0];
        } else {
            $retrunData = (object)[];
        }

        if(!empty($festivals) || !empty($incedents)){
            return response()->json(['slider' => $advetisement, 'festival' => $festival,'cateogry'=>$incedent, 'business_category'=>$buss_category,'current_business'=>$updatedCurrentBusinessDetails,'premium' => $ispreminum,'current_date' => $currnt_date, 'logout' => $logout,'frameList' => $frameList,'share_message' => $sharemsg ,'currntbusiness_photos' => (object)$currntbusiness_photos,'new_category' => $new_category_dataArray, 'greetings' => $new_category_data_greetingsArray, 'status' => true,'user_language'=>$user_language_check,'message'=>'List of all festival','politicalCurrentBusinessDetails' => $retrunData,'isPoliticalPrimium'=>$politicalCurrentBusinessDetails[1]]);
        } else {
            return response()->json(['status' => fasle,'message'=>'There is no festival in this month','current_date' => $currnt_date]);

        }
    }

    public function getMonthsPost(Request $request){

         $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
         $offset = 0;
         if(!empty($request->offset)) {
             $offset = $request->offset;
         }
         $transactionLimit = Helper::GetLimit();
         $language_id = $input['languageid'];
         $languageid = explode(',', $language_id);

         $user_language = User::where('id',$user_id)->value('user_language');
         //$user_language = !empty($user_language) ? explode(',',$user_language) : array();

        
         if (in_array(0, $languageid))
         {
            if($user_language != null)
            {
                $checkFestival = Festival::where('fest_id', $input['postcategoryid'])->first();
                if($checkFestival->fest_name == "Trending") {
                   $posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset)->get();
                }
                else {
                    $posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset)->get();
                }
                // $posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset)->get();

                
                //$posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->whereIn('language_id',$user_language)->orderBy('image_type','ASC')->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset)->get();
            }
            else
            {
                $posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset)->get();
                 
            }
        }
        else
        {
            
            $posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->whereIn('language_id',$languageid)->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset)->get();

         }

        $language_ids = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->select('language_id')->get()->toArray();
        $language_id_array = array_unique($language_ids, SORT_REGULAR);

     
            $temp = array();
            foreach($posts as $ph_value)
            {
                $data_ph['post_content'] = !empty($ph_value->post_content) ? Storage::url($ph_value->post_content) :"";
                $data_ph['image_thumbnail_url'] = !empty($ph_value->post_thumb) ? Storage::url($ph_value->post_thumb) : Storage::url($ph_value->post_content);
                $data_ph['post_id'] = !empty($ph_value->post_id) ? strval($ph_value->post_id) :0;
                $data_ph['image_type'] = !empty($ph_value->image_type) ? strval($ph_value->image_type) :0;
                $data_ph['post_category_id'] = !empty($ph_value->post_category_id) ? strval($ph_value->post_category_id) :0;
                $data_ph['post_language_id'] = !empty($ph_value->language_id) ? strval($ph_value->language_id) :0;
                array_push($temp,$data_ph);
            }
        if (in_array(0, $languageid))
        {
            if($user_language != null)
            {
                $posts_next = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
                //$posts_next = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->whereIn('language_id',$user_language)->orderBy('image_type','ASC')->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
            }
            else
            {
                $posts_next = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset + count($posts))->get();
            }
        }
        else
        {
            $posts_next = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->whereIn('language_id',$languageid)->orderBy('post_id','DESC')->take($transactionLimit)->skip($offset + count($posts))->get();

        }

        $languages = Language::where('is_delete','=',0)->whereIn('id',$language_id_array)->get();

        $language = array();

        foreach ($languages as $key => $value) 
        {
            $data = array();
            $data['id'] = strval($value->id);
            $data['language'] = !empty($value->name)?$value->name:"";
            array_push($language, $data);
        }

        $next = true;
        if(count($posts_next) == 0) {
            $next = false;
        }

        $meta = array(
            'offset' => $offset + count($posts),
            'limit' => intval($transactionLimit),
            'record' => count($posts),
            'next' => $next
        );

        if(!empty($posts)){
            return response()->json(['data' => $temp, 'meta'=>$meta, 'language'=>$language, 'status' => true,'message'=>'List of all festival']);
        } else {
            return response()->json(['status' => fasle,'message'=>'There is no festival in this month']);

        }
    }

    public function getDays(Request $request){
        
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        $currnt_date = date('Y-m-d');
        $festivals = array();
        if($input['date'] != '')
        {
            $date = str_replace('/', '-', $input['date']);
            $date = date('Y-m-d',strtotime($date));

        // $festivals = Festival::where('fest_date', 'LIKE', $date . '%')->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get();
        
            $festivals = Festival::where('fest_date', '=', $date)->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get()->toArray();
        } else {
            //  $festivals = Festival::where('fest_type','=','festival')->where('fest_is_delete','=',0)->get()->toArray();
            
            $festivals1 = Festival::where('fest_date', '>=', date('Y-m-d'))->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get()->toArray();
            
            $festivals2 = Festival::where('fest_date', '<', date('Y-m-d'))->where('fest_type','=','festival')->where('fest_is_delete','=',0)->get()->toArray();
            
            $festivals = array_merge($festivals1,$festivals2);
            
        }
        $festival = array();
        $data_festival = array();
        for ($i=0; $i < sizeof($festivals); $i++) { 
            //$festivals[$i]['fest_day'] = date_parse_from_format('Y-m-d', $festivals[$i]['fest_date'])['day'];
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
            $data_festival['fest_id'] = strval($festivals[$i]['fest_id']);
            $data_festival['fest_name'] = !empty($festivals[$i]['fest_name'])?$festivals[$i]['fest_name']:"";
            $data_festival['fest_image'] = !empty($festivals[$i]['fest_image'])?Storage::url($festivals[$i]['fest_image']):"";
            $data_festival['fest_date'] = $festivals[$i]['fest_date'];
            //$data_festival['fest_day'] = strval($festivals[$i]['fest_day']);

            array_push($festival, $data_festival);
        }

        //$userdata = User::where('id','=',$user_id)->select('default_business_id')->first();
        /*$currntbusiness = Business::where('busi_id','=',$userdata->default_business_id)->where('busi_delete','=',0)->first();
        if(!empty($userdata)){
            $ispreminum = false;
            if($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != ''){
                
                $priminum = Purchase::where('purc_business_id','=',$userdata->default_business_id)->where('purc_plan_id','=',2)->first();

                if(!empty($priminum) || $priminum != null || $priminum != ''){
                    $ispreminum = true;
                } else{
                    $ispreminum = false;
                }

            } else {
            $currntbusiness = "you havent't set current business yet";

            }
        }*/
        $olddate = array();
        $newdate = array();
        $current = date('d-m-Y');
        foreach($festival as $fest){
            if(strtotime($fest['fest_date']) >= strtotime($current)){
                array_push($newdate,$fest);
            } else {
                array_push($olddate,$fest);
            }
        }
        // $keys = array_column($newdate, 'fest_date');
        // array_multisort($keys, SORT_ASC, $newdate);

        usort($newdate, function($a, $b){
            return strtotime($a['fest_date']) <=> strtotime($b['fest_date']);
        });

        // unset($keys);

        usort($olddate, function($a, $b){
            return strtotime($a['fest_date']) <=> strtotime($b['fest_date']);
        });
        

        $finalarr = array_merge($newdate,array_reverse($olddate));

        /*$preference = DB::table('user_preference')->where('user_id', '=', $user_id)->get();
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

            if(!empty($preference)){
                
                foreach ($preference as $value) {
                    if($value->preference_value == 1){
                        // $currntbusiness->bus_logo = '';
                        $updatedCurrentBusinessDetails['busi_logo'] = '';
                    }
                    if($value->preference_value == 2){
                        // $currntbusiness->bus_mobile = '';
                        $updatedCurrentBusinessDetails['busi_mobile'] = '';
                    }
                    if($value->preference_value == 3){
                        // $currntbusiness->bus_email = '';
                        $updatedCurrentBusinessDetails['busi_email'] = '';
                    }
                    if($value->preference_value == 4){
                        // $currntbusiness->bus_address = '';
                        $updatedCurrentBusinessDetails['busi_address'] = '';
                    }
                    if($value->preference_value == 5){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_website'] = '';
                    }
                    if($value->preference_value == 6){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_name'] = '';
                    }

                }
            }*/
        if(!empty($festivals)){
           /* return response()->json(['festival' => $finalarr, 'status' => true,'message'=>'List of all festival','current_date' => $currnt_date,'ispreminum' => $ispreminum,'current_business'=>$updatedCurrentBusinessDetails, 'preference' => $preference, 'current_business_new' => $currntbusiness]);*/
           return response()->json(['festival' => $finalarr, 'status' => true,'message'=>'List of all festival','current_date' => $currnt_date,]);
        } else {
            return response()->json(['festival' => $finalarr, 'status' => false,'message'=>'There is no festival on this date','current_date' => $currnt_date]);

        }
    }

    public function savePreference(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        if($input['is_delete'] == 'false' || $input['is_delete'] == false){
     
            DB::table('user_preference')->insert(
                ['user_id' => $user_id, 'preference_value' => $input['preference_value']]
            );
        } else {

            DB::table('user_preference')->where('user_id', '=', $user_id)->where('preference_value', '=', $input['preference_value'])->delete();
        }
        $userdata = User::where('id','=',$user_id)->select('default_business_id')->first();
        if(!empty($userdata)){
            $currntbusiness = Business::where('busi_id','=',$userdata->default_business_id)->where('busi_delete','=',0)->first();
        
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

            if(!empty($preference)){
                
                foreach ($preference as $value) {
                    if($value->preference_value == 1){
                        // $currntbusiness->bus_logo = '';
                        $updatedCurrentBusinessDetails['busi_logo'] = '';
                    }
                    if($value->preference_value == 2){
                        // $currntbusiness->bus_mobile = '';
                        $updatedCurrentBusinessDetails['busi_mobile'] = '';
                    }
                    if($value->preference_value == 3){
                        // $currntbusiness->bus_email = '';
                        $updatedCurrentBusinessDetails['busi_email'] = '';
                    }
                    if($value->preference_value == 4){
                        // $currntbusiness->bus_address = '';
                        $updatedCurrentBusinessDetails['busi_address'] = '';
                    }
                    if($value->preference_value == 5){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_website'] = '';
                    }
                    if($value->preference_value == 6){
                        // $currntbusiness->bus_website = '';
                        $updatedCurrentBusinessDetails['busi_name'] = '';
                    }

                }
            }
        }
        return response()->json(['status' => true,'message'=>'Successfully set your Preference','preference' => $preference,'current_business'=>$updatedCurrentBusinessDetails]);
    }

    public function getCustomCategoryPost(){

        $onlycat = DB::table('custom_cateogry')->orderBy('slider_img_position','ASC')->get();

        // $preference = DB::table('custom_cateogry_data')->join('custom_cateogry', 'custom_cateogry_data.custom_cateogry_id', '=', 'custom_cateogry.custom_cateogry_id')->get();
        
        $finalarry = array();

        $slider = array();

        foreach ($onlycat as $value) {
            $temp = array();
            // $banner_img = '';
            $temp['name'] = $value->name;
            $temp['custom_cateogry_id'] = $value->custom_cateogry_id;
            $temp['catdata'] = [];
            $preference = DB::table('custom_cateogry_data')->where('custom_cateogry_id', '=', $value->custom_cateogry_id)->orderBy('custom_cateogry_data_id','DESC')->get();
            foreach ($preference as $value2) {
                // $data['custom_cateogry_id'] = $value->custom_cateogry_id;
                // $data['name'] = $value->name;
                // $banner_img = url('/').$value2->banner_image;
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
                array_push($temp['catdata'],$data);
            }
            
            array_push($finalarry,$temp);
            $slide = array();
            $slide['custom_cateogry_id'] = $value->custom_cateogry_id;
            $slide['slider_img'] = Storage::url($value->slider_img);
            $slide['slider_img_position'] = $value->slider_img_position;
            array_push($slider,$slide);

        }

        return response()->json(['status' => true,'message'=>'Successfully set your Preference', 'data' => $finalarry, 'slider' => $slider]);
    }

    public function getCustomCategoryImages(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $preference = DB::table('custom_cateogry_data')->where('custom_cateogry_id', '=', $input['custom_cateogry_id'])->orderBy('custom_cateogry_data_id','DESC')->get();

        foreach ($preference as &$value2) {
            // $data['custom_cateogry_id'] = $value->custom_cateogry_id;
            // $data['name'] = $value->name;
            $value2->banner_image = Storage::url($value2->banner_image);
            $value2->image_one = Storage::url($value2->image_one);
            // $value2->image_two = url('/').$value2->image_two;
            $value2->position_x = $value2->position_x;
            $value2->position_y = $value2->position_y;
        }

        if(!empty($preference)){
            return response()->json(['status' => true,'message'=>'Successfully get images', 'data' => $preference]);
        } else {
            return response()->json(['status' => false,'message'=>'Image not found']);
        }

    }

    public function getVideoPosts(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $finalarr = array();
        $festivals =  DB::table('video_post')->where('is_deleted','=',0)->orderBy('date_added','ASC')->get();
       
        if(!empty($festivals)){
            $olddate = array();
            $newdate = array();
            $current = date('d-m-Y');
            foreach($festivals as $fest){
                if(strtotime($fest->date) >= strtotime($current)){
                    array_push($newdate,$fest);
                } else {
                    array_push($olddate,$fest);
                }
                //$fest->video_url = Storage::url($fest->video_url);
                $fest->video_url = url('/').'/'.$fest->video_url;
                $imgurl_create = Storage::url('/');
                $fest->thumbnail = str_replace(".com/",".com",$imgurl_create).''.$fest->thumbnail;
                
            }
            // print_r($newdate);die;
            usort($newdate, function($a, $b){
                return strtotime($a->date) <=> strtotime($b->date);
            });


            usort($olddate, function($a, $b){
                return strtotime($a->date) <=> strtotime($b->date);
            });
            

            $finalarr = array_merge($newdate,array_reverse($olddate));
        }
        
        if(count($festivals) != 0)
        {
            return response()->json(['status' =>true,'message'=>'Videos listed successfully', 'data' => $finalarr]);
        } else {
            return response()->json(['status' =>false,'message'=>'videos not found']);
        }

    }

    public function getBusinessCategory(Request $request)
    {
       $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $category_data = DB::table('business_category')->where('is_delete','=',0)->get();

        $category = array();

        foreach ($category_data as $key => $value) 
        {
            $data['id'] = strval($value->id);
            $data['category_name'] = !empty($value->name)?$value->name:"";
            array_push($category,$data);
            
        }
        

        if (count($category_data) != 0) 
        {
            return response()->json(['status' =>true,'message'=>'Category list successfully', 'cateogry' => $category]);
        }
        else
        {
            return response()->json(['status' =>false,'message'=>'Category not found']);

        }

    }


    

    // ------------------------------------ Plan Apis -------------------------------------------------

    public function purchasePlan(Request $request)
    {
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        if($input['business_type'] == 1) {
            $checkBusiness = Business::where('busi_id', $input['business_id'])->where('user_id', $user_id)->where('busi_delete',0)->first();
        }
        else {
            $checkBusiness = PoliticalBusiness::where('pb_id', $input['business_id'])->where('user_id', $user_id)->where('pb_is_deleted', 0)->first();
        }
        if(empty($checkBusiness)) {
            return response()->json(['status'=>false,'message'=>'Something goes wrong']);
        }
        
        // $results = DB::select('select * from  refferal_data where ref_user_id = ?', [$user_id]); = 2
        $is_purchasebeforee = DB::table('purchase_plan')->where('purc_user_id','=',$user_id)->where('purc_plan_id','!=',3)->select('purc_user_id')->first();
        
        if(is_null($is_purchasebeforee)){
            
            $results = DB::table('refferal_data')->where('ref_user_id','=',$user_id)->select('ref_by_user_id')->first();
            if(!is_null($results)){
              $credit = DB::table('setting')->where('setting_id','=',1)->select('credit')->first();

              $usercredit = DB::table('users')->where('id', '=', $results->ref_by_user_id)->select('user_credit','id')->first();

              $newcredit = intval($usercredit->user_credit) + intval($credit->credit);

              User::where('id','=', $results->ref_by_user_id)->update(array(
                  'user_credit'=>$newcredit,
              ));
            }
            
        }
        
        //$remainingcredit = $input['remainingcredit'];
        $remainingcredit = '';
      
        if($remainingcredit != 0){
           $usercredit = DB::table('users')->where('id', '=', $user_id)->select('user_credit','id')->first();
           $newcredit = intval($usercredit->user_credit) - intval($remainingcredit);

            User::where('id','=', $user_id)->update(array(
                'user_credit'=>$newcredit,
            ));
        }
        
        $business_id = $input['business_id'];
        $plan_id = $input['plan_id'];
        $start_date = date('Y-m-d');

        $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
        $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
        $end_date = Carbon::parse($end_date);
        $checkAlreadyPremium = Purchase::where('purc_business_id',$business_id)->where('purc_business_type', $input['business_type'])->where('purc_is_cencal',0)->where('purc_is_expire',0)->first();
        $new_start_date = '';
        if(!empty($checkAlreadyPremium->purc_end_date)) {
            $tmp_end_date = Carbon::parse($checkAlreadyPremium->purc_end_date);
            $tmp_start_date = Carbon::now();
            $diff = $tmp_end_date->diffInDays($tmp_start_date);
            $new_start_date = $tmp_start_date->addDays($diff);
            $end_date = $end_date->addDays($diff);
        }
        // if(empty($checkAlreadyPremium)) {
            Purchase::where('purc_business_id',$business_id)->where('purc_business_type', $input['business_type'])->update([
            'purc_plan_id'=>$plan_id,
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
        // }
        // else {
        //     if($input['business_type'] == 1) {
        //         $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id, $business_id);
        //     }
        //     else {
        //         $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id, $business_id);
        //     }
        // }
        
        if($input['plan_type'] == 3){
            $userdata = User::where('id','=',$user_id)->select(['default_business_id','default_political_business_id'])->first();
            $getPurchaseData = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', $input['business_type'])->first();
            if($getPurchaseData->purc_business_type == 1) {
                $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id, $userdata->default_political_business_id);
                // if($userdata->default_political_business_id == '' || empty($userdata->default_political_business_id) || $userdata->default_political_business_id == 0){
                //     $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id);
                // }
                // else {
                //     $checkPurchase = Purchase::where('purchase_plan.purc_user_id', $user_id)->where('purchase_plan.purc_business_type',2)->where('purc_business_id', $userdata->default_political_business_id)->join('political_business', 'political_business.pb_id', '=', 'purchase_plan.purc_business_id')->where('political_business.pb_is_deleted', 0)->where(function ($query) {
                //             $query->where('purchase_plan.purc_plan_id',3)
                //             ->orWhere('purchase_plan.purc_is_expire', 1);
                //     })->first();
                //     if(empty($checkPurchase)) {
                //         $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id);
                //     }
                //     else {
                //         $this->addPoliticalBusinessWhilePlanIsThree($user_id,$plan_id, $userdata->default_political_business_id);
                //     }
                // }
            }
            else {
                $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id, $userdata->default_business_id);
                // if($userdata->default_business_id == '' || empty($userdata->default_business_id) || $userdata->default_business_id == 0){
                //     $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id);
                // }
                // else {
                //     $checkPurchase = Purchase::where('purchase_plan.purc_user_id', $user_id)->where('purchase_plan.purc_business_type',1)->where('purc_business_id', $userdata->default_business_id)->join('business', 'business.busi_id', '=', 'purchase_plan.purc_business_id')->where('business.busi_delete', 0)->where(function ($query) {
                //             $query->where('purchase_plan.purc_plan_id',3)
                //             ->orWhere('purchase_plan.purc_is_expire', 1);
                //     })->first();
                //     if(empty($checkPurchase)) {
                //         $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id);
                //     }
                //     else {
                //         $this->addSimpleBusinessWhilePlanIsThree($user_id,$plan_id, $userdata->default_business_id);
                //     }
                // }
            }
        }

        $usercredit = DB::table('users')->where('id', '=', $user_id)->select('user_credit','id')->first();

        return response()->json(['status'=>true,'message'=>'Purchase Plan successfully Added','user_credit' => $usercredit->user_credit]);

    }

    //  next two function use when user purchase plan type three and user have no any default business

    function addSimpleBusinessWhilePlanIsThree($user_id, $plan_id, $business_id = 0){
        if($business_id != 0) {
            $start_date = date('Y-m-d');

            $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
            $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
            $purchase = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 1)->first();
            $new_start_date = "";
                if($purchase->purc_plan_id == 3) {
                    Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 1)->update(array(
                    'purc_plan_id' => $plan_id,
                    'purc_start_date' => $start_date,
                    'purc_end_date' => $end_date,
                    'purc_is_cencal' => 0,
                    'purc_tel_status' => 7,
                    'purc_follow_up_date' => null,
                    'purc_is_expire' => 0,
                    ));
                }
                else {
                    if(!empty($purchase->purc_end_date)) {
                        $tmp_end_date = Carbon::parse($purchase->purc_end_date);
                        $tmp_start_date = Carbon::now();
                        $diff = $tmp_end_date->diffInDays($tmp_start_date);
                        $new_start_date = $tmp_start_date->addDays($diff);
                        $end_date = $tmp_end_date->addDays($diff);
                    }
                    Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 1)->update(array(
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
        else {
            $checkPurchase = Purchase::where('purchase_plan.purc_user_id', $user_id)->where('purchase_plan.purc_business_type',1)->join('business', 'business.busi_id', '=', 'purchase_plan.purc_business_id')->where('business.busi_delete', 0)->where(function ($query) {
                        $query->where('purchase_plan.purc_plan_id',3)
                        ->orWhere('purchase_plan.purc_is_expire', 1);
                })->first();
            if(empty($checkPurchase)) {
                $business = new Business();
                $business->busi_name = 'Business Name';
                $business->user_id = $user_id;
                $business->busi_email = 'writeyouremail@gmail.com';
                $business->busi_mobile = '8888888888';
                $business->save();
                $business_id = $business->id;

                $start_date = date('Y-m-d');

                $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));

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
            }
            else {
                $start_date = date('Y-m-d');
                $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
                $purchase = Purchase::where('purc_id', $checkPurchase->purc_id)->first();
                $new_start_date = "";
                if($purchase->purc_plan_id == 3) {
                    Purchase::where('purc_id', $checkPurchase->purc_id)->update(array(
                    'purc_plan_id' => $plan_id,
                    'purc_start_date' => $start_date,
                    'purc_end_date' => $end_date,
                    'purc_is_cencal' => 0,
                    'purc_tel_status' => 7,
                    'purc_follow_up_date' => null,
                    'purc_is_expire' => 0,
                    ));
                }
                else {
                    if(!empty($purchase->purc_end_date)) {
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
            if($user_data->default_business_id == '' || empty($user_data->default_business_id) || $user_data->default_business_id == 0) {
                User::where('id', $user_id)->update(array(
                    'default_business_id' => $business_id,
                ));
            }
        }
    }

    function addPoliticalBusinessWhilePlanIsThree($user_id, $plan_id, $business_id = 0){
        if($business_id != 0) {
            $start_date = date('Y-m-d');

            $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
            $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
            $purchase = Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 2)->first();
            $new_start_date = "";
                if($purchase->purc_plan_id == 3) {
                    Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 2)->update(array(
                    'purc_plan_id' => $plan_id,
                    'purc_start_date' => $start_date,
                    'purc_end_date' => $end_date,
                    'purc_is_cencal' => 0,
                    'purc_tel_status' => 7,
                    'purc_follow_up_date' => null,
                    'purc_is_expire' => 0,
                    ));
                }
                else {
                    if(!empty($purchase->purc_end_date)) {
                        $tmp_end_date = Carbon::parse($purchase->purc_end_date);
                        $tmp_start_date = Carbon::now();
                        $diff = $tmp_end_date->diffInDays($tmp_start_date);
                        $new_start_date = $tmp_start_date->addDays($diff);
                        $end_date = $tmp_end_date->addDays($diff);
                    }
                    Purchase::where('purc_business_id', $business_id)->where('purc_business_type', 2)->update(array(
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
        else {
            $checkPurchase = Purchase::where('purchase_plan.purc_user_id', $user_id)->where('purchase_plan.purc_business_type',2)->join('political_business', 'political_business.pb_id', '=', 'purchase_plan.purc_business_id')->where('political_business.pb_is_deleted', 0)->where(function ($query) {
                        $query->where('purchase_plan.purc_plan_id',3)
                        ->orWhere('purchase_plan.purc_is_expire', 1);
                })->first();
            if(empty($checkPurchase)) {
                $business = new PoliticalBusiness();
                $business->pb_name = 'Person name';
                $business->user_id = $user_id;
                $business->pb_designation = 'Designation Here';
                $business->pb_mobile = '8888888888';
                $business->pb_pc_id = 1;
                $business->save();
                $business_id = $business->id;

                $start_date = date('Y-m-d');

                $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));

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
            }
            else {
                $start_date = date('Y-m-d');
                $plantrial = Plan::where('plan_id','=',$plan_id)->select('plan_validity')->first();
                $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
                $purchase = Purchase::where('purc_id', $checkPurchase->purc_id)->first();
                $new_start_date = "";
                if($purchase->purc_plan_id == 3) {
                    Purchase::where('purc_id', $checkPurchase->purc_id)->update(array(
                    'purc_plan_id' => $plan_id,
                    'purc_start_date' => $start_date,
                    'purc_end_date' => $end_date,
                    'purc_is_cencal' => 0,
                    'purc_tel_status' => 7,
                    'purc_follow_up_date' => null,
                    'purc_is_expire' => 0,
                    ));
                }
                else {
                    if(!empty($purchase->purc_end_date)) {
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
            if($user_data->default_political_business_id == '' || empty($user_data->default_political_business_id) || $user_data->default_political_business_id == 0) {
                User::where('id', $user_id)->update(array(
                    'default_political_business_id' => $business_id,
                ));
            }
        }

    }


    public function cencalPurchasedPlan(Request $request){
         $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        Purchase::where('purc_id', $input['id'])->where('purc_user_id', $user_id)->update(array(
            'purc_is_cencal' => 1,
        ));

        return response()->json(['status' => true,'message'=>'plan Succesfully cancel']);
    }

    public function exiprePurchasedPlan(Request $request){
         $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        Purchase::where('purc_id', $input['id'])->update(array(
            'purc_is_expire' => 1,
        ));

        return response()->json(['status' => true,'message'=>'plan expired']);
    }

    public function getMyPurchasePlanList(Request $request){
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $activeplan = DB::table('purchase_plan')->where('purc_user_id','=',$user_id)->where('purc_is_cencal','=',0)->Where('purc_is_expire','=',0)->join('business','purchase_plan.purc_business_id','=','business.busi_id')->join('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->get()->toArray();

        foreach ($activeplan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
        }
        
        // print_r($activeplan);die();
        
        $activeplan = array_map(function ($value) {
            return (array)$value;
        }, $activeplan);
        
        // echo count($listofbusiness);
        $finalarr = array();
        for ($i = 0; $i < count($activeplan); $i++) {
   
               
                $newdata = array_map(function($v){
                    return (is_null($v)) ? "" : $v;
                },$activeplan[$i]);

                
                array_push($finalarr,$newdata);

        }

        $expiredPlan = DB::table('purchase_plan')->where('purc_user_id','=',$user_id)->Where('purc_is_expire','=',1)->join('business','purchase_plan.purc_business_id','=','business.busi_id')->join('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->get();

        foreach ($expiredPlan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
        }

        $cencaledplan = DB::table('purchase_plan')->where('purc_user_id','=',$user_id)->where('purc_is_cencal','=',1)->join('business','purchase_plan.purc_business_id','=','business.busi_id')->join('plan','purchase_plan.purc_plan_id','=','plan.plan_id')->get();

        
        foreach ($cencaledplan as $key => $value) {
            $value->plan_information = unserialize($value->plan_information);
        }

       if(!empty($activeplan) || !empty($expiredPlan) || !empty($cencaledplan)){
            return response()->json(['activeplan' => $finalarr,'expiredplan' => $expiredPlan,'cencaledplan' => $cencaledplan,'status' => true,'message'=>'List of all Plan']);
        } else {
            return response()->json(['status' => fasle,'message'=>"You haven't purchased any plan" ]);
        }
    }
    public function testplan(Request $request){
        $input = $request->all(); 
        $start_dates = date('Y-m-d');
        $business = DB::table('purchase_plan')->where('purc_business_id','=',$input['business_id'])->select('purc_plan_id','purc_end_date')->first();
        $primiumPlanInfo = DB::table('plan')->where('plan_id','=',2)->select('plan_information','plan_actual_price','plan_descount')->first();
        if($business->purc_plan_id == 1){
            $plantrial = Plan::where('plan_sku','=','000FREESKU')->select('plan_validity')->first();
            $start_date = strtotime($start_dates); 
            $end_date = strtotime($business->purc_end_date); 
            $days = ($end_date - $start_date)/60/60/24;
            if($days > $plantrial->plan_validity && $days > 0){
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
                "plan_discount_price"=> $primiumPlanInfo->plan_actual_price,
                "plan_descount"=> $primiumPlanInfo->plan_descount." Discount for limited time",
                "plan_information"=> unserialize($primiumPlanInfo->plan_information),
                "plan_validity"=> "365",
                "plan_validity_type"=> "days"
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
            ]);
            
            return response()->json(['plans' => $temparray,'status' => true,'message'=>'List of all Plan','this_plan_expire_no_trial'=>$this_plan_expire_no_trial]);
    }
    // -------------------------------------- Photos Api -------------------------------------
    
    public function savePhotos(Request $request) {

        $input = $request->all(); 

        $logo = $request->file('image');

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        /*$filename = Str::random(7).time().'.'.$logo->getClientOriginalExtension();
        $logo->move(public_path('images'), $filename);
        $path = url('/').'/public/images/'.$filename;*/

        $path  =  $this->uploadFile($request, null,"image", 'post-img',true,300,300);

        $photo = new Photos();
        $photo->photo_user_id = $user_id;
        $photo->photo_url = $path;
        $photo->photo_business_id = $input['business_id'];
        $photo->save();

        $total = DB::table('photos')->where('photo_user_id', $user_id)->count();
        $userData = User::find($user_id);
        $userData->total_post_download = $total;
        $userData->save();

        return response()->json(['status' => true,'message'=>"Image successfully saved" ]);
    }

    public function getPhotos(Request $request)
    {
        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        
        $page = $request['page']==NULL ? 1 : $request['page'];
        $limit = 10;
        $offset = $limit * ($page - 1);

        //$getallphotos = Photos::where('photo_user_id','=',$user_id)->get();
        
        // $getallphotos = Photos::all();
        
        //  $getallphotos = DB::table('post')->join('festival_data','post.post_category_id','=','festival_data.fest_id')->join('users','post.user_id','=','users.id')->select('users.name','post.post_content','post.post_id','festival_data.fest_name')->get();
        
        $getallphotos = DB::table('photos')->join('users','photos.photo_user_id','=','users.id')->select('users.name','photos.photo_url','photos.photo_id')->where('photos.photo_is_delete','=',0)->where('photos.photo_user_id','=', $user_id)->orderBy('photos.photo_id', 'DESC')->limit($limit)->offset($offset)->get();
        
        if(!empty($getallphotos)){
            return response()->json(['data' => $getallphotos,'status' => true,'message'=>"Image successfully get" ]);
        }
        else{
            return response()->json(['status' => false,'message'=>"You don't have any image yet" ]);
        }
    }
    
    // --------------------------------------------------------------------------------------------------------------------------------
    
    
    
     function drawBorder(&$img, &$color, $thickness = 1) 
    {
        $x1 = 50; 
        $y1 = 50; 
        // $x2 = ImageSX($img) - 1; 
        // $y2 = ImageSY($img) - 1; 

        $x2 = ImageSX($img) - 50; 
        $y2 = ImageSY($img) - 50; 

        for($i = 0; $i < $thickness; $i++) 
        { 
            ImageRectangle($img, $x1++, $y1++, $x2--, $y2--, $color); 
        } 
    }
    
    
    public function getTemplates(Request $request) {
         $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $defaultbusiness = User::where('id','=',$user_id)->select('default_business_id')->first();
        
        if($defaultbusiness == null || $defaultbusiness == '' || empty($defaultbusiness)){
            
             return response()->json(['status' => false,'message'=>"You don't have any default business yet" ]);
        }

        $businessid = $defaultbusiness->default_business_id;

        $bdetail = Business::where('busi_id','=',$businessid)->select('busi_name', 'busi_email', 'busi_mobile', 'busi_website', 'busi_address', 'busi_logo')->first();

        if($bdetail == null || $bdetail == '' || empty($bdetail)){
            
             return response()->json(['status' => false,'message'=>"You don't have any default business yet" ]);
        }

        $logo_img = $bdetail->busi_logo;
        
        $item = array();

        // if(!empty($_FILES['file'])) {
     
        //     $min_rand=rand(0,1000);

        //     $max_rand=rand(100000000000,10000000000000000);

        //     $name_file=rand($min_rand,$max_rand);//this part is for creating random name for image

            

        //      $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);



        //     if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='gif')

        //     {

        //         move_uploaded_file($_FILES["file"]["tmp_name"],"images/logo/" . $name_file.".png");//actually reponsible for copying file in new folder

        //         //$filenameimage="images/" . $name_file.".".$ext;

        //         $logo_img="images/logo/".$name_file.'.png';
                 
        //     }

        //     //$ext=end(explode(".", $_FILES["file"]["name"]));//gets extension

        // }

        $images = imagecreatefrompng(public_path('/').'images1.png'); 

       imagealphablending($images, false);
        imagesavealpha($images, true);
        
        $image_width = imagesx($images);  

        $image_height = imagesy($images);



        /*$company_name='JK Developer';

        $email_id='info@krupeshjarsaniya.com';

        $mobile_no='+91 96877-28484';

        $website='www.krupeshjarsaniya.com';

        $address='Business Edifice, Office #309, 3rd Floor, Near Hotel Samrat, Canal Road, Rajkot.';

        */

        $company_name = $bdetail->busi_name;

        $email_id = $bdetail->busi_email;

        $mobile_no = $bdetail->busi_mobile;

        $website = $bdetail->busi_website;

        $address = $bdetail->busi_address;



        // company name

         

        if($company_name!='')

        {

            $box = new Box($images);

            $box->setFontFace(public_path('/').'font/HONEJ___.ttf'); // http://www.dafont.com/franchise.font

            $box->setFontColor(new Color(0, 0, 0));

            $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);

            $box->setFontSize(70);

            $box->setBox(20, 20, $image_width, $image_height);

            $box->setTextAlign('center', 'top');

            $box->draw($company_name);
        }
        if($logo_img!='')
        {
            $second = @imagecreatefrompng($logo_img);
            if(!$second){
                return response()->json(['status' => false,'message'=>"Not valid png" ]);
            }
            // imagealphablending($second, false);
            // imagesavealpha($second, true);
            //$x = ceil((1000 - $second[5]) / 2); 
            imagecopyresized($images,$second,20,20,0,0, 468, 356, 468, 356);
        }   


        // Email id

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(40, 20, $image_width, $image_height-110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($email_id);


        // mobile no

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(40, 20, $image_width, $image_height-110);

        $box->setTextAlign('center', 'bottom');

        $box->draw($mobile_no);

        // website

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(-40, 20, $image_width, $image_height-110);

        $box->setTextAlign('right', 'bottom');

        $box->draw($website);



        // Email id

        /*$box = new Box($images);

        $box->setFontFace('Comf/rtaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBox(40, 20, $image_width, $image_height-40);

        $box->setTextAlign('left', 'bottom');

        $box->draw("Business Edifice, Office #309, 3rd Floor, Near Hotel Samrat, Canal Road, Rajkot.");



        */

        //multi line text

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/minecraftia.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setLineHeight(1.5);

        //$box->enableDebug();

        $box->setBox(40, 20, $image_width, $image_height-40);

        $box->setTextAlign('left', 'bottom');

        $box->draw($address);

        $tempname = 'images/'.rand().'.png';
        $name = public_path('/').$tempname;

        //header('Content-type: image/png');   

        imagepng($images,$name); 

        //imagepng($images); 

        imagedestroy($images); 




        // $item = array();
    
        $data = URL('/public').'/'.$tempname;
        array_push($item, $data);
        
            // --------------------------------------- second template
            
            
            
        $logo_img = $bdetail->busi_logo;


        $images = imagecreatefrompng(public_path('/').'images1.png'); 

        $image_width = imagesx($images);  

        $image_height = imagesy($images);

        $color = imagecolorallocate($images, 155, 155, 155);
        $this->drawBorder($images,$color, 10);

        imagealphablending($images, false);
        imagesavealpha($images, true);


        $company_name = $bdetail->busi_name;

        $email_id = $bdetail->busi_email;

        $mobile_no = ' '.$bdetail->busi_mobile.' ';

        $website = $bdetail->busi_website;

        $address = $bdetail->busi_address;



        // company name

         

        if($company_name!='')

        {

            $box = new Box($images);

            $box->setFontFace(public_path('/').'font/HONEJ___.ttf'); // http://www.dafont.com/franchise.font

            $box->setFontColor(new Color(0, 0, 0));

            $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);

            $box->setFontSize(70);

            $box->setBox(20, 50, $image_width, $image_height);

            $box->setTextAlign('center', 'top');

            $box->draw($company_name);
        }
        if($logo_img!='')
        {
            $second = @imagecreatefrompng($logo_img);
            if(!$second){
                return response()->json(['status' => false,'message'=>"Not valid png" ]);
            }
            //$x = ceil((1000 - $second[5]) / 2); 
            imagecopyresized($images,$second,1300,20,0,0, 468, 356, 468, 356);
        }   


        $mimage = imagecreatefrompng(public_path('/images').'/phone.png');
        imagecopyresized($images,$mimage,200,$image_height-120,0,0, 30, 30, 30, 30);

        // mobile no

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBackgroundColor(new Color(255, 255, 255));

        $box->setBox(120, 80, $image_width, $image_height-110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($mobile_no);

        // Email id

        $mimage = imagecreatefrompng(public_path('/images').'/phone.png');
        imagecopyresized($images,$mimage,1000,$image_height-120,0,0, 30, 30, 30, 30);

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBackgroundColor(new Color(255, 255, 255));

        $box->setBox(0, 80, $image_width, $image_height-110);

        $box->setTextAlign('center', 'bottom');

        $box->draw($email_id);


        $mimage = imagecreatefrompng(public_path('/images').'/phone.png');
        imagecopyresized($images,$mimage,1750,$image_height-120,0,0, 30, 30, 30, 30);

        // website

        $box = new Box($images);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        $box->setBackgroundColor(new Color(255, 255, 255));


        $box->setBox(-120, 80, $image_width, $image_height-110);

        $box->setTextAlign('right', 'bottom');

        $box->draw($website);


        $tempname = 'images/'.rand().'.png';
        $name = public_path('/').$tempname;

        //header('Content-type: image/png');   

        imagepng($images,$name); 

        //imagepng($images); 

        imagedestroy($images); 




        $data = URL('/public').'/'.$tempname;
        array_push($item, $data);
        
        //  -------------------------------------------- third
        
        
        $logo_img = $bdetail->busi_logo;


        $images = imagecreatefrompng(public_path('/').'images1.png'); 

        $image_width = imagesx($images);  

        $image_height = imagesy($images);

        // $color = imagecolorallocate($images, 155, 155, 155);
        // $this->drawBorder($images,$color, 10);

        imagealphablending($images, false);
        imagesavealpha($images, true);


        $company_name = $bdetail->busi_name;

        $email_id = $bdetail->busi_email;

        $mobile_no = ' '.$bdetail->busi_mobile.' ';

        $website = $bdetail->busi_website;

        $address = $bdetail->busi_address;



        // company name

         

        if($company_name!='')

        {

            $box = new Box($images);

            $box->setFontFace(public_path('/').'font/HONEJ___.ttf'); // http://www.dafont.com/franchise.font

            $box->setFontColor(new Color(0, 0, 0));

            $box->setTextShadow(new Color(0, 0, 0, 50), 2, 2);

            $box->setFontSize(70);

            $box->setBox(20, 50, $image_width, $image_height);

            $box->setTextAlign('center', 'top');

            $box->draw($company_name);
        }
        if($logo_img!='')
        {
            $second = @imagecreatefrompng($logo_img);
            if(!$second){
                return response()->json(['status' => false,'message'=>"Not valid png" ]);
            }
            //$x = ceil((1000 - $second[5]) / 2); 
            imagecopyresized($images,$second,750,$image_height-500,0,0, 468, 356, 468, 356);
        }   


        

        // mobile no

        $box = new Box($images);

        $mimage = imagecreatefrompng(public_path('/images').'/phone.png');
        imagecopyresized($images,$mimage,650,$image_height-100,0,0, 30, 30, 30, 30);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        // $box->setBackgroundColor(new Color(255, 255, 255));

        $box->setBox(700, 50, $image_width, $image_height-110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($mobile_no);

        // Email id


        $box = new Box($images);


        $mimage = imagecreatefrompng(public_path('/images').'/phone.png');
        imagecopyresized($images,$mimage,950,$image_height-100,0,0, 30, 30, 30, 30);


        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        // $box->setBackgroundColor(new Color(255, 255, 255));

        $box->setBox(1000, 50, $image_width, $image_height-110);

        $box->setTextAlign('left', 'bottom');

        $box->draw($email_id);
        // $box->draw('jasmeen.maradeeya@gmail.com');



        // website

        $box = new Box($images);

        $mimage = imagecreatefrompng(public_path('/images').'/phone.png');
        imagecopyresized($images,$mimage,650,$image_height-50,0,0, 30, 30, 30, 30);

        $box->setFontFace(public_path('/').'font/Comfortaa-Bold.ttf'); // http://www.dafont.com/franchise.font

        $box->setFontColor(new Color(0, 0, 0));

        $box->setTextShadow(new Color(0, 0, 0, 10), 1, 1);

        $box->setFontSize(40);

        // $box->setBackgroundColor(new Color(255, 255, 255));


        $box->setBox(50, 100, $image_width, $image_height-110);

        $box->setTextAlign('center', 'bottom');

        // $box->draw('http://technocometsolutions.com');
        $box->draw($website);


        $tempname = 'images/'.rand().'.png';
        $name = public_path('/').$tempname;

        //header('Content-type: image/png');   

        imagepng($images,$name); 

        //imagepng($images); 

        imagedestroy($images); 
        
       // echo json_encode($item);
        $data = URL('/public').'/'.$tempname;
        array_push($item, $data);
        
         return response()->json(['data' => $item,'status' => true,'message'=>"Image Genetares" ]);
    }

    public function getAllVideoPosts(Request $request)
    {
        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $currnt_date = date('Y-m-d');


        //$festivals = DB::table('video_data')->where('video_type','=','festival')->where('video_is_delete','=',0)->get();
        $festivals = DB::table('video_data')->where('video_type','=','festival')->whereDate('video_date', '>=', $currnt_date)->where('video_is_delete',0)->orderBy('video_date','asc')->offset(0)->limit(10)->get();

        $incidents = DB::table('video_data')->where('video_type','=','incident')->where('video_is_delete','=',0)->get();
        
        $data_festival = array();
        $data_incident = array();

        foreach ($festivals as $key => $festival) 
        {
            $data = array();
            
            $data['id'] = strval($festival->video_id);
            $data['video_name'] = !empty($festival->video_name)?$festival->video_name:"";
            $data['video_date'] = !empty($festival->video_date)? date('d-m-Y',strtotime($festival->video_date)):"";
            $data['video_image'] = !empty($festival->video_image)?Storage::url($festival->video_image):"";
            $data['video_type'] = !empty($festival->video_type)?$festival->video_type:"";

            array_push($data_festival, $data);

        }

        foreach ($incidents as $key => $incident) 
        {
            $data = array();
            
            $data['id'] = strval($incident->video_id);
            $data['video_name'] = !empty($incident->video_name)?$incident->video_name:"";
            $data['video_date'] = !empty($incident->video_date)?date('d-m-Y',strtotime($incident->video_date)):"";
            $data['video_image'] = !empty($incident->video_image)?Storage::url($incident->video_image):"";
            $data['video_type'] = !empty($incident->video_type)?$incident->video_type:"";

            array_push($data_incident, $data);

        }
        if(count($festivals) != 0 || count($incidents) != 0)
        {
            return response()->json(['festival' =>$data_festival,'category' =>$data_incident,'status' => true,'message'=>"Video List Successfully" ]);
        }
        
        else
        {
            return response()->json(['status' => false,'message'=>"Video Not Found" ]);

        }
    }

    public function getAdvetisement(Request $request)
    {
        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $adv_datas = DB::table('advetisement')->where('is_delete','=',0)->get();
        $advetisement = array();

        foreach ($adv_datas as $key => $value) 
        {
            $data = array();
            $data['id'] = strval($value->id);
            $data['adv_image'] = !empty($value->adv_image)?Storage::url($value->adv_image):"";
            $data['adv_number'] = !empty($value->adv_number)?$value->adv_number:"";
            $data['adv_link'] = !empty($value->adv_link)?$value->adv_link:"";

            array_push($advetisement, $data);
        }
        if (count($adv_datas) != 0) 
        {
            return response()->json(['data' =>$advetisement,'status' => true,'message'=>"Advetisement List Successfully" ]);
        }
        else
        {
            return response()->json(['status' => false,'message'=>"Advetisement Not Found" ]);

        }

    }

    public function getLanguage(Request $request)
    {
        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $user_language = User::where('id',$user_id)->value('user_language');
        $user_language = !empty($user_language) ? explode(',',$user_language) : "";
        $languages = Language::where('is_delete','=',0)->get();

        $language = array();

        foreach ($languages as $key => $value) 
        {
            $data = array();
            $data['id'] = strval($value->id);
            $data['status'] = $user_language!="" ? (in_array($value->id,$user_language) ? true : false) : false;
            $data['language'] = !empty($value->name)?$value->name:"";
            array_push($language, $data);
        }

        if(count($languages) != 0)
        {
            return response()->json(['data' =>$language,'status' => true,'message'=>"Language List Successfully" ]);
        }
        
        else
        {
            return response()->json(['status' => false,'message'=>"Language Not Found" ]);

        }

        
    }

    public function getLanguageVideo(Request $request)
    {
        $input = $request->all(); 
        $videoid = $input['videoid'];
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $offset = 0;
        if(!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();

        $user_language = User::where('id',$user_id)->value('user_language');
        //$user_language = !empty($user_language) ? explode(',',$user_language) : array();

        //dd($languageid);
        if (in_array(0, $languageid)) 
        {
            if($user_language != null )
            {

                $video = DB::table('video_post_data')->where('video_post_id','=',$videoid)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();
            }
            else
            {
                $video = DB::table('video_post_data')->where('video_post_id','=',$videoid)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();

            }
        }
        else
        {
            $video = DB::table('video_post_data')->where('video_post_id','=',$videoid)->whereIn('language_id',$languageid)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();

        }

        $language_ids = DB::table('video_post_data')->where('video_post_id','=',$videoid)->where('is_deleted','=',0)->select('language_id')->get()->toArray();

        $language_id_array = [];
        foreach ($language_ids as $id){
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);
        
        $videos = array();
        foreach ($video as $key => $value) 
        {
            $data = array();

            $data['id'] = strval($value->id);
            $data['image'] = !empty($value->thumbnail)?Storage::url($value->thumbnail):"";
            if($value->video_store) {
                $data['video'] = !empty($value->video_url)?url('/').'/'.$value->video_url:"";
            }
            else {
                $data['video'] = !empty($value->video_url)?Storage::url($value->video_url):"";
            }
            $data['type'] = strval($value->image_type);
            $data['color'] = !empty($value->color)?$value->color:"";
            array_push($videos, $data);
        }

        if (in_array(0, $languageid)) 
        {
            if($user_language != null )
            {

                $video_next = DB::table('video_post_data')->where('video_post_id','=',$videoid)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($video))->get();
            }
            else
            {
                $video_next = DB::table('video_post_data')->where('video_post_id','=',$videoid)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($video))->get();

            }
        }
        else
        {
            $video_next = DB::table('video_post_data')->where('video_post_id','=',$videoid)->whereIn('language_id',$languageid)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($video))->get();

        }

        $languages = Language::where('is_delete','=',0)->whereIn('id',$language_id_array)->get();

        $language = array();

        foreach ($languages as $key => $value) 
        {
            $data = array();
            $data['id'] = strval($value->id);
            $data['language'] = !empty($value->name)?$value->name:"";
            array_push($language, $data);
        }

        $next = true;
            if(count($video_next) == 0) {
                $next = false;
            }

        $meta = array(
                'offset' => $offset + count($video),
                'limit' => intval($transactionLimit),
                'record' => count($video),
                'next' => $next
            );

        // if(count($video) != 0)
        // {
            return response()->json(['data' =>$videos, 'meta'=>$meta, 'language'=>$language, 'status' => true,'message'=>"Video List Successfully" ]);
        // }
        
        // else
        // {
        //     return response()->json(['status' => false,'message'=>"Video Not Found" ]);

        // }

    }

    public function getLanguagePost(Request $request)
    {
        $input = $request->all(); 
        $postid = $input['postid'];
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $offset = 0;
        if(!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();

        $user_language = User::where('id',$user_id)->value('user_language');
        //$user_language = !empty($user_language) ? explode(',',$user_language) : array();
        
        //dd($languageid);
        if (in_array(0, $languageid)) 
        {
            if($user_language != null)
            {

                $post = Post::where('post_category_id','=',$postid)->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->take($transactionLimit)->skip($offset)->get();
            }
            else
            {
                $post = Post::where('post_category_id','=',$postid)->where('post_is_deleted','=',0)->take($transactionLimit)->skip($offset)->get();

            }
        }
        else
        {
            $post = Post::where('post_category_id','=',$postid)->whereIn('language_id',$languageid)->where('post_is_deleted','=',0)->take($transactionLimit)->skip($offset)->get();
            
        }
        
        $posts = array();
        foreach ($post as $key => $value) 
        {
            $data = array();
            
            $data['id'] = strval($value->post_id);
            $data['image'] = !empty($value->post_content) ? Storage::url($value->post_content):"";
            $data['image_thumbnail_url'] = !empty($value->post_thumb) ? Storage::url($value->post_thumb) : Storage::url($value->post_content);
            $data['type'] = strval($value->image_type);
            array_push($posts, $data);
        }

        if (in_array(0, $languageid)) 
        {
            if($user_language != null)
            {

                $post_next = Post::where('post_category_id','=',$postid)->where('post_is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->take($transactionLimit)->skip($offset + count($post))->get();
            }
            else
            {
                $post_next = Post::where('post_category_id','=',$postid)->where('post_is_deleted','=',0)->take($transactionLimit)->skip($offset + count($post))->get();

            }
        }
        else
        {
            $post_next = Post::where('post_category_id','=',$postid)->whereIn('language_id',$languageid)->where('post_is_deleted','=',0)->take($transactionLimit)->skip($offset + count($post))->get();

        }

        $next = true;
            if(count($post_next) == 0) {
                $next = false;
            }

        $meta = array(
                'offset' => $offset + count($post),
                'limit' => intval($transactionLimit),
                'record' => count($post),
                'next' => $next
            );

        if(count($post) != 0)
        {
            return response()->json(['data' =>$posts, 'meta'=>$meta, 'status' => true,'message'=>"post List Successfully" ]);
        }
        
        else
        {
            return response()->json(['status' => false,'message'=>"post Not Found" ]);

        }

    }

    public function getCustomCategoryPosts(Request $request)
    {

        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $new_category_data_greetings = DB::table('custom_cateogry')->whereIn('highlight',array(2,3))->orderBy('slider_img_position','ASC')->get();
        $new_category_data_greetingsArray = array();
        foreach ($new_category_data_greetings as $greeting) {

            $photo = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$greeting->custom_cateogry_id)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderBy('custom_cateogry_data_id','DESC')->limit(10)->get();
            
            $temp1['id'] = $greeting->custom_cateogry_id;
            $temp1['title'] = $greeting->name;
            // $temp1['type'] = $greeting[$i]['new_cat'];

            $temp1['img_url'] = array();
            foreach($photo as $ph_value)
            {
                $data_ph1['custom_cateogry_id'] = !empty($ph_value->custom_cateogry_id) ? strval($ph_value->custom_cateogry_id) :0;
                $data_ph1['banner_image'] = !empty($ph_value->banner_image) ?Storage::url($ph_value->banner_image) : "";
                $data_ph1['image'] = !empty($ph_value->image_one) ?Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['image_one'] = !empty($ph_value->image_one) ?Storage::url($ph_value->image_one) : "";
                $data_ph1['images']['position_x'] = $ph_value->position_x;
                $data_ph1['images']['position_y'] = $ph_value->position_y;
                $data_ph1['images']['img_position_x'] = $ph_value->img_position_x;
                $data_ph1['images']['img_position_y'] = $ph_value->img_position_y;
                $data_ph1['images']['img_height'] = $ph_value->img_height;
                $data_ph1['images']['img_width'] = $ph_value->img_width;
                array_push($temp1['img_url'],$data_ph1);
            }
            
            array_push($new_category_data_greetingsArray,$temp1);
        }

        $onlycat = DB::table('custom_cateogry')->whereIn('highlight', array(2,3))->orderBy('slider_img_position','ASC')->get();

        
        $finalarry = array();

        $slider = array();

        foreach ($onlycat as $value) {
            $temp = array();
            // $banner_img = '';
            $temp['custom_cateogry_id'] = strval($value->custom_cateogry_id);
            $temp['name'] = !empty($value->name)?$value->name:"";
            $temp['custom_image'] = !empty($value->slider_img)?Storage::url($value->slider_img):"";
            
            array_push($finalarry,$temp);
            $slide = array();
            $slide['custom_cateogry_id'] = $value->custom_cateogry_id;
            $slide['slider_img'] = Storage::url($value->slider_img);
            $slide['slider_img_position'] = $value->slider_img_position;
            array_push($slider,$slide);

        }

        $onlycat = DB::table('custom_cateogry')->whereIn('highlight', array(0,1))->orderBy('slider_img_position','ASC')->get();

        
        foreach ($onlycat as $value) {
            $temp = array();
            // $banner_img = '';
            $temp['custom_cateogry_id'] = strval($value->custom_cateogry_id);
            $temp['name'] = !empty($value->name)?$value->name:"";
            $temp['custom_image'] = !empty($value->slider_img)?Storage::url($value->slider_img):"";
            
            array_push($finalarry,$temp);
            $slide = array();
            $slide['custom_cateogry_id'] = $value->custom_cateogry_id;
            $slide['slider_img'] = Storage::url($value->slider_img);
            $slide['slider_img_position'] = $value->slider_img_position;
            array_push($slider,$slide);

        }

        return response()->json(['status' => true,'message'=>'Successfully set your Preference', 'data' => $finalarry, 'slider' => $slider, 'greeting'=> $new_category_data_greetingsArray]);
    }

    public function getLanguageCustomeCategoryPost(Request $request)
    {
        $input = $request->all(); 
        $catid = $input['catid'];
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $offset = 0;
        if(!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();

        $user_language = User::where('id',$user_id)->value('user_language');
        //$user_language = !empty($user_language) ? explode(',',$user_language) : array();

        //dd($languageid);
        if (in_array(0, $languageid)) 
        {
            if($user_language != null)
            {

                $cat = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$catid)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('custom_cateogry_data_id','DESC')->take($transactionLimit)->skip($offset)->get();
            }
            else
            {
                $cat = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$catid)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderBy('custom_cateogry_data_id','DESC')->take($transactionLimit)->skip($offset)->get();
            }
        }
        else
        {
            $cat = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$catid)->whereIn('language_id',$languageid)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderBy('custom_cateogry_data_id','DESC')->take($transactionLimit)->skip($offset)->get();

        }

        $language_ids = DB::table('custom_cateogry_data')->where('is_delete','=',0)->where('custom_cateogry_id','=',$catid)->select('language_id')->get()->toArray();
        // $language_id_array = array_unique($language_ids, SORT_REGULAR);

        $language_id_array = [];
        foreach ($language_ids as $id){
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);

       
        $cats = array();
        foreach ($cat as $key => $value) 
        {
            $data = array();

            $data['id'] = strval($value->custom_cateogry_data_id);
            $data['banner_image'] = !empty($value->image_one)?Storage::url($value->image_one):"";
            $data['image'] = !empty($value->banner_image)?Storage::url($value->banner_image):"";
            $data['position_x'] = !empty($value->position_x)?$value->position_x:"";
            $data['position_y'] = !empty($value->position_y)?$value->position_y:"";
            $data['img_position_x'] = !empty($value->img_position_x)?$value->img_position_x:"";
            $data['img_position_y'] = !empty($value->img_position_y)?$value->img_position_y:"";
            $data['img_height'] = !empty($value->img_height)?$value->img_height:"";
            $data['img_width'] = !empty($value->img_width)?$value->img_width:"";
            $data['type'] = strval($value->image_type);
            array_push($cats, $data);
        }

        if (in_array(0, $languageid)) 
        {
            if($user_language != null)
            {
                $cat_next = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$catid)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('custom_cateogry_data_id','DESC')->take($transactionLimit)->skip($offset + count($cat))->get();
            }
            else
            {
                $cat_next = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$catid)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderBy('custom_cateogry_data_id','DESC')->take($transactionLimit)->skip($offset + count($cat))->get();

            }
        }
        else
        {
            $cat_next = DB::table('custom_cateogry_data')->where('custom_cateogry_id','=',$catid)->whereIn('language_id',$languageid)->where('is_delete','=',0)->orderBy('image_type','ASC')->orderBy('custom_cateogry_data_id','DESC')->take($transactionLimit)->skip($offset + count($cat))->get();

        }

        $language = array();
        if(!empty($language_id_array)){
          
            $languages = Language::where('is_delete','=',0)->whereIn('id',$language_id_array)->get();

            foreach ($languages as $key => $value) 
            {
                $data = array();
                $data['id'] = strval($value->id);
                $data['language'] = !empty($value->name)?$value->name:"";
                array_push($language, $data);
            }
        }

        $next = true;
            if(count($cat_next) == 0) {
                $next = false;
            }

        $meta = array(
                'offset' => $offset + count($cat),
                'limit' => intval($transactionLimit),
                'record' => count($cat),
                'next' => $next
            );

        // if(count($cat) != 0)
        // {
            return response()->json(['data' =>$cats, 'meta'=>$meta, 'language'=>$language, 'status' => true,'message'=>"Custome Category Post List Successfully" ]);
        // }
        
        // else
        // {
        //     return response()->json(['status' => false, 'language'=>$language,'message'=>"Custome Category Post Not Found" ]);

        // }

    }

    public function GetAllFestivalVideo(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $currnt_date = date('Y-m-d');
        $festivals = array();
        if($input['date'] != ''){
            $date = str_replace('/', '-', $input['date']);
            $date = date('Y-m-d',strtotime($date));

        
            $videos = VideoData::where('video_date', '=', $date)->where('video_type','=','festival')->where('video_is_delete','=',0)->get()->toArray();
        } else {
            
            $videos1 = VideoData::where('video_date', '>=', date('Y-m-d'))->where('video_type','=','festival')->where('video_is_delete','=',0)->get()->toArray();
            
            $videos2 = VideoData::where('video_date', '<', date('Y-m-d'))->where('video_type','=','festival')->where('video_is_delete','=',0)->get()->toArray();
            //dd($videos1);
            $videos = array_merge($videos1,$videos2);
            //$videos = Arr::collapse([$videos1,$videos2]);
           // dd($videos);
            //dd($videos[0]->video_id);
        }
        //dd($videos);
        $video = array();
        $data_video = array();
        for ($i=0; $i < sizeof($videos); $i++) { 
            $videos[$i]['video_date'] = date("d-m-Y", strtotime($videos[$i]['video_date']));
            $data_video['video_id'] = strval($videos[$i]['video_id']);
            $data_video['video_name'] = !empty($videos[$i]['video_name'])?$videos[$i]['video_name']:"";
            $data_video['video_image'] = !empty($videos[$i]['video_image'])?Storage::url($videos[$i]['video_image']):"";
            $data_video['video_date'] = $videos[$i]['video_date'];

            array_push($video, $data_video);
        }

        
        $olddate = array();
        $newdate = array();
        $current = date('d-m-Y');
        foreach($video as $fest){
            if(strtotime($fest['video_date']) >= strtotime($current)){
                array_push($newdate,$fest);
            } else {
                array_push($olddate,$fest);
            }
        }
       

        usort($newdate, function($a, $b){
            return strtotime($a['video_date']) <=> strtotime($b['video_date']);
        });



        usort($olddate, function($a, $b){
            return strtotime($a['video_date']) <=> strtotime($b['video_date']);
        });
        

        $finalarr = array_merge($newdate,array_reverse($olddate));

        

            
        if(!empty($videos)){
          
           return response()->json(['video' => $finalarr, 'status' => true,'message'=>'List of all video','current_date' => $currnt_date,]);
        } else {
            return response()->json(['status' => false,'message'=>'There is no video on this date','current_date' => $currnt_date]);

        }
    }

    public function Plans(Request $request)
    {
        $plan_type = $request->plan_type;
        $plans = Plan::where('status','!=',1)->where('new_or_renewal', 'new')->where(function($query) use($plan_type) {
            $query->where('plan_type', $plan_type);
            $query->orWhere('plan_type', 3);
        })->where('plan_id','!=',3)->orderBy('order_no','asc')->get();
        $plan = array();

        foreach ($plans as $key => $value) 
        {
            $data['id'] = strval($value->plan_id);
            $data['plan_type'] = !empty($value->plan_type)?$value->plan_type:"";
            $data['plan_name'] = !empty($value->name)?$value->name:"";
            $data['price'] = !empty($value->plan_actual_price)?$value->plan_actual_price:"";
            $data['plan_validity'] = !empty($value->plan_validity)?$value->plan_validity:"";
            $data['plan_validity_type'] = !empty($value->plan_validity_type)?$value->plan_validity_type:"";
            $data['order_no'] = !empty($value->order_no)?$value->order_no:0;
            $data['image'] = !empty($value->image)?Storage::url($value->image):"";
            array_push($plan, $data);
        }
         return response()->json(['data'=> $plan, 'status'=>true,'message'=>'List of Plan']); 
    }

    public function getBusinessCategoryImages(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $offset = 0;
        if(!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);

        $user_language = User::where('id',$user_id)->value('user_language');
        // $user_language = !empty($user_language) ? explode(',',$user_language) : array();


        if (in_array(0, $languageid))
        {
            if($user_language != null)
            {

                $images = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')/*->orderByRaw("FIELD(language_id , ".$user_language.") DESC")*/->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();
            }
            else
            {
                $images = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();

            }
        }
        else
        {
            $images = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->whereIn('language_id',$languageid)->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();

        }

        $language_ids = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->select('language_id')->get()->toArray();
        // $language_id_array = array_unique($language_ids, SORT_REGULAR);
        $language_id_array = [];
        foreach ($language_ids as $id){
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);

        $buss_images = array();
            foreach ($images as $img_key => $img_value) 
            {
                $img_data['image_id'] = strval($img_value->id);
                $img_data['image_url'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) :"";
                $img_data['image_thumbnail_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                $img_data['image_type'] = strval($img_value->image_type);
                $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) :"";

                array_push( $buss_images, $img_data);
            }
            if (in_array(0, $languageid))
            {
                if($user_language != null)
                {
                    $Getimages_next = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($images))->get();
                }
                else
                {
                    $Getimages_next = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($images))->get();

                }
            }
            else
            {
                $Getimages_next = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->buss_cat_id)->where('is_deleted','=',0)->whereIn('language_id',$languageid)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($images))->get();

            }
            $language = array();

            if(!empty($language_id_array)){
                $languages = Language::where('is_delete','=',0)->whereIn('id',$language_id_array)->get();

                foreach ($languages as $key => $value) 
                {
                    $data = array();
                    $data['id'] = strval($value->id);
                    $data['language'] = !empty($value->name)?$value->name:"";
                    array_push($language, $data);
                }
            }

        $next = true;
        if(count($Getimages_next) == 0) {
            $next = false;
        }
        $meta = array(
            'offset' => $offset + count($images),
            'limit' => intval($transactionLimit),
            'record' => count($images),
            'next' => $next
        );

        if(!empty($images)){
          
           return response()->json(['buss_images' => $buss_images, 'meta'=>$meta, 'language'=>$language, 'status' => true,'message'=>'List of all images']);
        } else {
            return response()->json(['status' => false,'message'=>'There is no images']);

        }
    }

    public function moveElement(&$array, $a, $b) {
        $p1 = array_splice($array, $a, 1);
        $p2 = array_splice($array, 0, $b);
        $array = array_merge($p2,$p1,$array);

        return $array;
    }

    public function CurrntbusinessPhoto(Request $request)
    {
        $input = $request->all();
       
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $offset = 0;
        if(!empty($request->offset)) {
            $offset = $request->offset;
        }
        $transactionLimit = Helper::GetLimit();
        $language_id = $input['languageid'];
        $languageid = explode(',', $language_id);

        $user_language = User::where('id',$user_id)->value('user_language');
        //$user_language = !empty($user_language) ? explode(',',$user_language) : array();



        if (in_array(0, $languageid))
        {
            if($user_language != null)
            {
                $currntbusiness_photo = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')/*->orderByRaw("FIELD(language_id , ".$user_language.") DESC")*/->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();
            }
            else
            {
                $currntbusiness_photo = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get(); 
            }   

            
        }
        else
        {
            $currntbusiness_photo = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->whereIn('language_id',$languageid)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset)->get();

        }

        $language_ids = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->select('language_id')->get()->toArray();
        $language_id_array = [];
        foreach ($language_ids as $id){
            array_push($language_id_array, $id->language_id);
        }
        $language_id_array = array_unique($language_id_array, SORT_REGULAR);

       
            $images = array();
            foreach ($currntbusiness_photo as $img_key => $img_value) 
            {
        
                $img_data['image_id'] = strval($img_value->id);
                $img_data['image_url'] = !empty($img_value->thumbnail) ? Storage::url($img_value->thumbnail) :"";
                $img_data['image_thumbnail_url'] = !empty($img_value->post_thumb) ? Storage::url($img_value->post_thumb) : Storage::url($img_value->thumbnail);
                $img_data['image_type'] = strval($img_value->image_type);
                $img_data['image_language_id'] = !empty($img_value->language_id) ? strval($img_value->language_id) :"";

                array_push( $images, $img_data);
            }
            
            if (in_array(0, $languageid))
            {
                if($user_language != null)
                {
                    $currntbusiness_photo_next = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderByRaw("FIELD(language_id , ".$user_language.") DESC")->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
                }
                else
                {
                    $currntbusiness_photo_next = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
                }
            }
            else
            {
                
                $currntbusiness_photo_next = DB::table('business_category_post_data')->where('post_type','image')->where('buss_cat_post_id','=',$request->busi_id)->where('is_deleted','=',0)->whereIn('language_id',$languageid)->orderBy('image_type','ASC')->orderBy('id','DESC')->take($transactionLimit)->skip($offset + count($currntbusiness_photo))->get();
            }

            $languages = Language::where('is_delete','=',0)->whereIn('id', $language_id_array)->get();

            $language = array();

            foreach ($languages as $key => $value) 
            {
                $data = array();
                $data['id'] = strval($value->id);
                $data['language'] = !empty($value->name)?$value->name:"";
                array_push($language, $data);
            }
        
            $next = true;
            if(count($currntbusiness_photo_next) == 0) {
                $next = false;
            }
            $meta = array(
                'offset' => $offset + count($currntbusiness_photo),
                'limit' => intval($transactionLimit),
                'record' => count($currntbusiness_photo),
                'next' => $next
            );


        if(!empty($images)){
          
           return response()->json(['images' => $images, 'meta'=>$meta, 'language'=>$language, 'status' => true,'message'=>'List of all images']);
        } else {
            return response()->json(['status' => false,'message'=>'There is no images']);

        }


    }
    

    public function newCategoryAllImage(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        /*$new_category_data = Festival::where('fest_type','=','incident')->where('fest_is_delete','=',0)->where('new_cat',1)->get();
            $new_category_dataArray = array();
            for ($i=0; $i < sizeof($new_category_data); $i++) { 
                $photo = Post::where('post_category_id','=',$new_category_data[$i]['fest_id'])->where('post_is_deleted','=',0)->select('post_content','post_id','post_category_id')->orderBy('post_id','DESC')->get();
               
                $temp['id'] = $new_category_data[$i]['fest_id'];
                $temp['title'] = $new_category_data[$i]['fest_name'];
                $temp['img_url'] = $photo;
                
                array_push($new_category_dataArray,$temp);
            }*/
                $photo = Post::where('post_category_id','=',$request->category_id)->where('post_is_deleted','=',0)->select('post_content','post_id','image_type','post_category_id')->orderBy('post_id','DESC')->get();

        if(!empty($photo)){
          
           return response()->json(['images' => $photo, 'status' => true,'message'=>'List of all images']);
        } else {
            return response()->json(['status' => false,'message'=>'There is no images']);

        }       
    }

    public function SocialLogins(Request $request)
    {
        $user_id = $this->get_userid($request->token);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        // if($request->type != 'twitter'){
            $socialLogin = new SocialLogin;
            $socialLogin->user_id = $user_id;
            $socialLogin->type = $request->type;
            $socialLogin->auth_token = $request->auth_token;
            $socialLogin->save();
        // } else {
        //     $socialLogin = new SocialLogin;
        //     $socialLogin->user_id = $user_id;
        //     $socialLogin->type = $request->type;
        //     $socialLogin->access_token_twitter = $request->access_token_twitter;
        //     $socialLogin->access_token_secret_twitter = $request->access_token_secret_twitter;
        //     $socialLogin->save();
        // }
      

        return response()->json(['status' => true,'message'=>'Social login auth add successfully']);

    }

    public function getLanguageWithImage(Request $request)
    {
        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        $user_language = User::where('id',$user_id)->value('user_language');
        $user_language = !empty($user_language) ? explode(',',$user_language) : "";
        $languages = Language::where('is_delete','=',0)->get();

        $language = array();

        foreach ($languages as $key => $value) 
        {
            $data = array();
            $data['id'] = strval($value->id);
            $data['status'] = $user_language!="" ? (in_array($value->id,$user_language) ? true : false) : false;
            $data['language'] = !empty($value->name)?$value->name:"";
            $data['image'] = !empty($value->image)?Storage::url($value->image):"";
            array_push($language, $data);
        }

        if(count($languages) != 0)
        {
            return response()->json(['data' =>$language,'status' => true,'message'=>"Language List Successfully" ]);
        }
        
        else
        {
            return response()->json(['status' => false,'message'=>"Language Not Found" ]);

        }

        
    }

    public function SetUserLanguage(Request $request)
    {
        $input = $request->all(); 
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        
        User::where('id',$user_id)->update(['user_language'=>$request->language]);

        if(!empty($request->language))
        {
            return response()->json(['status' => true,'message'=>"Language Set Successfully" ]);
        }
        else
        {
            return response()->json(['status' => false,'message'=>"Something Went Wrong. Language Not Set." ]);
        }
        
    }

    public function schedulePost(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        if($input['social_media_list'] == ''){
            return response()->json(['status'=>false,'message'=>'please select social media to publish post']);
        }

        if($input['date'] == ''){
            return response()->json(['status'=>false,'message'=>'date is missing']);
        }

        if($input['time'] == ''){
            return response()->json(['status'=>false,'message'=>'time is missing']);
        }

        if(!$request->file("file")){
            return response()->json(['status'=>false,'message'=>'file is missing']);
        }

        // $sp_social_type = 1;
        $sp_media_type = 1;
        $sp_date = date('Y-m-d',strtotime($input['date']));
        $sp_time = $input['time'];
        $path = '';
        if($input['media_type'] == 1){ // image
            $path  =  $this->uploadFile($request, null,"file", 'schedule-post-img');
            $sp_media_type = 1;
        } else { //  video
            $v_image = $request->file("file");
            $name = Str::random(7).time().'.'.$v_image->getClientOriginalExtension();
            $v_image->move(public_path('images/videopost/videos/schedule_video'), $name);
            $path = 'public/images/videopost/videos/schedule_video'.$name;
            $sp_media_type = 2;
        }

        $social_media = explode(',',$_POST['social_media_list']);

        // foreach ($social_media as $social) {

        //     if($social == 'facebook'){
        //         $sp_social_type = 1;
        //     } else if($social == 'instagram'){
        //         $sp_social_type = 2;
        //     } else if($social == 'twitter') {
        //         $sp_social_type = 3;
        //     } else {
        //         $sp_social_type = 4;
        //     }

            $lastid = DB::table('schedule_post')->insertGetId([
                'sp_user_id' => $user_id,
                // 'sp_social_type' => json_encode($social_media),
                'sp_media_type' => $sp_media_type,
                'sp_media_path' => $path,
                'sp_date' => $sp_date,
                'sp_time' => $sp_time,
                'sp_created_at' => date('Y-m-d H:i:s')
            ]);

            foreach($social_media as $social){
                DB::table('schedule_post_type')->insert([
                    'sp_id' => $lastid,
                    'social_media_type' => $social
                ]);
            }
        // }

        return response()->json(['status' => true,'message'=>"Post Schedule added Successfully" ]);
        
    }

    public function reSchedulePost(Request $request)
    {
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        if($input['social_media_list'] == ''){
            return response()->json(['status'=>false,'message'=>'please select social media to publish post']);
        }

        if($input['date'] == ''){
            return response()->json(['status'=>false,'message'=>'date is missing']);
        }

        if($input['time'] == ''){
            return response()->json(['status'=>false,'message'=>'time is missing']);
        }

        // $sp_social_type = 1;
        $sp_media_type = 1;
        $sp_date = date('Y-m-d',strtotime($input['date']));
        $sp_time = $input['time'];
        $path = '';
        if($request->file("file") != null){
            if($input['media_type'] == 1){ // image
                $path  =  $this->uploadFile($request, null,"file", 'schedule-post-img');
                $sp_media_type = 1;
            } else { //  video
                $v_image = $request->file("file");
                $name = Str::random(7).time().'.'.$v_image->getClientOriginalExtension();
                $v_image->move(public_path('images/videopost/videos/schedule_video'), $name);
                $path = 'public/images/videopost/videos/schedule_video'.$name;
                $sp_media_type = 2;
            }
        }
       

        // $social_media = $input['social_media_list'];
        $social_media = explode(',',$_POST['social_media_list']);

        // foreach ($social_media as $social) {

        //     if($social == 'facebook'){
        //         $sp_social_type = 1;
        //     } else if($social == 'instagram'){
        //         $sp_social_type = 2;
        //     } else if($social == 'twitter') {
        //         $sp_social_type = 3;
        //     } else {
        //         $sp_social_type = 4;
        //     }

            if($request->file("file") != null){
                DB::table('schedule_post')
                ->where('sp_id', $input['id'])
                ->update([
                    'sp_user_id' => $user_id,
                    // 'sp_social_type' => json_encode($social_media),
                    'sp_media_type' => $sp_media_type,
                    'sp_media_path' => $path,
                    'sp_date' => $sp_date,
                    'sp_time' => $sp_time,
                    'sp_created_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                DB::table('schedule_post')
                ->where('sp_id', $input['id'])
                ->update([
                    'sp_user_id' => $user_id,
                    // 'sp_social_type' => json_encode($social_media),
                    'sp_media_type' => $sp_media_type,
                    'sp_date' => $sp_date,
                    'sp_time' => $sp_time,
                    'sp_updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            DB::table('schedule_post_type')->where('sp_id', '=', $input['id'])->delete();
            foreach($social_media as $social){
                DB::table('schedule_post_type')->insert([
                    'sp_id' => $input['id'],
                    'social_media_type' => $social
                ]);
            }
        // }

        return response()->json(['status' => true,'message'=>"Post Schedule update Successfully" ]);
    }

    public function getScheduledPost(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $getPost = DB::table('schedule_post')->where('sp_user_id','=',$user_id)->orderBy('sp_id','DESC')->get();

        $finalArray = [];
        $finalArray['all'] = [];
        $finalArray['images'] = [];
        $finalArray['videos'] = [];
        foreach($getPost as &$post){
            $post->sp_media_path = Storage::url($post->sp_media_path);
            // $post->sp_social_type = json_decode($post->sp_social_type);
            $post->sp_social_type = [];
            $tmp = DB::table('schedule_post_type')->where('sp_id','=',$post->sp_id)->select('social_media_type')->get()->toArray();
            foreach($tmp as $t){
                array_push($post->sp_social_type,$t->social_media_type);
            }
            
            if($post->sp_media_type == 1){
                array_push($finalArray['images'],$post);
            } else {
                array_push($finalArray['videos'],$post);
            }
            array_push($finalArray['all'],$post);
        }

        return response()->json(['status' => true,'message'=>"Post Schedule added Successfully",'data'=>$finalArray ]);
    }

    public function removeSchedulePost(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        if(!isset($input['id']) || $input['id'] == ''){
            return response()->json(['status'=>false,'message'=>'post you are looking for is not availabe']);
        }

        $getPost = DB::table('schedule_post')->select('sp_media_path')->where('sp_user_id', $user_id)->where('sp_id','=',$input['id'])->first();

        if($getPost){
            $image_path = $getPost->sp_media_path;
            DB::table('schedule_post')->where('sp_id', '=', $input['id'])->delete();
            DB::table('schedule_post_type')->where('sp_id', '=', $input['id'])->delete();
            Storage::delete($image_path);
        } else {
            return response()->json(['status'=>false,'message'=>'post you are looking for is not availabe']);
        }

        return response()->json(['status' => true,'message'=>"Schedule post successfully removed"]);

    }

    public function sharePost(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

       /* $data = DB::table('schedule_post')->where('sp_user_id','=',$user_id)->get();

        foreach($data as $post){
            $path = Storage::url($post->sp_media_path);
           
            if($post->sp_social_type == 1){

                $tmp = DB::table('social_login')->select('auth_token')->where('sp_user_id','=',$user_id)->where('type','=','facebook')->first();
                $token = $tmp->auth_token;
                $this->postTofacebook($token, $path);

            } else if($post->sp_social_type == 2){

                $tmp = DB::table('social_login')->select('auth_token')->where('sp_user_id','=',$user_id)->where('type','=','instagram')->first();
                $token = $tmp->auth_token;

                // instagram code goes here

            } else if($post->sp_social_type == 3){

                $tmp = DB::table('social_login')->select('auth_token')->where('sp_user_id','=',$user_id)->where('type','=','twitter')->first();
                $token = $tmp->auth_token;
                $this->postToTwitter($tmp->access_token_twitter,$tmp->access_token_secret_twitter, $path);

            } else {

                $tmp = DB::table('social_login')->select('auth_token')->where('sp_user_id','=',$user_id)->where('type','=','linkedin')->first();
                $token = $tmp->auth_token;
                $this->postToLinkedIn($post->sp_social_type, $token, $post->sp_media_path);
            }
        } */

        // $client = new GuzzleHttp(['base_uri' => 'https://api.linkedin.com']);
       
        // $token = "AQUoasYR3_t6G1IV4e2z8-UlRbhL7WxuN9dtBrA35kCKz2i7M5CRD_mYJIZC0iv04Xc3LKcYihXDx9209v4rYLOAXInZOXFBEPIp2qwfXZ4RJQSe2ZnTQxo3vH3FRseBcIi-WeFUb8FOJMAr47CVxGLaVe3a8qmwHyDQIt1qK1QwFRNE40p-kVfC_aYZJhXtcKVIp7A8Kwq8HbqM6Bm68wpP2s7ahHYZvhPRqOppCsBR0AV2M2fup4iGKCOJ-mDkHWhW4enFBIMHG1ao_OUkiO02-7ohk00zYOqmPq2AcHSSbRSBZnUmsMBVIPlicyB6HPXrvzQYPgca9scPO4pIcXAvXPKeTg";
        // $result = LinkedIn::shareImage($token, $img_path, "Test video", 'access_token');
        // $video = public_path('\img\big_buck_bunny_720p_1mb.mp4');
        // $result = LinkedIn::shareVideo($token, $video, "Test video", 'access_token');


          return response()->json(['status' => true,'message'=>"Post Schedule added Successfully",'data'=>'$result' ]);
    }

    function postToLinkedIn($isImage, $token, $path){
        if($isImage == 1){
            $result = LinkedIn::shareImage($token, $path, "Digital Post", 'access_token');
        } else {
            $result = LinkedIn::shareVideo($token, $path, "Digital Post", 'access_token');
        }
    }

    function postToTwitter($token, $access_token, $file_path){
        $config = config('services.facebook');
        Twitter::reconfig(['consumer_key' => $config['consumer_key'], 'consumer_secret' => $config['consumer_secret'], 'token' => $token, 'secret' => $access_token]);

        $uploaded_media = Twitter::uploadMedia(['media' =>Storage::get($file_path)]);

        Twitter::postTweet(['status' => 'Digital Post', 'media_ids' => $uploaded_media->media_id_string, 'response_format' => 'json']);
    }

    function postToFacebook($token, $path){
        $config = config('services.facebook');
        $fb = new Facebook([
            'app_id' => $config['client_id'],
            'app_secret' => $config['client_secret'],
            'default_graph_version' => 'v2.6',
        ]);
        $fb->setDefaultAccessToken($token);
        try {
            $response = $fb->post('/me/feed', [
                'message' => 'Test',
                'source' => $fb->fileToUpload($path)
            ])->getGraphNode()->asArray();
            if($response['id']){
                // post created
            }
        } catch (FacebookSDKException $e) {
            dd($e); // handle exception
        }
    }



    // -------------------- Political Business

    public function getPoliticalCategory(){
        $cat_list = PoliticalCategory::where('pc_is_deleted','=',0)->get();

        foreach($cat_list as &$cat){
            if($cat->pc_image != ''){
                $cat->pc_image = Storage::url($cat->pc_image);
            } else {
                $cat->pc_image = "https://digitalpost365.sgp1.digitaloceanspaces.com/public/images/7MO5rYc1618656161.jpg";
            }
        }

        if(!$cat_list){
            return response()->json(['status' => false,'message'=>"Category not available" ]);
        }

        return response()->json(['status' => true,'message'=>"Category list retrived Successfully",'category_list'=>$cat_list ]);
    }

    public function addPoliticalBusiness(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $name = $input['name'];
        $designation = $input['designation'];
        $mobile = $input['mobile'];
        $pb_mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $party_id = $input['party_id'];
        
        
        $logo = $request->file('party_logo');
        $watermark = $request->file('watermark');
        $left_image = $request->file('left_image');
        $right_image = $request->file('right_image');
        
        $facebook = isset($input['facebook']) ? $input['facebook'] : "";
        $twitter =  isset($input['twitter']) ? $input['twitter'] : "";
        $instagram =  isset($input['instagram']) ? $input['instagram'] : "";
        $linkedin =  isset($input['linkedin']) ? $input['linkedin'] : "";
        $youtube =  isset($input['youtube']) ? $input['youtube'] : "";

        $logo_path = '';
        $watermark_path = '';
        $left_image_path = '';
        $right_image_path = '';

        if($watermark != null){
            $watermark_path  =  $this->uploadFile($request, null,"watermark", 'political-business-img');
        }

        if($logo != null){
            $logo_path  =  $this->uploadFile($request, null,"party_logo", 'political-business-img');
        }

        if($left_image != null){
            $left_image_path  =  $this->uploadFile($request, null,"left_image", 'political-business-img');
        } 

        if($right_image != null){
            $right_image_path  =  $this->uploadFile($request, null,"right_image", 'political-business-img');
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
        $business->pb_left_image = $left_image_path;
        $business->pb_right_image = $right_image_path;
        $business->pb_facebook = $facebook;
        $business->pb_twitter = $twitter;
        $business->pb_instagram = $instagram;
        $business->pb_linkedin = $linkedin;
        $business->pb_youtube = $youtube;
        $business->save();
        
        $business_id = $business->id;

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
        return response()->json(['status'=>true,'message'=>'Data successfully Added']);
    }

    public function updatePoliticalbusiness(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        $getBusiness = PoliticalBusiness::where('pb_id','=',$input['id'])->where('user_id', $user_id)->first();
        if(empty($getBusiness)){
            return response()->json(['status'=>false,'message'=>'Something goes wrong']);
        }
        $name = $input['name'];
        $designation = $input['designation'];
        $mobile = $input['mobile'];
        $pb_mobile_second = (isset($input['mobile_second'])) ? $input['mobile_second'] : '';
        $party_id = $input['party_id'];
        
        $logo = $request->file('party_logo');
        $watermark = $request->file('watermark');
        $left_image = $request->file('left_image');
        $right_image = $request->file('right_image');
        
        $facebook = $input['facebook'];
        $twitter = $input['twitter'];
        $instagram = $input['instagram'];
        $linkedin = $input['linkedin'];
        $youtube = $input['youtube'];

        $logo_path = '';
        $watermark_path = '';
        $left_image_path = '';
        $right_image_path = '';

        if($watermark != null){
            $watermark_path  =  $this->uploadFile($request, null,"watermark", 'political-business-img');
        } else {
            $watermark_path = $getBusiness->pb_watermark;
        }

        if($logo != null){
            $logo_path  =  $this->uploadFile($request, null,"party_logo", 'political-business-img');
        } else {
            $logo_path = $getBusiness->pb_party_logo;
        }

        if($left_image != null){
            $left_image_path  =  $this->uploadFile($request, null,"left_image", 'political-business-img');
        } else {
            $left_image_path = $getBusiness->pb_left_image;
        }
 
        if($right_image != null){
            $right_image_path  =  $this->uploadFile($request, null,"right_image", 'political-business-img');
        } else {
            $right_image_path = $getBusiness->pb_right_image;
        }

        // if($right_image != null || $left_image != null || $logo != null || $name != $getBusiness->pb_name){

        //     $business_approval = PoliticalBusinessApprovalList::updateOrCreate(
        //         ['pb_id' => $input['id']],
        //         ['pbal_name' => $name,
        //         'user_id' => $user_id,
        //         'pbal_designation' => $designation,
        //         'pbal_mobile' => $mobile,
        //         'pbal_pc_id' => $party_id,
        //         'pbal_party_logo' => $logo_path,
        //         'pbal_watermark' => $watermark_path,
        //         'pbal_left_image' => $left_image_path,
        //         'pbal_right_image' => $right_image_path,
        //         'pbal_facebook' => $facebook,
        //         'pbal_twitter' => $twitter,
        //         'pbal_instagram' => $instagram,
        //         'pbal_linkedin' => $linkedin,
        //         'pbal_youtube' => $youtube
        //     ]);
        // }

        
        // $business = PoliticalBusiness::where('pb_id','=',$input['id'])->update([
        // // 'pb_name' => $name;
        // 'user_id' => $user_id,
        // 'pb_designation' => $designation,
        // 'pb_mobile' => $mobile,
        // 'pb_mobile_second' => $pb_mobile_second,
        // 'pb_pc_id' => $party_id,
        // // 'pb_party_logo' => $logo_path,
        // 'pb_watermark' => $watermark_path,
        // // 'pb_left_image' => $left_image_path,
        // // 'pb_right_image' => $right_image_path,
        // 'pb_facebook' => $facebook,
        // 'pb_twitter' => $twitter,
        // 'pb_instagram' => $instagram,
        // 'pb_linkedin' => $linkedin,
        // 'pb_youtube' => $youtube,
        // ]);
        // if($right_image != null || $left_image != null || $logo != null || $name != $getBusiness->pb_name){
        //     return response()->json(['status'=>true,'message'=>'Please wait till admin approves your changes!']);
        // } else {
        //     return response()->json(['status'=>true,'message'=>'Business information update']);
        // }

        $_isPremiumUser = DB::table('purchase_plan')->where('purc_business_type', 2)->where('purc_business_id','=', $input['id'])->where('purc_plan_id','!=',3)->first();

        if(!empty($_isPremiumUser) || $_isPremiumUser != '' || $_isPremiumUser != null){

            // if($right_image != null || $left_image != null || $logo != null || $name != $getBusiness->pb_name){
            if($name != $getBusiness->pb_name){

                $business_approval = PoliticalBusinessApprovalList::updateOrCreate(
                    ['pb_id' => $input['id']],
                    ['pbal_name' => $name,
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
                ]);
            }

            
            $business = PoliticalBusiness::where('pb_id','=',$input['id'])->update([
            // 'pb_name' => $name;
            'user_id' => $user_id,
            'pb_designation' => $designation,
            'pb_mobile' => $mobile,
            'pb_mobile_second' => $pb_mobile_second,
            'pb_pc_id' => $party_id,
            'pb_party_logo' => $logo_path,
            'pb_watermark' => $watermark_path,
            'pb_left_image' => $left_image_path,
            'pb_right_image' => $right_image_path,
            'pb_facebook' => $facebook,
            'pb_twitter' => $twitter,
            'pb_instagram' => $instagram,
            'pb_linkedin' => $linkedin,
            'pb_youtube' => $youtube,
            ]);
            if($right_image != null || $left_image != null || $logo != null || $name != $getBusiness->pb_name){
                return response()->json(['status'=>true,'message'=>'Please wait till admin approves your changes!']);
            } else {
                return response()->json(['status'=>true,'message'=>'Business information update']);
            }
        }
        else {
            $business = PoliticalBusiness::where('pb_id','=',$input['id'])->update([
            'pb_name' => $name,
            'user_id' => $user_id,
            'pb_designation' => $designation,
            'pb_mobile' => $mobile,
            'pb_mobile_second' => $pb_mobile_second,
            'pb_pc_id' => $party_id,
            'pb_party_logo' => $logo_path,
            'pb_watermark' => $watermark_path,
            'pb_left_image' => $left_image_path,
            'pb_right_image' => $right_image_path,
            'pb_facebook' => $facebook,
            'pb_twitter' => $twitter,
            'pb_instagram' => $instagram,
            'pb_linkedin' => $linkedin,
            'pb_youtube' => $youtube,
            ]);
            return response()->json(['status'=>true,'message'=>'Business information update']);
        }
        
    }

    public function getmyAllPoliticalBusinessList(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        // $businessList = PoliticalBusiness::with('PoliticalCategory')->where('user_id','=',$user_id)->get();
        $businessList = DB::table('political_business')->leftJoin('political_category','political_category.pc_id','=','political_business.pb_pc_id')->leftJoin('purchase_plan','purchase_plan.purc_business_id','=','political_business.pb_id')->leftJoin('plan','plan.plan_id','=','purchase_plan.purc_plan_id')->where('user_id','=',$user_id)->where('pb_is_deleted','=',0)->where('purchase_plan.purc_business_type','=',2)->get();

        $defaultBusinessId = User::where('id','=',$user_id)->select('default_political_business_id')->first();
        

        foreach($businessList as &$business){
            $business->pb_party_logo = ($business->pb_party_logo) ? Storage::url($business->pb_party_logo) : '';
            $business->pb_watermark = ($business->pb_watermark) ? Storage::url($business->pb_watermark) : '';
            $business->pb_left_image = ($business->pb_left_image) ? Storage::url($business->pb_left_image) : '';
            $business->pb_right_image = ($business->pb_right_image) ? Storage::url($business->pb_right_image) : '';
            if($defaultBusinessId->default_political_business_id == $business->pb_id){
                $business->is_Default = 'yes';
            } else {
                $business->is_Default = 'no';
            }
            $business->purc_order_id = ($business->purc_order_id) ? $business->purc_order_id : '';
            $business->purc_end_date = ($business->purc_end_date) ? $business->purc_end_date : '';
            $business->device = ($business->device) ? $business->device : '';

            $business->plan_information = ($business->plan_information) ? unserialize($business->plan_information) : '';

            if($business->purc_plan_id != 3){
                // $plantrial = Plan::where('plan_sku','=','Free')->select('plan_validity')->first();
                $start_date = strtotime($business->purc_start_date);
                $end_date = strtotime($business->purc_end_date);
                // $days = ($end_date - $start_date)/60/60/24;
                $business->remaining_days = '0 Days';
                $today = strtotime(date('Y-m-d'));
                if($today > $end_date && ($business->purc_is_expire == 1 || $business->purc_is_expire == "1")){
                    $business->remaining_days = '0 Days';
                } else {
                    $days = ($end_date - $today)/60/60/24;
                    $business->remaining_days = $days.' Days';
                }
            } else {
                $business->remaining_days = '0 Days';
            }
        }

        if(!$businessList){
            return response()->json(['status' => false,'message'=>"Business not available" ]);
        }

        return response()->json(['status' => true,'message'=>"business list retrived Successfully",'business_list'=>$businessList ]);
        
    }

    public function removePoliticalBusiness(Request $request){
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);

        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }

        if(!isset($input['id']) || $input['id'] == ''){
            return response()->json(['status'=>false,'message'=>'post you are looking for is not availabe']);
        }

        $getbusiness = DB::table('political_business')->select('pb_party_logo','pb_watermark','pb_left_image','pb_right_image')->where('pb_id','=',$input['id'])->where('user_id', $user_id)->first();
        $user_data = User::find($user_id);
        if(empty($getbusiness)){
            return response()->json(['status'=>false,'message'=>'Something goes wrong']);
        }
        if($getbusiness){
            $affected = DB::table('political_business')->where('pb_id', $input['id'])->update(['pb_is_deleted' => 1]);
            $getbusiness_approve = DB::table('political_business_approval_list')->select('pbal_party_logo','pbal_watermark','pbal_left_image','pbal_right_image')->where('pb_id','=',$input['id'])->first();
            if($getbusiness_approve){
             $affected = DB::table('political_business_approval_list')->where('pb_id', $input['id'])->update(['pbal_is_deleted' => 1]);
            }
        }
        if($user_data->default_political_business_id == $input['id']) {
            $currntbusiness = Business::where('user_id','=',$user_id)->where('busi_delete','=',0)->select('busi_id')->first();
                
            if(!empty($currntbusiness) || !is_null($currntbusiness)){
                User::where('id', $user_id)->update(array(
                    'default_business_id' => $currntbusiness->busi_id,
                ));
            } else {
                User::where('id', $user_id)->update(array(
                    'default_business_id' => 0,
                ));
            }
        }


        // if($getbusiness){
        //     $pb_party_logo = $getbusiness->pb_party_logo;
        //     $pb_watermark = $getbusiness->pb_watermark;
        //     $pb_left_image = $getbusiness->pb_left_image;
        //     $pb_right_image = $getbusiness->pb_right_image;
        //     Storage::delete($pb_party_logo);
        //     Storage::delete($pb_watermark);
        //     Storage::delete($pb_party_logo);
        //     Storage::delete($pb_right_image);
        //     DB::table('political_business')->where('pb_id', '=', $input['id'])->delete();

        //     $getbusiness_approve = DB::table('political_business_approval_list')->select('pbal_party_logo','pbal_watermark','pbal_left_image','pbal_right_image')->where('pb_id','=',$input['id'])->first();
        //     if($getbusiness_approve){
        //         $pbal_party_logo = $getbusiness_approve->pbal_party_logo;
        //         $pbal_watermark = $getbusiness_approve->pbal_watermark;
        //         $pbal_left_image = $getbusiness_approve->pbal_left_image;
        //         $pbal_right_image = $getbusiness_approve->pbal_right_image;
        //         Storage::delete($pbal_party_logo);
        //         Storage::delete($pbal_watermark);
        //         Storage::delete($pbal_party_logo);
        //         Storage::delete($pbal_right_image);
        //         DB::table('political_business_approval_list')->where('pb_id', '=', $input['id'])->delete();
        //     }    

        // } else {
        //     return response()->json(['status'=>false,'message'=>'post you are looking for is not availabe']);
        // }

        return response()->json(['status' => true,'message'=>"Business successfully removed"]);

    }

    public function markCurrentBusinessForPolitic(Request $request){
        $input = $request->all(); 

        $user_id = $this->get_userid($input['token']);
        if($user_id == 0){
            return response()->json(['status'=>false,'message'=>'user not valid']);
        }
        
        $business_id = $input['business_id'];
        
        User::where('id', $user_id)->update(array(
            'default_political_business_id' => $business_id,
        ));
        $user_data = User::find($user_id);
        $frameList = DB::table('user_frames')->where('user_id','=',$user_id)->where('business_id','=',$user_data->default_business_id)->where('is_deleted','=',0)->where('business_type','=',2)->orderBy('user_frames_id','DESC')->get();
        
        $frameLists = array();
        
        if(!empty($frameList)){
            foreach ($frameList as $key => $value) 
            {
                $data = array();
                
                $data['business_id'] = strval($value->business_id);
                $data['date_added'] = !empty($value->date_added)?$value->date_added:"";
                $data['frame_url'] = !empty($value->frame_url)?Storage::url($value->frame_url):"";
                $data['user_frames_id'] = strval($value->user_frames_id);
                $data['user_id'] = strval($value->user_id);
                
                array_push($frameLists, $data);
                
            }
        }
        
        
        $updatedCurrentBusinessDetails = $this->getPoliticalCurrentBusiness($user_data->default_political_business_id, $user_id);
        $retrunData;
        if($updatedCurrentBusinessDetails[0]){
            $retrunData = $updatedCurrentBusinessDetails[0];
        } else {
            $retrunData = (object)[];
        }

        return response()->json(['status'=>true,'message'=>'Set successfuly','frameList' => $frameLists, 'current_business'=> $retrunData]);
    }

    function getPoliticalCurrentBusiness($political_business_id,$user_id){
        $currntbusiness = PoliticalBusiness::where('pb_id','=',$political_business_id)->where('pb_is_deleted','=',0)->first();
        $updatedCurrentBusinessDetails = array();

        $ispreminum = false;
        if($currntbusiness != null || !empty($currntbusiness) || $currntbusiness != ''){
            $priminum = Purchase::where('purc_business_id','=',$political_business_id)->where('purc_business_type','=',2)->select('purc_id','purc_plan_id','purc_start_date','purc_end_date')->first();
            
            if(!empty($priminum) || $priminum != null || $priminum != ''){
                $start_dates = date('Y-m-d');
                if($priminum->purc_plan_id != 3){
                    // $plantrial = Plan::where('plan_sku','=','000FREESKU')->select('plan_validity')->first();
                    $plantrial = Plan::where('plan_id','=',$priminum->purc_plan_id)->select('plan_validity')->first();
                    $start_date = strtotime($start_dates); 
                    $end_date = strtotime($priminum->end_date); 
                    $days = ($end_date - $start_date)/60/60/24;
                    if($days > $plantrial->plan_validity && $days > 0){
                        $ispreminum = false;
                    } else {
                        $ispreminum = true;
                    }
                } else {
                    $ispreminum = false;
                }
                // if($priminum->purc_plan_id == 3){
                   
                //      $ispreminum = false;
                        
                // }
                
                // if($priminum->purc_plan_id == 2){
                //     $ispreminum = true;
                // }
                 
            } else{
                $ispreminum = false;
            }


            $updatedCurrentBusinessDetails['pb_id'] = strval($currntbusiness->pb_id);
            $updatedCurrentBusinessDetails['user_id'] = strval($currntbusiness->user_id);
            $updatedCurrentBusinessDetails['pb_name'] = !empty($currntbusiness->pb_name)?$currntbusiness->pb_name:"";
            $updatedCurrentBusinessDetails['pb_mobile'] = !empty($currntbusiness->pb_mobile)?$currntbusiness->pb_mobile:"";
            $updatedCurrentBusinessDetails['pb_mobile_second'] = !empty($currntbusiness->pb_mobile_second)?$currntbusiness->pb_mobile_second:"";
            $updatedCurrentBusinessDetails['pb_designation'] = !empty($currntbusiness->pb_designation)?$currntbusiness->pb_designation:"";
            $updatedCurrentBusinessDetails['pb_party_logo'] = !empty($currntbusiness->pb_party_logo)?Storage::url($currntbusiness->pb_party_logo):"";
            $updatedCurrentBusinessDetails['pb_watermark'] = !empty($currntbusiness->pb_watermark)?Storage::url($currntbusiness->pb_watermark):"";
            $updatedCurrentBusinessDetails['pb_left_image'] = !empty($currntbusiness->pb_left_image)?Storage::url($currntbusiness->pb_left_image):"";
            $updatedCurrentBusinessDetails['pb_right_image'] = !empty($currntbusiness->pb_right_image)?Storage::url($currntbusiness->pb_right_image):"";

            $updatedCurrentBusinessDetails['pb_facebook'] = !empty($currntbusiness->pb_facebook)?$currntbusiness->pb_facebook:"";
            $updatedCurrentBusinessDetails['pb_twitter'] = !empty($currntbusiness->pb_twitter)?$currntbusiness->pb_twitter:"";
            $updatedCurrentBusinessDetails['pb_instagram'] = !empty($currntbusiness->pb_instagram)?$currntbusiness->pb_instagram:"";
            $updatedCurrentBusinessDetails['pb_linkedin'] = !empty($currntbusiness->pb_linkedin)?$currntbusiness->pb_linkedin:"";
            $updatedCurrentBusinessDetails['pb_youtube'] = !empty($currntbusiness->pb_youtube)?$currntbusiness->pb_youtube:"";
            $updatedCurrentBusinessDetails['pb_is_approved'] = strval($currntbusiness->pb_is_approved);
            $updatedCurrentBusinessDetails['pb_is_deleted'] = strval($currntbusiness->pb_is_deleted);

            $p_plan = Purchase::where('purc_user_id',$user_id)->where('purc_business_id',$political_business_id)->where('purc_business_type','=',2)->get();
            $plan_name = "";
            if (count($p_plan) != 0) 
            {
                foreach ($p_plan as $key => $value) 
                {
                    if ($value->purc_is_cencal == 0 && $value->purc_is_expire == 0) 
                    {

                    //    if ($value->purc_plan_id == 2) 
                       if ($value->purc_plan_id != 3) 
                       {
                           $plan_name = 'Premium';
                           $updatedCurrentBusinessDetails['status'] = 1;
                       }
                       elseif ($value->purc_plan_id == 3) 
                       {
                           $plan_name = 'Free';
                           $updatedCurrentBusinessDetails['status'] = 0;
                       }
                    }
                    else
                    {
                        $plan_name = 'Free';
                        $updatedCurrentBusinessDetails['status'] = 0;
                    }
                }
            }
            else
            {
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
        array_push($array,$updatedCurrentBusinessDetails);
        array_push($array,$ispreminum);

        return $array;
    }


    public function GetAllBusinessCategory(Request $request)
    {
        $category_data = DB::table('business_category')->where('is_delete','=',0)->get();

        $category = array();

        $keyval = 0;
        foreach ($category_data as $key => $value) 
        {
            $data = array();    
            $data['id'] = strval($value->id);
            $data['category_name'] = !empty($value->name)?$value->name:"";
            $data['image'] = !empty($value->image)? Storage::url($value->image):"";
            array_push($category,$data);
            
        }

        return response()->json(['business_category'=>$category]);
    }

    public function sendOTP($country_code, $mobile, $otp) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,'https://2factor.in/API/V1/5ac4e318-8b73-11ea-9fa5-0200cd936042/SMS/'.$country_code.$mobile.'/'.$otp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = json_decode(curl_exec($ch),true);

        curl_close($ch);
        if($server_output['Status'] == "Success") {
            return true;
        }
        return false;
    }
    
}