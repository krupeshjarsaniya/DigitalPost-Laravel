<?php

namespace Modules\Userapi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Business;
use Illuminate\Support\Facades\Storage;
use App\Frame;
use App\FrameComponent;
use App\FrameText;
use App\BusinessField;
use App\UserDevice;

class UserapiControlleFrameJson extends Controller
{
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
}


