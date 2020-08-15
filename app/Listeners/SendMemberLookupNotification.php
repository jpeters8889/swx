<?php

namespace App\Listeners;

use App\Events\MemberLookupCreated;
use App\Notifications\MemberLookupNotification;

class SendMemberLookupNotification
{
    public function handle(MemberLookupCreated $event)
    {
        $event->lookup()->notify(new MemberLookupNotification());
    }
}
