<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Routing\Router;

/* @var Router $router */

$router->get('login', [LoginController::class, 'get']);
$router->post('login', [LoginController::class, 'post']);

$router->get('/', [HomeController::class, 'get']);

$router->group(['prefix' => 'admin', 'middleware' => 'auth'], static function() use ($router) {
    $router->get('/', [AdminController::class, 'index']);
    $router->get('/settings', [AdminSettingsController::class, 'index']);
});
