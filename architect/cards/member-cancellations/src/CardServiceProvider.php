<?php

namespace App\Architect\Cards\MemberCancellations;

use JPeters\Architect\Architect;
use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Architect::isRunning(function () {
            /** @var Architect $architect */
            $architect = Architect::getInstance();

            $architect->apiManager->registerEndpoint('get', 'cancellation', ApiHandler::class, 'get');

            $architect->assetManager->registerScript('MemberCancellations', __DIR__.'/../dist/card.js');
            $architect->assetManager->registerStyle('MemberCancellations', __DIR__.'/../dist/card.css');
        });
    }
}
