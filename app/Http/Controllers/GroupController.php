<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Session;
use Illuminate\Database\Eloquent\Relations\Relation;
use JPeters\PageViewBuilder\Page;

class GroupController extends Controller
{
    public function list(Page $page, $group)
    {
        $group = Group::query()
            ->where('slug', $group)
            ->first();

        abort_if(!$group, 404, 'Group not found');

        return $page->render('group', [
            'group' => $group,
            'dates' => $group->groupSessions()
                ->orderBy('date')
                ->with('session')
                ->withCount('members')
                ->get()
                ->groupBy(fn(GroupSession $groupSession) => $groupSession->date->getTimestamp()),
        ]);
    }
}