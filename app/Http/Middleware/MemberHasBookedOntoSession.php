<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MemberHasBookedOntoSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('booking_id')) {
            return new RedirectResponse(config('app.url'));
        }

        if (!Member::query()->where('id', $request->session()->get('booking_id'))->exists()) {
            return new RedirectResponse(config('app.url'));
        }

        return $next($request);
    }
}
