<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property Carbon valid_until
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
            $lookup->valid_until = Carbon::now()->addMinutes(static::EXPIRY_MINUTES);
        });
    }

    public function bookings()
    {
        return $this->hasMany(Member::class, 'email', 'email');
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
}
