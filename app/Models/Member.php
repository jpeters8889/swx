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

    public function groupSession()
    {
        return $this->belongsTo(GroupSession::class);
    }
}
