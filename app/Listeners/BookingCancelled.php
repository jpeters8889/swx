<?php

namespace App\Listeners;

use App\Events\MemberBookingCancelled;
use App\Notifications\BookingCancelledNotification;

class BookingCancelled
{
    public function handle(MemberBookingCancelled $event)
    {
        $event->lookup()->notify(new BookingCancelledNotification($event->groupSession()));
    }
}
