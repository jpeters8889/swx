<?php

namespace App\Listeners;

use App\Events\MemberBookingCancelled;

class LogMemberCancellation
{
    public function handle(MemberBookingCancelled $bookingCancelled)
    {
        $bookingCancelled
            ->groupSession()
            ->cancelBooking($bookingCancelled->member()->id);
    }
}
