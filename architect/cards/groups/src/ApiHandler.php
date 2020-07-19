<?php

namespace App\Architect\Cards\Groups;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Session;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class ApiHandler
{
    public function list(Request $request)
    {
        return Group::query()
            ->where('user_id', $request->user()->id)
            ->with(['sessions', 'sessions.day'])
            ->orderBy('name')
            ->get();
    }

    public function members(Request $request, $id)
    {
        /** @var GroupSession $group */
        $group = GroupSession::query()->findOrFail($id);

        abort_if($group->group->user_id !== $request->user()->id, 403);

        return $group->members;
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
