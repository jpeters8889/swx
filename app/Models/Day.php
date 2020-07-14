<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
