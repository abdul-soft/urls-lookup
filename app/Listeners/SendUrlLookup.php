<?php

namespace App\Listeners;

use App\Events\UrlLookup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUrlLookup
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UrlLookup  $event
     * @return void
     */
    public function handle(UrlLookup $event)
    {
        //
    }
}
