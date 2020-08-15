<?php

namespace App\Events;

use App\Models\MemberLookup;

class MemberLookupCreated
{
    private MemberLookup $lookup;

    public function __construct(MemberLookup $lookup)
    {
        $this->lookup = $lookup;
    }

    public function lookup(): MemberLookup
    {
        return $this->lookup;
    }
}
