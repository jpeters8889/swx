<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupExists
{
    public function handle(Request $request, Closure $next)
    {
        if (Group::query()->where('slug', $request->route('group'))->exists()) {
            return $next($request);
        }

        return new Response('Group not found', 404);
    }
}
