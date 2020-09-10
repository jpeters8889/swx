<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAnnouncement extends Model
{
    protected $dates = ['start_at', 'end_at'];

    protected $guarded = [];

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
