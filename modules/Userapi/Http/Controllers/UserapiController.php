<?php

namespace Modules\Userapi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Business;
use App\Post;
use App\Festival;
use App\Purchase;
use App\Photos;
use App\Plan;
use DB;
use GDText\Box;
use GDText\Color;

class UserapiController extends Controller
{
    public $successStatus = 200;
    public function register(Request $request) 
    {   
        $input = $request->all(); 

        // $token = Str::random(60);
        $token = Hash::make($input['email'], [
            'rounds' => 12
        ]);
        $ref_code = Str::random(6);

        // print_r($input);die;
        // $user = User::where('email', '=', $input['email'])->orWhere('mobile', '=', $input['mobile'])->select('email','mobile')->first();
        $user = User::where('mobile', '=', $input['mobile'])->select('mobile')->first();
        if($user == null){
            $user = new User();
            $user->name = $input['name'];
            $user->email = $input['email'];
            $user->password = bcrypt($input['name'].'@123');
            $user->mobile = $input['mobile'];
            $user->remember_token = $token;
            $user->ref_code = $ref_code;
            $user->device_id = $input['device_id'];
            $user->device_token = $input['device_token'];
            $user->save();

            $newuserid = $user->id;

            if($input['ref_code'] != ''){
                $credit = DB::table('setting')->where('setting_id','=',1)->select('credit')->first();
                $usercredit = DB::table('users')->where('ref_code', '=', $input['ref_code'])->select('user_credit','id')->first();
                
            
                // $newcredit = intval($usercredit->user_credit) + intval($credit->credit);
          
                $reffarray = array();
                array_push($reffarray, $newuserid);


                User::where('ref_code','=', $input['ref_code'])->update(array(
                    'ref_users' => serialize($reffarray),
                ));

                DB::insert('insert into refferal_data (ref_by_user_id,	ref_user_id) values (?, ?)', [$usercredit->id, $newuserid]);
                
            }
            $user = User::where('mobile','=',$input['mobile'])->first();
            return response()->json(['data' => $user,'token'=> $token, 'status'=>true,'message'=>'Register Successfully']); 

        } else {
            
            // if($user->email == $input['email']){
            //     return response()->json(['status'=>false,'message'=>'Email Already Registered']); 
            // } else {
                return response()->json(['status'=>false,'message'=>'Mobile Already Registered']); 
            // }

        }

    }

