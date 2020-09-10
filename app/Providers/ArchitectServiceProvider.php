<?php

namespace App\Providers;

use App\Architect\Dashboard;
use App\Architect\GroupAnnouncementBlueprint;
use App\Architect\GroupBlueprint;
use App\Architect\MemberBlueprint;
use App\Architect\MemberCancellationsBlueprint;
use JPeters\Architect\Dashboards\DashboardContract;
use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;

class ArchitectServiceProvider extends ArchitectApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    protected function blueprints(): array
    {
        return [
            GroupBlueprint::class,
            GroupAnnouncementBlueprint::class,
            MemberBlueprint::class,
            MemberCancellationsBlueprint::class,
        ];
    }

    protected function dashboard(): DashboardContract
    {
        return new Dashboard();
    }

    public function register()
    {
        //
    }
}
