<?php

namespace App\Listeners;

use App\Events\MemberBookingCancelled;

class LogMemberCancellation
{
    public function handle(MemberBookingCancelled $bookingCancelled)
    {
        $bookingCancelled
            ->groupSession()
            ->cancelMember($bookingCancelled->lookup()->email);
    }
}
