<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PushNotificationScheduled;
use App\Jobs\InitPushNotification;
use Carbon\Carbon;

class SendPushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled notification';

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
        $time = Carbon::now()->addHours(5)->addMinutes(30)->toDateTimeString();
        $notifications = PushNotificationScheduled::where('status', 'Pending')->where('scheduled_date','<=', $time)->get();
        foreach($notifications as $notification) {
            InitPushNotification::dispatch($notification->id);
            $notification->status = "Completed";
            $notification->save();
        }
    }
}
