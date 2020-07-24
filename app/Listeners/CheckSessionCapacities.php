<?php

namespace App\Listeners;

use App\Events\MemberBookedOntoSession;
use App\Notifications\SessionFullyBooked;
use App\Notifications\SessionNearingCapacity;

class CheckSessionCapacities
{
    public function handle(MemberBookedOntoSession $event)
    {
        $groupSession = $event->member()->groupSession;

        if($groupSession->isFull()) {
            $groupSession->group->user->notify(new SessionFullyBooked($groupSession));
            return;
        }

        if($groupSession->members->count() === $groupSession->session->capacity_threshold) {
            $groupSession->group->user->notify(new SessionNearingCapacity($groupSession));
        }
    }
}
