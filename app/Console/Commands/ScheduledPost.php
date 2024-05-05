<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SmmPost;
use App\SchedulePost;
use Log;

class ScheduledPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:scheduledPost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post scheduled social media post.';

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
        
        Log::info('Initiating Cron Job: Minute ScheduledPost');

        $start = date('h:i:s');
        
        $sp = new \App\Models\SchedulePost;
        
        $sp->checkPendingPosts();
        $sp->checkPostRepeat();
        
        $end = date('h:i:s');

        Log::info('Scheduled Post Start Time: '.$start);
        Log::info('Scheduled Post End Time: '.$end);

    }
}
