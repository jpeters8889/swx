<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property GroupSession groupSession
 * @property Member member
 */
class MemberBooking extends Model
{
    protected $appends = ['cancelable'];

    protected $casts = [
        'cancelable' => 'bool',
        'requires_seat' => 'bool',
    ];

    protected $guarded = [];

    public function getCancelableAttribute()
    {
        $sessionTime = $this->groupSession->date->format('Y-m-d') . ' ' . $this->groupSession->session->start_at;

        return Carbon::now()->isBefore(Carbon::parse($sessionTime));
    }

    public function groupSession()
    {
        return $this->belongsTo(GroupSession::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
