<?php

namespace App\Architect\Plans\MemberBookings;

use App\Models\Member;

class ApiHandler
{
    public function bookingsCount($id)
    {
        return ['bookings' => Member::query()->findOrFail($id)->bookings()->count()];
    }

    public function bookings($id)
    {
        return [
            'bookings' => Member::query()->findOrFail($id)
                ->bookings
                ->load([
                    'groupSession',
                    'groupSession.session',
                    'groupSession.session.day',
                    'groupSession.group']
                )
        ];
    }
}
