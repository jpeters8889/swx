<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Carbon\Carbon;
use JPeters\PageViewBuilder\Page;

class GroupController extends Controller
{
    public function list(Page $page, $group)
    {
        $group = Group::query()
            ->where('slug', $group)
            ->with('announcements')
            ->first();

        abort_if(!$group, 404, 'Group not found');

        return $page->render('group', [
            'today' => Carbon::now()->format('jS M'),
            'now' => Carbon::now()->setTimezone('Europe/London')->format('Gi'),
            'group' => $group,
        ]);
    }
}
