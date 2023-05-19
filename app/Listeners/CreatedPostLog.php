<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Models\CreatePostActivityLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatedPostLog
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
    public function handle(PostCreated $event): void
    {
        CreatePostActivityLog::create([
            'description' => 'create post'.$event->post->title
        ]);
    }
}
