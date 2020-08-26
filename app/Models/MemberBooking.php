<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property GroupSession groupSession
 * @property Member member
 */
class MemberBooking extends Model
{
    protected $guarded = [];

    public function groupSession()
    {
        return $this->belongsTo(GroupSession::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
