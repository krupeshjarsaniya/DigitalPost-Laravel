<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class DeleteDuplicateDevice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $offset;
    protected $limit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($offset = 0, $limit = 500)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deviceids = DB::table('user_device1')->select('device_id')->groupBy('device_id')->offset($this->offset)->limit($this->limit)->pluck('device_id');
        foreach($deviceids as $mainKey=>$device_id) {
            $allDevice = DB::table('user_device1')->where('device_id', $device_id)->orderBy('id','DESC')->get();
            foreach($allDevice as $key=>$device) {
                if($key != 0) {
                    // $device->delete();
                    DB::delete('delete from user_device1 where id = ?',[$device->id]);
                }
            }
        }
        if(count($deviceids) > 0) {
            $new_offset = $this->offset + count($deviceids);
            DeleteDuplicateDevice::dispatch($new_offset,$this->limit);
        }
    }
}
