<?php

use App\Http\Controllers\HomeController;
use Illuminate\Routing\Router;

/* @var Router $router */

$router->get('/', [HomeController::class, 'get']);