    public function login(Request $request){ 
         $input = $request->all(); 
         $mobile = $input['mobile'];
         $user = User::where('mobile','=',$mobile)->first();

        if(!empty($user) || $user != ''){ 
            // $token = Str::random(60);
            if($user->status == 0){
                       $token = Hash::make($user->email, [
                    'rounds' => 12
                ]);
                User::where('mobile','=', $mobile)->update(array(
                    'remember_token' => $token,
                    'device_id' => $input['device_id'],
                    'device_token' => $input['device_token'],
                ));
                
                $isbusiness = false;
                
                if($user->default_business_id != '' || $user->default_business_id != 0){
                    $isbusiness = true;
                }
                return response()->json(['data' => $user, 'token'=> $token, 'status'=>true,'message'=>'Login Successfully', 'isbusiness' => $isbusiness]); 
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

            User::where('remember_token', $input['token'])->update(array(
                'remember_token' => '',
                'device_token' => ''
            ));

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

            User::where('id', $user_id)->update(array(
                'name'=>$request['name'],
                'mobile'=>$request['mobile'],
                'email'=>$request['email'],
            ));

            return response()->json(['status'=>true,'message'=>'Account Information Successfully Update']); 

        }
        
    }
    public function getMyProfile(Request $request){

        $input = $request->all(); 
        $userdata = User::where('remember_token','=',$input['token'])->first()->toArray();

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
        $userdata = User::where('remember_token','=',$token)->select('id')->first();
        if($userdata != null || !empty($userdata) || $userdata != ''){
            $user_id = $userdata->id;
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
        $website = $input['website'];
        $address = $input['address'];
        $logo = $request->file('logo');
         $path = '';
        if($logo != null){
            $filename = Str::random(7).time().'.'.$logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $filename);

            $path = url('/').'/public/images/'.$filename;
        } 
            $business = new Business();
            $business->busi_name = $name;
            $business->user_id = $user_id;
            $business->busi_email = $email;
            $business->busi_website = $website;
            $business->busi_mobile = $mobile;
            $business->busi_address = $address;
            $business->busi_logo = $path;
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
        
        return response()->json(['status'=>true,'message'=>'Set successfuly']);
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
        $logo = $request->file('logo');

        $currntbusiness = Business::where('busi_id','=',$id)->select('busi_name','busi_logo')->first();
        if(!is_null($currntbusiness)){
           
            $namechange = false;
            if($currntbusiness->busi_name != $name){
                $namechange = true;
                $name = $input['name'];
            } else {
                $namechange = false;
                $name = $currntbusiness->busi_name;
            }

            if(($logo != null && $namechange) || ($logo != null && !$namechange) || $namechange){

                if($logo != null){
                    $filename = Str::random(7).time().'.'.$logo->getClientOriginalExtension();
                    $logo->move(public_path('images'), $filename);
                    $path = url('/').'/public/images/'.$filename;
                } else {
                    $path = $currntbusiness->busi_logo;
                }
                    
                Business::where('busi_id', $id)->update(array(
                    'busi_is_approved' => 0
                ));
                
                $_isBusinessAvail = DB::table('business_new')->where('busi_id_old','=', $id)->select('user_id_new')->first();

                if(is_null($_isBusinessAvail)){
                    DB::table('business_new')->insert(
                        [
                        'busi_name_new' => $name,
                        'user_id_new' => $user_id,
                        'busi_email_new' => $email,
                        'busi_website_new' => $website,
                        'busi_mobile_new' => $mobile,
                        'busi_address_new' => $address,
                        'busi_logo_new' => $path,
                        'busi_is_approved_new' => 0,
                        'busi_id_old' => $id
                        ]
                    );
                } else {
                    DB::table('business_new')
                      ->where('busi_id_old', $id)
                      ->update([
                        'busi_name_new' => $name,
                        'user_id_new' => $user_id,
                        'busi_email_new' => $email,
                        'busi_website_new' => $website,
                        'busi_mobile_new' => $mobile,
                        'busi_address_new' => $address,
                        'busi_logo_new' => $path,
                        'busi_is_approved_new' => 0,
                        'busi_id_old' => $id
                        ]);
                }
               

                 return response()->json(['status'=>true,'message'=>'Please wait till admin approves your changes!']);

            } else {
                Business::where('busi_id', $id)->update(array(
                    'busi_email' => $email,
                    'user_id' => $user_id,
                    'busi_website' => $website,
                    'busi_mobile' => $mobile,
                    'busi_address' => $address,
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
        // $listofbusiness = Business::where('user_id','=',$user_id)->where('busi_delete','=',0)->get();
        $listofbusiness = DB::table('business')->where('user_id','=',$user_id)->where('busi_delete','=',0)->leftJoin('purchase_plan','business.busi_id','=','purchase_plan.purc_business_id')->leftJoin('plan','purchase_plan.purc_plan_id',
            '=','plan.plan_id')->select('business.busi_id','business.busi_name','business.busi_email','business.busi_address','business.busi_mobile','business.busi_logo','business.busi_website','plan.plan_name','plan.plan_id','purchase_plan.purc_start_date','purchase_plan.purc_end_date','purchase_plan.purc_plan_id')->distinct()->get()->toArray();
        
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
            if($business['plan_id'] == 1 || $business['plan_id'] == 3 ){
                $business['need_to_upgrade'] = 1;
            } else {
                $business['need_to_upgrade'] = 0;
            }
            array_push($finale_array,$business);
            // print_r($business);
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
                User::where('id', $user_id)->update(array(
                    'default_business_id' => 0,
                ));
            // }
            return response()->json(['status' => true,'message'=>'Business Succesfully Removed']);
        } else {
            return response()->json(['status' => false,'message'=>'You can not remove current business']);
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
                $frame->frame_url = url('/').$frame->frame_url;
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

    public function getMonthsPost(Request $request){

         $input = $request->all();

            $posts = Post::where('post_category_id','=',$input['postcategoryid'])->where('post_is_deleted','=',0)->orderBy('post_id','DESC')->get();

        if(!empty($posts)){
            return response()->json(['data' => $posts,'status' => true,'message'=>'List of all festival']);
        } else {
            return response()->json(['status' => fasle,'message'=>'There is no festival in this month']);

        }
    }

    public function getDays(Request $request){
        
        $input = $request->all();
        $user_id = $this->get_userid($input['token']);
        $currnt_date = date('Y-m-d');
        $festivals = array();
        if($input['date'] != ''){
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
      
        for ($i=0; $i < sizeof($festivals); $i++) { 
            $festivals[$i]['fest_day'] = date_parse_from_format('Y-m-d', $festivals[$i]['fest_date'])['day'];
            $festivals[$i]['fest_date'] = date("d-m-Y", strtotime($festivals[$i]['fest_date']));
        }

        $userdata = User::where('id','=',$user_id)->select('default_business_id')->first();
        if(!empty($userdata)){
            $currntbusiness = Business::where('busi_id','=',$userdata->default_business_id)->where('busi_delete','=',0)->first();
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
        }
        $olddate = array();
        $newdate = array();
        $current = date('d-m-Y');
        foreach($festivals as $fest){
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
        if(!empty($festivals)){
            return response()->json(['festival' => $finalarr, 'status' => true,'message'=>'List of all festival','current_date' => $currnt_date,'ispreminum' => $ispreminum,'current_business'=>$updatedCurrentBusinessDetails, 'preference' => $preference, 'current_business_new' => $currntbusiness]);
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
                $data['banner_image'] = url('/').$value2->banner_image;
                $data['custom_cateogry_id'] = $value->custom_cateogry_id;
                $data['images']['image_one'] = url('/').$value2->image_one;
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
            $slide['slider_img'] = url('/').$value->slider_img;
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
            $value2->banner_image = url('/').$value2->banner_image;
            $value2->image_one = url('/').$value2->image_one;
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
                $fest->video_url = url('/').$fest->video_url;
                $fest->thumbnail = url('/').$fest->thumbnail;
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

        if(!empty($festivals)){
            return response()->json(['status' => true,'message'=>'Videos listed successfully', 'data' => $finalarr]);
        } else {
            return response()->json(['status' => false,'message'=>'videos not found']);
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
        $checkBusiness = Business::where('busi_id', $input['business_id'])->where('user_id', $user_id)->where('busi_delete',0)->first();
        if(empty($checkBusiness)) {
            return response()->json(['status'=>false,'message'=>'Something goes wrong']);
        }
        // $results = DB::select('select * from  refferal_data where ref_user_id = ?', [$user_id]);
        $is_purchasebeforee = DB::table('purchase_plan')->where('purc_user_id','=',$user_id)->where('purc_plan_id','=',2)->select('purc_user_id')->first();
        
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
        
      	$remainingcredit = $input['remainingcredit'];
      
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
        
        
        if($plan_id == 1){
            
            $plantrial = Plan::where('plan_sku','=','000FREESKU')->select('plan_validity')->first();
            $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
                
            // $purchase = new Purchase();
            // $purchase->purc_user_id = $user_id;
            // $purchase->purc_business_id = $business_id;
            // $purchase->purc_plan_id = $plan_id;
            // $purchase->purc_start_date = $start_date;
            // $purchase->purc_end_date = $end_date;
            // $purchase->purc_order_id = $input['order_id'];
            // $purchase->save();

            Purchase::where('purc_business_id',$business_id)->update([
                'purc_plan_id'=>$plan_id,
                'purc_start_date' => $start_date,
                'purc_end_date' => $end_date,
                'purc_order_id' => $input['order_id'],
                'purc_tel_status' => 7,
                'purc_follow_up_date' => null,
            ]);
            DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 1)->delete();
            $this->addPurchasePlanHistory($business_id, 1);
            
        } else {
            $plantrial = Plan::where('plan_sku','=','premium_2599')->select('plan_validity')->first();
            $end_date = date('Y-m-d', strtotime($start_date. ' + '.$plantrial->plan_validity.' days'));
            Purchase::where('purc_business_id',$business_id)->update([
            'purc_plan_id'=>$plan_id,
            'purc_start_date' => $start_date,
            'purc_end_date' => $end_date,
            'purc_order_id' => $input['order_id'],
            'purc_tel_status' => 7,
            'purc_follow_up_date' => null,
            ]);
            DB::table('user_business_comment')->where('business_id', $business_id)->where('business_type', 1)->delete();
            $this->addPurchasePlanHistory($business_id, 1);
        }
        // $end_date = $input['end_date'];
        
        
            
        // $purchase = new Purchase();
        // $purchase->purc_user_id = $user_id;
        // $purchase->purc_business_id = $business_id;
        // $purchase->purc_plan_id = $plan_id;
        // $purchase->purc_start_date = $start_date;
        // $purchase->purc_end_date = $end_date;
        // $purchase->purc_order_id = $input['order_id'];
        // $purchase->save();
         $usercredit = DB::table('users')->where('id', '=', $user_id)->select('user_credit','id')->first();

        return response()->json(['status'=>true,'message'=>'Purchase Plan successfully Added','user_credit' => $usercredit->user_credit]);

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

        $filename = Str::random(7).time().'.'.$logo->getClientOriginalExtension();
        $logo->move(public_path('images'), $filename);
        $path = url('/').'/public/images/'.$filename;


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
}