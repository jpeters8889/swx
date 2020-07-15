<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class GroupSession extends Model
{
 protected $guarded = [];

    public function addMember(array $params)
    {
        if(!$this->hasAvailableSlots()) {
            throw new Exception('No slots available in this session');
        }

        $this->members()->create($params);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function hasAvailableSlots(): bool
    {
        return $this->members->count() < $this->session->capacity;
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
