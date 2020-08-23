<?php

namespace App\Events;

use App\Models\GroupSession;
use App\Models\Member;

class MemberBookedOntoSession
{
    private GroupSession $groupSession;
    private Member $member;

    public function __construct(Member $member, GroupSession $groupSession)
    {
        $this->groupSession = $groupSession;
        $this->member = $member;
    }

    public function groupSession(): GroupSession
    {
        return $this->groupSession;
    }

    public function member(): Member
    {
        return $this->member;
    }
}
