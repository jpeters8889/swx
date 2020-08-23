<?php

namespace App\Listeners;

use App\Events\MemberBookedOntoSession;
use App\Notifications\SessionFullyBookedNotification;
use App\Notifications\SessionNearingCapacityNotification;

class CheckSessionCapacities
{
    public function handle(MemberBookedOntoSession $event)
    {
        $groupSession = $event->groupSession();

        if($groupSession->isFull()) {
            $groupSession->group->user->notify(new SessionFullyBookedNotification($groupSession));
            return;
        }

        if($groupSession->bookings->count() === $groupSession->session->capacity_threshold) {
            $groupSession->group->user->notify(new SessionNearingCapacityNotification($groupSession));
        }
    }
}
