<?php

namespace App\Listeners;

use App\Events\PostRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RegisterLog
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostRegistered $event): void
    {
        //use log for register
        Log::info('New Post Registered: '.$event->post->title);
    }
}
