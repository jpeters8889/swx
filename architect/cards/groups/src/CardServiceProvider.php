<?php

namespace App\Architect\Cards\Groups;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = resolve(Architect::class);

            $architect->apiManager->registerEndpoint('get', 'groups', ApiHandler::class, 'list');
            $architect->apiManager->registerEndpoint('get', 'groups', ApiHandler::class, 'bookings');
            $architect->apiManager->registerEndpoint('get', 'groups', ApiHandler::class, 'printBookings');
            $architect->apiManager->registerEndpoint('get', 'groups', ApiHandler::class, 'session');

            $architect->apiManager->registerEndpoint('post', 'groups', ApiHandler::class, 'deleteBooking');

            $architect->assetManager->registerScript('Groups', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('Groups', __DIR__.'/../dist/card.css');
        });
    }
}
