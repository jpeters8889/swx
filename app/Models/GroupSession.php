<?php

namespace App\Models;

use App\Exceptions\MemberAlreadyOnSessionException;
use App\Exceptions\MemberSameDayBookingException;
use App\Exceptions\SessionFullException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property Carbon date
 * @property Session session
 * @property Group group
 * @property Collection<MemberBooking> bookings
 * @property Collection<MemberCancellation> cancellations
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
     * @param Member $member
     * @throws MemberAlreadyOnSessionException
     * @throws SessionFullException
     * @throws MemberSameDayBookingException
     */
    public function bookMember(Member $member): void
    {
        if (!$this->hasAvailableSlots()) {
            throw new SessionFullException('No slots available in this session');
        }

        if ($this->hasMember($member->id)) {
            throw new MemberAlreadyOnSessionException('Member already exists on this session');
        }

        if ($this->hasSameDaySessionWithMember($member->id)) {
            throw new MemberSameDayBookingException('Member already booked onto a session on this day');
        }

        $this->bookings()->create(['member_id' => $member->id]);
    }

    public function getTypeAttribute()
    {
        $now = Carbon::now();

        if ($this->date->isSameWeek($now)) {
            return 'next';
        }

        if ($this->date->greaterThan($now)) {
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
        return $this->bookings()->count() < $this->session->capacity;
    }

    public function hasMember($memberId): bool
    {
        return $this->bookings()
            ->where('member_id', $memberId)
            ->exists();
    }

    public function isFull(): bool
    {
        return !$this->hasAvailableSlots();
    }

    public function bookings()
    {
        return $this->hasMany(MemberBooking::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function hasSameDaySessionWithMember($memberId): bool
    {
        return self::query()
            ->where('group_id', $this->group_id)
            ->whereDate('date', $this->date)
            ->whereHas('bookings', static function (Builder $builder) use ($memberId) {
                return $builder->where('member_id', $memberId);
            })
            ->exists();
    }

    public function cancellations(): HasMany
    {
        return $this->hasMany(MemberCancellation::class);
    }

    public function cancelBooking(int $memberId): void
    {
        $this->bookings()->where('member_id', $memberId)->delete();

        $this->cancellations()->create([
            'member_id' => $memberId
        ]);
    }
}
