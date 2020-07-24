<?php

namespace App\Events;

use App\Models\Member;

class MemberBookedOntoSession
{
    private Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function member(): Member
    {
        return $this->member;
    }
}
