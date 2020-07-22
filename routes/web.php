<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Middleware\GroupExists;
use App\Http\Middleware\GroupSessionBelongsToGroup;
use Illuminate\Routing\Router;

/* @var Router $router */

$router->get('/', [HomeController::class, 'get']);

$router->group(['prefix' => '{group}', 'middleware' => GroupExists::class], static function ($router) {
    $router->get('', [GroupController::class, 'list'])->where('group', '^(?!admin$).*');

    $router->group(['middleware' => GroupSessionBelongsToGroup::class], static function ($router) {
        $router->post('{session}', [BookingController::class, 'create'])->where('group', '^(?!admin$).*');
    });
});
