<?php

namespace App\Architect\Cards\MemberCancellations;

use App\Models\MemberCancellation;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;

class ApiHandler
{
    public function get(Repository $cacheRepository, $id)
    {
        $latestCancellation = MemberCancellation::query()->latest()->value('id');
        $cacheRepository->put('architect-cancellations-last-seen', $latestCancellation);

        /** @var MemberCancellation $cancellation */
        $cancellation = MemberCancellation::query()->findOrFail($id);

        return $cancellation->load(['member', 'groupSession', 'groupSession.group', 'groupSession.session', 'groupSession.session.day']);
    }
}
