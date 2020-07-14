<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;

class HomeController
{
    public function get(ResponseFactory $response)
    {
        return $response->view('welcome');
    }
}
