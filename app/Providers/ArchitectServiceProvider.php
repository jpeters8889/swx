<?php

namespace App\Providers;

use App\Architect\Dashboard;
use App\Architect\GroupBlueprint;
use JPeters\Architect\Dashboards\DashboardContract;
use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;

class ArchitectServiceProvider extends ArchitectApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    protected function blueprints()
    {
        return [
            GroupBlueprint::class,
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
