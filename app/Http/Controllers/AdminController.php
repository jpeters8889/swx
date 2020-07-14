<?php

namespace App\Http\Controllers;

use Illuminate\Routing\ResponseFactory;

class AdminController
{
    public function index(ResponseFactory $response)
    {
        return $response->view('admin.index');
    }
}
