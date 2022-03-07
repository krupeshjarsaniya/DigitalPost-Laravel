<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use DB;
use App\SocialLogin;
use Carbon\Carbon;
use App\Helper;
use App\Jobs\ShareSocialPostJob;

class ShareSocialPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'social:sharepost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Share Post on social media';

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
        Log::info("ShareSocialPost Cron Executed");
        $nowTime = Carbon::now();
        $minTime = Carbon::now()->subMinutes(30);
        $posts = DB::table('schedule_post')->where('is_posted', 0)->where('sp_date_time', '>=', $minTime)->where('sp_date_time', '<=', $nowTime)->get();
        foreach($posts as $post) {
            ShareSocialPostJob::dispatch($post_id);
        }
    }
}
