<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Routing\ResponseFactory;

class LoginController
{
    /**
     * @var AuthManager
     */
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function get(ResponseFactory $factory)
    {
        return $factory->view('login');
    }

    public function post(LoginRequest $request)
    {
        if($this->auth->guard()->attempt($request->validated())) {
            return redirect()->intended('admin');
        }
    }
}
