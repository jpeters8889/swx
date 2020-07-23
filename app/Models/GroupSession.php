<?php

namespace App\Models;

use App\Exceptions\MemberAlreadyOnSessionException;
use App\Exceptions\SessionFullException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon date
 * @property Session session
 * @property Group group
 */
class GroupSession extends Model
{
    protected $appends = [
        'type'
    ];

    protected $guarded = [];

    protected $dates = [
        'date',
    ];

    /**
     * @param array $params
     * @return Member
     * @throws MemberAlreadyOnSessionException
     * @throws SessionFullException
     */
    public function addMember(array $params): Member
    {
        if (!$this->hasAvailableSlots()) {
            throw new SessionFullException('No slots available in this session');
        }

        if($this->hasMember($params)) {
            throw new MemberAlreadyOnSessionException('Member already exists on this session');
        }

        return $this->members()->create($params);
    }

    public function getTypeAttribute()
    {
        $now = Carbon::now();

        if($this->date->isSameWeek($now)) {
            return 'next';
        }

        if($this->date->greaterThan($now)) {
            return 'future';
        }

        return 'past';
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function hasAvailableSlots(): bool
    {
        return $this->members->count() < $this->session->capacity;
    }

    public function hasMember($params): bool
    {
        $query = $this->members();

        foreach($params as $key => $value) {
            $query->where($key, $value);
        }

        return $query->exists();
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
