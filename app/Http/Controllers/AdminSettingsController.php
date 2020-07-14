<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\ResponseFactory;

class AdminSettingsController
{
    public function index(ResponseFactory $response, Guard $guard)
    {
        return $response->view('admin.settings', [
            'user' => $guard->user(),
        ]);
    }
}
