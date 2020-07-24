<?php

namespace App\Listeners;

use App\Events\MemberBookedOntoSession;
use App\Notifications\BookingConfirmed;

class SendBookingConfirmation
{
    public function handle(MemberBookedOntoSession $event)
    {
        $event->member()->notify(new BookingConfirmed());
    }
}
