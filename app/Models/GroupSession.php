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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use RuntimeException;

/**
 * @property Carbon date
 * @property Session session
 * @property Group group
 * @property Collection<MemberBooking> bookings
 * @property Collection<MemberCancellation> cancellations
 * @property int seats_taken
 * @property int weigh_slots_taken
 */
class GroupSession extends Model
{
    protected $appends = [
        'type',
        'seats_taken',
        'weigh_slots_taken',
        'has_seat_available',
        'has_weigh_available',
    ];

    protected $casts = [
        'seats_taken' => 'int',
        'weigh_slots_taken' => 'int',
        'has_seat_available' => 'bool',
        'has_weigh_available' => 'bool',
    ];

    protected $guarded = [];

    protected $dates = [
        'date',
    ];

    /**
     * @param Member $member
     * @param bool $requireSeat
     * @throws MemberAlreadyOnSessionException
     * @throws MemberSameDayBookingException
     * @throws SessionFullException
     */
    public function bookMember(Member $member, $requireSeat = true): void
    {
        $check = 'has_seats';
        $method = 'hasAvailableSeat';

        if (!$requireSeat) {
            $check = 'has_weigh_and_go';
            $method = 'hasAvailableWeighSlot';
        }

        if (!$this->session->$check) {
            throw new RuntimeException('Incorrect booking type');
        }

        if (!$this->$method()) {
            throw new SessionFullException('No slots available in this session');
        }

        if ($this->hasMember($member->id)) {
            throw new MemberAlreadyOnSessionException('Member already exists on this session');
        }

        if ($this->hasSameDaySessionWithMember($member->id)) {
            throw new MemberSameDayBookingException('Member already booked onto a session on this day');
        }

        $this->bookings()->create(['member_id' => $member->id, 'requires_seat' => $requireSeat]);
    }

    public function getSeatsTakenAttribute(): int
    {
        return $this->bookings()->where('requires_seat', true)->count();
    }

    public function getWeighSlotsTakenAttribute(): int
    {
        return $this->bookings()->where('requires_seat', false)->count();
    }

    public function getHasSeatAvailableAttribute(): bool
    {
        if (!$this->session->has_seats) {
            return false;
        }

        return $this->seats_taken < $this->session->seats;
    }

    public function getHasWeighAvailableAttribute(): bool
    {
        if (!$this->session->has_weigh_and_go) {
            return false;
        }

        return $this->weigh_slots_taken < $this->session->weigh_and_go_slots;
    }

    public function getTypeAttribute(): string
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

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function hasAvailableSeat(): bool
    {
        return $this->bookings()
                ->where('requires_seat', true)
                ->count() < $this->session->seats;
    }

    public function hasAvailableWeighSlot(): bool
    {
        return $this->bookings()
                ->where('requires_seat', false)
                ->count() < $this->session->weigh_and_go_slots;
    }

    public function hasMember($memberId): bool
    {
        return $this->bookings()
            ->where('member_id', $memberId)
            ->exists();
    }

    public function isFull($seats): bool
    {
        return $seats ? $this->hasAvailableSeat() : $this->hasAvailableWeighSlot();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(MemberBooking::class);
    }

    public function session(): BelongsTo
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
