<?php

namespace App\Listeners;

use App\Events\PostUpdated;
use App\Models\UpdatePostActivityLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatedPostLog
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
    public function handle(PostUpdated $event): void
    {
        UpdatePostActivityLog::create([
            'description' => 'create post'.$event->post->title
        ]);
    }
}
