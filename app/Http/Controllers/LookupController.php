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
    public function index(Page $page)
    {
        return $page->render('lookup');
    }

    public function create(CreateMemberLookupRequest $request, Dispatcher $dispatcher)
    {
        $lookup = MemberLookup::query()->create(['member_id' => $request->member()->id]);

        $dispatcher->dispatch(new MemberLookupCreated($lookup));
    }

    public function get(Page $page, ViewMemberLookupRequest $request)
    {
        /** @var Member $member */
        $member = $request->memberLookup()->member;

        $relatedMembers = Member::query()->where('email', $member->email)->get();

        return $page->render('view_lookup', [
            'key' => $request->route('key'),

            'upcoming' => MemberBooking::query()
                ->whereIn('member_id', $relatedMembers->pluck('id'))
                ->whereHas('groupSession', fn(Builder $builder) => $builder->where('date', '>=', Carbon::today()))
                ->get(),

            'past' => MemberBooking::query()
                ->whereIn('member_id', $relatedMembers->pluck('id'))
                ->whereHas('groupSession', fn(Builder $builder) => $builder->where('date', '<', Carbon::today()))
                ->get(),
        ]);
    }

    public function delete(ViewMemberLookupRequest $request, Dispatcher $dispatcher, $key, $id)
    {
        /** @var Member $member */
        $member = $request->memberLookup()->member;

        $simularMembers = Member::query()->where('email', $member->email)->get();

        /** @var MemberBooking $booking */
//        $booking = $member->bookings()->where('id', $id)->first();
        $booking = MemberBooking::query()
            ->whereIn('member_id', $simularMembers->pluck('id'))
            ->where('id', $id)
            ->first();

        abort_if(!$booking, 404);

        $booking->delete();

        $dispatcher->dispatch(
            new MemberBookingCancelled($request->memberLookup(), $booking->groupSession)
        );
    }
}
