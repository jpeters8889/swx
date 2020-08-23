<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property GroupSession groupSession
 * @deprecated
 */
class MembersOld extends Model
{
    use Notifiable;

    protected $guarded = [];

    protected $table = 'members_old';

    public function groupSession()
    {
        return $this->belongsTo(GroupSession::class);
    }
}
