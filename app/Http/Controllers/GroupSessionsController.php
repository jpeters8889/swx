<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupSession;
use Carbon\Carbon;
use Illuminate\Http\Response;

class GroupSessionsController extends Controller
{
    public function get($groupId)
    {
        /** @var Group $group */
        $group = Group::query()->find($groupId);

        if (!$group) {
            return new Response(['error' => 'Group not found'], 404);
        }

        return [
            'group' => $group,
            'announcement' => $group->latestAnnouncement(),
            'dates' => $group->groupSessions()
                ->orderBy('date')
                ->with('session')
                ->withCount('bookings')
                ->where('date', '>=', Carbon::today())
                ->get()
                ->groupBy(fn(GroupSession $groupSession) => $groupSession->date->getTimestamp())
                ->each(function ($item) {
                    $item->sortBy(fn(GroupSession $groupSession) => $groupSession->session->start_at);
                }),
        ];
    }
}
