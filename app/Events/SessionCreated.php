<?php

namespace App\Events;

use App\Models\Session;

class SessionCreated
{
    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function session(): Session
    {
        return $this->session;
    }
}
