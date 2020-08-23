<?php

namespace App\Architect\Cards\Groups;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\MemberBooking;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiHandler
{
    public function list(Request $request)
    {
        return Group::query()
            ->where('user_id', $request->user()->id)
            ->with([
                'sessions' => fn(Relation $relation) => $relation->orderBy('day_id')->orderBy('start_at'),
                'sessions.day',
                'groupSessions' => fn(Relation $relation) => $relation
                    ->withCount('bookings')
                    ->where('date', '>=', Carbon::today())
                    ->orderBy('date'),
                'groupSessions.session',
                'groupSessions.session.day'
            ])
            ->orderBy('name')
            ->get();
    }

    public function bookings(Request $request, $id)
    {
        /** @var GroupSession $group */
        $group = GroupSession::query()->findOrFail($id);

        abort_if($group->group->user_id !== $request->user()->id, 403);

        return $group
            ->bookings
            ->sortBy(fn(MemberBooking $booking) => ucfirst(explode(' ', $booking->member->name)[0]))
            ->values();
    }

    public function printBookings(Request $request, $id)
    {
        /** @var GroupSession $groupSession */
        $groupSession = GroupSession::query()->findOrFail($id);

        abort_if($groupSession->group->user_id !== $request->user()->id, 403);

        $bookings = $groupSession
            ->bookings
            ->sortBy(fn(MemberBooking $booking) => ucfirst(explode(' ', $booking->member->name)[0]))
            ->values();

        $rtr = "<html>
            <body>
                <h1>Member List for {$groupSession->group->name}, {$groupSession->date->format('jS M Y')} - {$groupSession->session->human_start_time}</h1>
            </body>

            <table border='1' cellspacing='0' cellpadding='5'>
            <thead>
                <tr>
                    <th>#</th>
                    <th style='text-align: left'>Name</th>
                    <th style='text-align: left'>Email</th>
                    <th style='text-align: left'>Phone Number</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($bookings as $x => $booking) {
            $index = $x + 1;
            $rtr .= "<tr>
                    <td>{$index}</td>
                    <td>{$booking->member->name}</td>
                    <td>{$booking->member->email}</td>
                    <td>{$booking->member->phone}</td>
                </tr>";
        }

        $rtr .= "</tbody></table></html>";

        return new Response($rtr);
    }

    public function session(Request $request, $id)
    {
        /** @var Session $session */
        $session = Session::query()
            ->with([
                'day',
                'groupSessions' => fn(Relation $builder) => $builder->orderByDesc('date')->withCount('bookings')
            ])
            ->findOrFail($id);

        abort_if($session->group->user_id !== $request->user()->id, 403);

        return $session;
    }
}
