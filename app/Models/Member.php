<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property GroupSession groupSession
 */
class Member extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function bookings()
    {
        return $this->hasMany(MemberBooking::class);
    }

    public function cancellations()
    {
        return $this->hasMany(MemberCancellation::class);
    }

    public function lookups()
    {
        return $this->hasMany(MemberLookup::class);
    }

    public function getBookingsCountAttribute() {
        return $this->bookings()->count();
    }
}
