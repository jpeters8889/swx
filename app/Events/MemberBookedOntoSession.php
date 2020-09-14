<?php

namespace App\Events;

use App\Models\GroupSession;
use App\Models\Member;

class MemberBookedOntoSession
{
    private GroupSession $groupSession;
    private Member $member;
    private bool $requireSeat;

    public function __construct(Member $member, GroupSession $groupSession, bool $requireSeat)
    {
        $this->groupSession = $groupSession;
        $this->member = $member;
        $this->requireSeat = $requireSeat;
    }

    public function groupSession(): GroupSession
    {
        return $this->groupSession;
    }

    public function member(): Member
    {
        return $this->member;
    }

    public function requiresSeat(): bool
    {
        return $this->requireSeat;
    }
}
