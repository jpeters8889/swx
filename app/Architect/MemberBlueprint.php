<?php

namespace App\Architect;

use App\Architect\Plans\MemberBookings\Plan;
use App\Models\Member;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\Textfield;

class MemberBlueprint extends Blueprint
{
    public function model(): string
    {
        return Member::class;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),
            Textfield::generate('email'),
            Textfield::generate('phone')->hideFromIndexOnMobile(),
            Plan::generate('bookings_count'),
        ];
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function ordering(): array
    {
        return [
            'name',
            'asc',
        ];
    }
}
