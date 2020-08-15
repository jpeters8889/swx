<?php

namespace App\Http\Controllers;

use App\Events\MemberBookingCancelled;
use App\Http\Requests\CreateMemberLookupRequest;
use App\Http\Requests\ViewMemberLookupRequest;
use App\Models\Member;
use App\Models\MemberLookup;
use App\Events\MemberLookupCreated;
use Carbon\Carbon;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use JPeters\PageViewBuilder\Page;

class LookupController extends Controller
{
    public function create(CreateMemberLookupRequest $request, Dispatcher $dispatcher)
    {
        if ($request->hasMembers()) {
            $lookup = MemberLookup::query()->create(['email' => $request->input('email')]);

            $dispatcher->dispatch(new MemberLookupCreated($lookup));
        }
    }

    public function get(Page $page, ViewMemberLookupRequest $request)
    {
        return $page->render('lookup', [
            'key' => $request->route('key'),

            'upcoming' => $request->memberLookup()->bookings()
                ->whereHas('groupSession', fn(Builder $builder) => $builder->where('date', '>=', Carbon::today()))
                ->get(),

            'past' => $request->memberLookup()->bookings()
                ->whereHas('groupSession', fn(Builder $builder) => $builder->where('date', '<', Carbon::today()))
                ->get(),
        ]);
    }

    public function delete(ViewMemberLookupRequest $request, Dispatcher $dispatcher, $key, $id)
    {
        /** @var Member $member */
        $member = $request->memberLookup()
            ->bookings()
            ->where('id', $id)
            ->first();

        if (!$member || $member->email !== $request->memberLookup()->email) {
            abort(404);
        }

        $member->delete();

        $dispatcher->dispatch(
            new MemberBookingCancelled($request->memberLookup(), $member->groupSession)
        );
    }
}
