<?php

namespace App\Providers;

use App\Architect\GroupBlueprint;
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

    public function register()
    {
        //
    }
}
