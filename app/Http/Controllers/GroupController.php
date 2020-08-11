<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupSession;
use App\Models\Session;
use Carbon\Carbon;
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
            'today' => Carbon::now()->format('jS M'),
            'now' => Carbon::now()->setTimezone('Europe/London')->format('Gi'),
            'group' => $group,
            'dates' => $group->groupSessions()
                ->orderBy('date')
                ->with('session')
                ->withCount('members')
                ->where('date', '>=', Carbon::today())
                ->get()
                ->groupBy(fn(GroupSession $groupSession) => $groupSession->date->getTimestamp()),
        ]);
    }
}
