<?php

namespace App\Architect\Cards\Groups;

use App\Models\Group;
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
}
