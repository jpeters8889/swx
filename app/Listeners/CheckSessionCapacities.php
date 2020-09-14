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

        $check = 'hasAvailableSeat';
        $type = 'seats';
        $threshold = 'seats_threshold';

        if(!$event->requiresSeat()) {
            $check = 'hasAvailableWeighSlot';
            $type = 'weigh';
            $threshold = 'weigh_capacity_threshold';
        }

        $count = $groupSession->bookings()->where('requires_seat', $type === 'seats')->count();

        if(!$groupSession->$check()) {
            $groupSession->group->user->notify(new SessionFullyBookedNotification($groupSession, $type));
            return;
        }

        if($count === $groupSession->session->$threshold) {
            $groupSession->group->user->notify(new SessionNearingCapacityNotification($groupSession, $type));
        }
    }
}
