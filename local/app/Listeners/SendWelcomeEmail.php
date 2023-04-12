<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Events\WhatIsHappening;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use DB;
class SendWelcomeEmail
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
     * @param  Registered  $event
     * @return void
     */
    public function handle(WhatIsHappening $event)
    {
        // DB::table('call_type')->insert(
        //     ['type' => '44', 'name' => 'Ajaj']
        // );
    }
}
