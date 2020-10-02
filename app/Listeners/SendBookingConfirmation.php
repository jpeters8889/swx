<?php

namespace App\Listeners;

use App\Events\MemberBookedOntoSession;
use App\Notifications\BookingConfirmedNotification;

class SendBookingConfirmation
{
    public function handle(MemberBookedOntoSession $event)
    {
        if ($event->member()->email === 'alisondwheatley@gmail.com') {
            return;
        }

        $event->member()->notify(new BookingConfirmedNotification($event->groupSession()));
    }
}
