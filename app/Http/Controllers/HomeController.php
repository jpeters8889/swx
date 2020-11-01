<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Session;
use JPeters\PageViewBuilder\Page;

class HomeController
{
    public function get(Page $page)
    {
        $groups = Group::query()
            ->whereHas('sessions', fn(Session $session) => $session->live === 1)
            ->with(['sessions', 'sessions.day', 'user'])
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return $page->render('index', compact('groups'));
    }
}
