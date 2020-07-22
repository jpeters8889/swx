<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    public function create(BookingRequest $request)
    {
        $groupSession = $request->groupSession();

        if($groupSession->isFull()) {
            return new Response(['error' => 'Session is full'], 422);
        }

        $groupSession->addMember($request->all());

        return new Response();
    }
}
