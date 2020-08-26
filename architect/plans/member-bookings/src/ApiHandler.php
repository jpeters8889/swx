<?php

namespace App\Architect\Plans\MemberBookings;

use App\Models\Member;
use App\Models\MemberBooking;

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
            ->sortBy(fn(MemberBooking $booking) => $booking->groupSession->date)
            ->values(),
        ];
    }
}
