<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLookupSource extends Model
{
    public const MEMBER_CREATED = 1;
    public const FROM_BOOKING = 2;

    protected $guarded = [];

    public function lookups()
    {
        return $this->hasMany(MemberLookup::class);
    }
}
