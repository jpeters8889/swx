<?php

namespace App\Listeners;

use App\Events\MemberBookedOntoSession;
use App\Notifications\BookingConfirmedNotification;

class SendBookingConfirmation
{
    public function handle(MemberBookedOntoSession $event)
    {
        $event->member()->notify(
            new BookingConfirmedNotification(
                $event->groupSession(),
                $event->requiresSeat()
            )
        );
    }
}
