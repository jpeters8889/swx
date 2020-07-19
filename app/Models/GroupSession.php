<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon date
 */
class GroupSession extends Model
{
    protected $guarded = [];

    protected $dates = [
        'date',
    ];

    public function addMember(array $params)
    {
        if (!$this->hasAvailableSlots()) {
            throw new Exception('No slots available in this session');
        }

        $this->members()->create($params);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function hasAvailableSlots(): bool
    {
        return $this->members->count() < $this->session->capacity;
    }

    public function isFull(): bool
    {
        return ! $this->hasAvailableSlots();
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
