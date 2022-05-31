<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\DownloadLimit;

class DownloadLimitController extends Controller
{
    public function index(Request $request)
    {
        $limit = DownloadLimit::first();
        if (empty($limit)) {
            $limit = new DownloadLimit;
            $limit->business_photo_limit = 5;
            $limit->business_video_limit = 5;
            $limit->festival_photo_limit = 5;
            $limit->festival_video_limit = 5;
            $limit->greeting_photo_limit = 5;
            $limit->save();
        }
        return view('user::donwload-limit', compact('limit'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'business_photo_limit' => 'required',
                'business_video_limit' => 'required',
                'festival_photo_limit' => 'required',
                'festival_video_limit' => 'required',
                'incident_photo_limit' => 'required',
                'incident_video_limit' => 'required',
                'greeting_photo_limit' => 'required',
            ],
            [
                'business_photo_limit.required' => 'Business photo limit Is Required',
                'business_video_limit.required' => 'Business video limit Is Required',
                'festival_photo_limit.required' => 'Festival photo limit Is Required',
                'festival_video_limit.required' => 'Festival video limit Is Required',
                'incident_photo_limit.required' => 'Incident photo limit Is Required',
                'incident_video_limit.required' => 'Incident video limit Is Required',
                'greeting_photo_limit.required' => 'Greeting photo limit Is Required',
            ]
        );

        if ($validator->fails()) {
            $error = json_decode($validator->errors());

            return response()->json(['status' => 401, 'error1' => $error]);
            exit();
        }

        $limit = DownloadLimit::first();
        if (empty($limit)) {
            $limit = new DownloadLimit;
        }

        $limit->business_photo_limit = $request->business_photo_limit;
        $limit->business_video_limit = $request->business_video_limit;
        $limit->festival_photo_limit = $request->festival_photo_limit;
        $limit->festival_video_limit = $request->festival_video_limit;
        $limit->incident_photo_limit = $request->incident_photo_limit;
        $limit->incident_video_limit = $request->incident_video_limit;
        $limit->greeting_photo_limit = $request->greeting_photo_limit;
        $limit->save();

        return response()->json(['status' => true, 'message' => 'Limit updated']);
    }
}
