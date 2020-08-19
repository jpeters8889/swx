<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberCancellation extends Model
{
    protected $guarded = [];

    public function groupSession(): BelongsTo
    {
        return $this->belongsTo(GroupSession::class);
    }
}
