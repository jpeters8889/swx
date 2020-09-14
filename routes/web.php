<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupSessionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\ThanksController;
use App\Http\Middleware\GroupExists;
use App\Http\Middleware\GroupSessionBelongsToGroup;
use App\Http\Middleware\MemberHasBookedOntoSession;
use Illuminate\Routing\Router;

/* @var Router $router */

$router->get('/', [HomeController::class, 'get']);

$router->group(['middleware' => MemberHasBookedOntoSession::class], static function ($router) {
    $router->get('thanks', [ThanksController::class, 'get']);
});

$router->group(['prefix' => 'lookup'], static function ($router) {
    $router->get('/', [LookupController::class, 'index']);
    $router->post('/', [LookupController::class, 'create']);

    $router->group(['prefix' => '{key}'], static function ($router) {
        $router->get('', [LookupController::class, 'get']);
        $router->delete('/{id}', [LookupController::class, 'delete']);
    });
});

$router->get('/group-sessions/{groupId}', [GroupSessionsController::class, 'get']);

$router->group(['prefix' => '{group}', 'middleware' => GroupExists::class], static function ($router) {
    $router->get('', [GroupController::class, 'list'])
        ->where('group', '^(?!admin$).*');

    $router->group(['middleware' => GroupSessionBelongsToGroup::class], static function ($router) {
        $router->post('{session}', [BookingController::class, 'create'])
            ->where('group', '^(?!admin$).*');
    });
});
