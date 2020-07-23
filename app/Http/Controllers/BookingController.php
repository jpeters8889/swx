<?php

namespace App\Http\Controllers;

use App\Exceptions\MemberAlreadyOnSessionException;
use App\Exceptions\SessionFullException;
use App\Http\Requests\BookingRequest;
use App\Notifications\BookingConfirmed;
use Illuminate\Http\Response;
use Illuminate\Session\Store;

class BookingController extends Controller
{
    public function create(BookingRequest $request, Store $sessionStore)
    {
        $groupSession = $request->groupSession();

        try {
            $member = $groupSession->addMember($request->validated());

            $member->notify(new BookingConfirmed());
            $sessionStore->put('booking_id', $member->id);

            return new Response();
        } catch (MemberAlreadyOnSessionException $e) {
            return new Response(['errors' => ['conflict' => $e->getMessage()]], 409);
        } catch (SessionFullException $e) {
            return new Response(['errors' => ['sessionFull' => $e->getMessage()]], 422);
        }
    }
}
