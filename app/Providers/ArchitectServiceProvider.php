<?php

namespace App\Providers;

use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;

class ArchitectServiceProvider extends ArchitectApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    protected function blueprints()
    {
        return [];
    }

    public function register()
    {
        //
    }
}
