<?php

namespace App\Events;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Member;
use App\Models\MemberLookup;
use App\Models\Session;

class MemberBookingCancelled
{
    private Member $member;
    private GroupSession $groupSession;

    public function __construct(Member $member, GroupSession $groupSession)
    {
        $this->member = $member;
        $this->groupSession = $groupSession;
    }

    public function member(): Member
    {
        return $this->member;
    }

    public function groupSession(): GroupSession
    {
        return $this->groupSession;
    }
}
