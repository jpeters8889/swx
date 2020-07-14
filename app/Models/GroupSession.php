<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupSession extends Model
{
 protected $guarded = [];

    public function addMember(array $params)
    {
        $this->members()->create($params);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
