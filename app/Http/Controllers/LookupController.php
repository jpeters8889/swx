<?php

namespace App\Http\Controllers;

use App\Events\MemberBookingCancelled;
use App\Http\Requests\CreateMemberLookupRequest;
use App\Http\Requests\ViewMemberLookupRequest;
use App\Models\Member;
use App\Models\MemberBooking;
use App\Models\MemberLookup;
use App\Events\MemberLookupCreated;
use Carbon\Carbon;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Builder;
use JPeters\PageViewBuilder\Page;

class LookupController extends Controller
{
    public function create(CreateMemberLookupRequest $request, Dispatcher $dispatcher)
    {
        $lookup = MemberLookup::query()->create(['member_id' => $request->member()->id]);

        $dispatcher->dispatch(new MemberLookupCreated($lookup));
    }

    public function get(Page $page, ViewMemberLookupRequest $request)
    {
        return $page->render('lookup', [
            'key' => $request->route('key'),

            'member' => $request->memberLookup()->member,

            'upcoming' => $request->memberLookup()->member->bookings()
                ->whereHas('groupSession', fn(Builder $builder) => $builder->where('date', '>=', Carbon::today()))
                ->get(),

            'past' => $request->memberLookup()->member->bookings()
                ->whereHas('groupSession', fn(Builder $builder) => $builder->where('date', '<', Carbon::today()))
                ->get(),
        ]);
    }

    public function delete(ViewMemberLookupRequest $request, Dispatcher $dispatcher, $key, $id)
    {
        /** @var Member $member */
        $member = $request->memberLookup()->member;

        /** @var MemberBooking $booking */
        $booking = $member->bookings()->where('id', $id)->first();

        abort_if(!$member || !$booking, 404);

        $booking->delete();

        $dispatcher->dispatch(
            new MemberBookingCancelled($request->memberLookup(), $booking->groupSession)
        );
    }
}
