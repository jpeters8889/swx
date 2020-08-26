<?php

namespace App\Architect\Plans\MemberBookings;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('get', 'members', ApiHandler::class, 'bookingsCount');
            $architect->apiManager->registerEndpoint('get', 'members', ApiHandler::class, 'bookings');

            $architect->assetManager->registerScript('MemberBookings', __DIR__.'/../dist/plan.js');
            $architect->assetManager->registerStyle('MemberBookings', __DIR__.'/../dist/plan.css');
        });
    }
}
