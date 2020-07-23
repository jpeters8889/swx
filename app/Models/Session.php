<?php

namespace App\Models;

use App\Events\SessionCreated;
use Carbon\Carbon;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon first_session_date
 * @property string human_start_time
 */
class Session extends Model
{
    protected $appends = [
        'human_start_time',
        'human_end_time',
    ];

    protected $dates = [
        'first_session_date',
    ];

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function (self $session) {
            resolve(Dispatcher::class)->dispatch(new SessionCreated($session));
        });
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    protected function formatForHuman($time)
    {
        $time = Carbon::parse($time);

        $format = 'g:ia';

        if ($time->format('i') === '00') {
            $format = 'ga';
        }

        return $time->format($format);
    }

    public function getHumanStartTimeAttribute()
    {
        return $this->formatForHuman($this->start_at);
    }

    public function getHumanEndTimeAttribute()
    {
        return $this->formatForHuman($this->end_at);
    }

    public function getCapacityThresholdAttribute()
    {
        return round($this->capacity * 0.8);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function groupSessions()
    {
        return $this->hasMany(GroupSession::class);
    }
}
