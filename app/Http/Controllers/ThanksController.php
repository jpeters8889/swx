<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Session\Store;
use JPeters\PageViewBuilder\Page;

class ThanksController extends Controller
{
    public function get(Page $page, Store $sessionStore)
    {
        $member = Member::query()->firstWhere('id', $sessionStore->get('booking_id'));

        return $page->render('thanks', compact('member'));
    }
}
