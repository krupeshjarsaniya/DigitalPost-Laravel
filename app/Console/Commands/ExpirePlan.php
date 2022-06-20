<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\UserDownloadHistory;
use Illuminate\Support\Facades\DB;

class ExpirePlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Plan expired after end date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info("ExpirePlan Cron Executed");

        $now = Carbon::now();
        $oldData = UserDownloadHistory::whereDate('created_at', '<', $now)->count();
        if ($oldData > 0) {
            UserDownloadHistory::whereDate('created_at', '<', $now)->delete();
        }

        DB::table('purchase_plan')->where('purc_plan_id', '!=', 3)->whereNotNull('purc_end_date')->whereDate('purc_end_date', '<', Carbon::now())->update(['purc_is_expire' => 1, 'purc_plan_id'=> 3, 'purc_end_date' => null, 'purc_tel_status' => 8]);
    }
}
