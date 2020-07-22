<?php

namespace App\Architect\Cards\Groups;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Session;
use Carbon\Carbon;
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
                    ->withCount('members')
                    ->where('date', '>=', Carbon::today())
                    ->orderBy('date'),
                'groupSessions.session', 'groupSessions.session.day'
            ])
            ->orderBy('name')
            ->get();
    }

    public function members(Request $request, $id)
    {
        /** @var GroupSession $group */
        $group = GroupSession::query()->findOrFail($id);

        abort_if($group->group->user_id !== $request->user()->id, 403);

        return $group
            ->members()
            ->orderBy('name')
            ->get();
    }

    public function printMembers(Request $request, $id)
    {
        /** @var GroupSession $groupSession */
        $groupSession = GroupSession::query()->findOrFail($id);

        abort_if($groupSession->group->user_id !== $request->user()->id, 403);

        $rtr = "<html>
            <body>
                <h1>Member List for {$groupSession->group->name}, {$groupSession->date->format('jS M Y')} - {$groupSession->session->human_start_time}</h1>
            </body>

            <table border='1' cellspacing='0' cellpadding='5'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>";

            foreach($groupSession->members()->orderBy('name')->get() as $x => $member) {
                $index = $x + 1;
                $rtr .= "<tr>
                    <td>{$index}</td>
                    <td>{$member->name}</td>
                    <td>{$member->phone}</td>
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
                'groupSessions' => fn(Relation $builder) => $builder->orderByDesc('date')->withCount('members')
            ])
            ->findOrFail($id);

        abort_if($session->group->user_id !== $request->user()->id, 403);

        return $session;
    }
}
