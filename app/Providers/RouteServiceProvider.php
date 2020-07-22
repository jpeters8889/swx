<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        /** @var Router $router */
        $router = app(Router::class);

        $router->middleware('web')->group(function () use ($router) {
            require(base_path('routes/web.php'));
        });
    }
}
