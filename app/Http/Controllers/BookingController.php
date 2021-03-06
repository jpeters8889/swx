<?php

namespace App\Http\Controllers;

use App\Events\MemberBookedOntoSession;
use App\Exceptions\MemberAlreadyOnSessionException;
use App\Exceptions\MemberSameDayBookingException;
use App\Exceptions\SessionFullException;
use App\Http\Requests\BookingRequest;
use App\Models\Member;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Response;
use Illuminate\Session\Store;

class BookingController extends Controller
{
    public function create(BookingRequest $request, Store $sessionStore, Dispatcher $dispatcher)
    {
        $groupSession = $request->groupSession();

        try {
            /** @var Member $member */
            $member = Member::query()->firstOrCreate($request->validated());
            $groupSession->bookMember($member);

            $dispatcher->dispatch(new MemberBookedOntoSession($member, $groupSession));
            $sessionStore->put('booking_id', $member->bookings()->latest()->first()->id);

            return new Response();
        } catch (MemberAlreadyOnSessionException $e) {
            return new Response(['errors' => ['conflict' => $e->getMessage()]], 409);
        } catch (MemberSameDayBookingException $e) {
            return new Response(['errors' => ['sameday' => $e->getMessage()]], 409);
        } catch (SessionFullException $e) {
            return new Response(['errors' => ['sessionFull' => $e->getMessage()]], 422);
        }
    }
}
