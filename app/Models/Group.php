<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function groupSessions()
    {
        return $this->hasMany(GroupSession::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
