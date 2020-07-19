<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public const SUNDAY = 1;
    public const MONDAY = 2;
    public const TUESDAY = 3;
    public const WEDNESDAY = 4;
    public const THURSDAY = 5;
    public const FRIDAY = 6;
    public const SATURDAY = 7;

    protected $guarded = [];

    public $timestamps = false;

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
