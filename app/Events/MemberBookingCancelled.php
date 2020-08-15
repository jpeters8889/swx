<?php

namespace App\Events;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\MemberLookup;
use App\Models\Session;

class MemberBookingCancelled
{
    private MemberLookup $lookup;
    private GroupSession $groupSession;

    public function __construct(MemberLookup $lookup, GroupSession $groupSession)
    {
        $this->lookup = $lookup;
        $this->groupSession = $groupSession;
    }

    public function lookup(): MemberLookup
    {
        return $this->lookup;
    }

    public function groupSession(): GroupSession
    {
        return $this->groupSession;
    }
}
