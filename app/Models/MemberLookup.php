<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property Carbon valid_until
 * @property Member member
 */
class MemberLookup extends Model
{
    use Notifiable;

    public const EXPIRY_MINUTES = 30;

    protected $casts = [
        'key' => 'string',
    ];

    protected $dates = [
        'valid_until',
    ];

    protected $guarded = [];

    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected static function booted()
    {
        self::creating(function (self $lookup) {
            $lookup->key = Str::uuid();

            if (!$lookup->valid_until) {
                $lookup->valid_until = Carbon::now()->addMinutes(static::EXPIRY_MINUTES);
            }
        });
    }

    public function bookings()
    {
        return $this->hasManyThrough(MemberBooking::class, Member::class, 'id', 'member_id', 'member_id');
    }

    public function hasExpired(): bool
    {
        return !$this->isValid();
    }

    public function isValid(): bool
    {
        return $this->valid_until->isFuture();
    }

    public function link(): string
    {
        return implode('/', [
            Container::getInstance()->make(Repository::class)->get('app.url'),
            'lookup',
            $this->key,
        ]);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
