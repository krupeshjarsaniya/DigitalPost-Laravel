<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helper;

class ShareSocialPostTypeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post_id;
    protected $user_id;
    protected $type;
    protected $profile_page_id;
    protected $path;
    protected $sp_media_type;
    protected $Twitter_video_path;
    protected $sp_caption;
    protected $sp_hashtag;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post_id, $user_id, $type, $profile_page_id, $path, $sp_media_type, $Twitter_video_path, $sp_caption, $sp_hashtag)
    {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->profile_page_id = $profile_page_id;
        $this->path = $path;
        $this->sp_media_type = $sp_media_type;
        $this->Twitter_video_path = $Twitter_video_path;
        $this->sp_caption = $sp_caption;
        $this->sp_hashtag = $sp_hashtag;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Helper::sharePostToSocialMedia($this->post_id, $this->user_id, $this->type, $this->profile_page_id, $this->path, $this->sp_media_type, $this->Twitter_video_path, $this->sp_caption, $this->sp_hashtag);
    }
}
