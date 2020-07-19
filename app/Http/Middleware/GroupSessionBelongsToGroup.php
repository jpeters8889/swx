<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupSessionBelongsToGroup
{
    public function handle(Request $request, Closure $next)
    {
        /** @var Group $group */
        $group = Group::query()->where('slug', $request->route('group'))->firstOrFail();

        if($group->groupSessions()->where('id', $request->route('session'))->exists()) {
            return $next($request);
        }

        return new Response('Session not found', 404);
    }
}
