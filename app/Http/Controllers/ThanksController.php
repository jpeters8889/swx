<?php

namespace App\Http\Controllers;

use App\Models\MemberBooking;
use Illuminate\Session\Store;
use JPeters\PageViewBuilder\Page;

class ThanksController extends Controller
{
    public function get(Page $page, Store $sessionStore)
    {
        $booking = MemberBooking::query()->firstWhere('id', $sessionStore->get('booking_id'));

        return $page->render('thanks', compact('booking'));
    }
}
