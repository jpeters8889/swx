<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = [];

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function groupSessions()
    {
        return $this->hasMany(GroupSession::class);
    }
}
