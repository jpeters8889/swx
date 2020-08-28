<?php

namespace App\Listeners;

use App\Events\MemberBookedOntoSession;
use App\Models\MemberLookupSource;

class CreateLookupForNewBooking
{
    public function handle(MemberBookedOntoSession $event)
    {
        $event->member()->lookups()->create([
            'valid_until' => $event->groupSession()->date->endOfDay(),
            'member_lookup_source_id' => MemberLookupSource::FROM_BOOKING,
        ]);
    }
}
