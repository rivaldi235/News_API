<?php

namespace App\Listeners;

use App\Events\PostDeleted;
use App\Models\DeletePostActivityLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletedPostLog
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
    public function handle(PostDeleted $event): void
    {
        DeletePostActivityLog::create([
            'description' => 'create post'.$event->post->title
        ]);
    }
}
