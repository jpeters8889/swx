<?php

namespace App\Listeners;

use App\Events\MemberBookingCancelled;
use App\Notifications\BookingCancelledNotification;

class SendBookingCancelledNotification
{
    public function handle(MemberBookingCancelled $event)
    {
        $event->lookup()->notify(new BookingCancelledNotification($event->groupSession()));
    }
}
