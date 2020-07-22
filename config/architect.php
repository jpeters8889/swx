<?php

use JPeters\Architect\Http\Middleware\ArchitectIsRunning;
use JPeters\Architect\Http\Middleware\Authenticate;
use JPeters\Architect\Http\Middleware\CanAccessArchitect;

return [
    'name' => 'SW Admin',

    // The route to access the admin panel
    'route' => 'admin',

    'middleware' => [
        'web',
        Authenticate::class,
        CanAccessArchitect::class,
        ArchitectIsRunning::class,
    ],

    'can_change_password' => true,

    'gateway' => null,
];
