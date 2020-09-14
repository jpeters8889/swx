<?php

namespace App\Http\Controllers;

use App\Models\Group;
use JPeters\PageViewBuilder\Page;

class HomeController
{
    public function get(Page $page)
    {
        $groups = Group::query()
            ->with(['sessions', 'sessions.day', 'user'])
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return $page->render('index', compact('groups'));
    }
}
