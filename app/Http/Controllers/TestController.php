<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\DeleteDuplicateDevice;
use DB;
class TestController extends Controller
{
    public function test($offset = 0)
    {
        // phpinfo();
        
        DeleteDuplicateDevice::dispatch(0, 500);
        dd("Queue Started");


        // $allDeviceCount = DB::table('user_device1')->count();
        // $total_device_id = DB::table('user_device1')->select('device_id')->groupBy('device_id')->pluck('device_id')->count();
        // // dd($allDeviceCount, $total_device_id);
        // $deviceids = DB::table('user_device1')->select('device_id')->groupBy('device_id')->offset($offset)->limit(1000)->pluck('device_id');
        // $new_offset = $offset + count($deviceids);
        // foreach($deviceids as $mainKey=>$device_id) {
        //     $allDevice = DB::table('user_device1')->where('device_id', $device_id)->orderBy('id','DESC')->get();
        //     foreach($allDevice as $key=>$device) {
        //         if($key != 0) {
        //             // $device->delete();
        //             DB::delete('delete from user_device1 where id = ?',[$device->id]);
        //         }
        //     }
        // }
        // dd("Total => " . $allDeviceCount, "Total Device =>" . $total_device_id, "offset => " . $new_offset);
    }

}
