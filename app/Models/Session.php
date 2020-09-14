<?php

namespace App\Models;

use App\Events\SessionCreated;
use Carbon\Carbon;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon first_session_date
 * @property string human_start_time
 * @property int seats_threshold
 * @property int weigh_capacity_threshold
 * @property bool has_seats
 * @property int seats
 * @property bool has_weigh_and_go
 * @property int weigh_and_go_slots
 */
class Session extends Model
{
    protected $appends = [
        'human_start_time',
        'human_end_time',
        'seats_threshold',
        'weigh_capacity_threshold',
    ];

    protected $casts = [
        'seats_threshold' => 'int',
        'weigh_capacity_threshold' => 'int',
        'has_seats' => 'bool',
        'has_weigh_and_go' => 'bool',
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

    public function getSeatsThresholdAttribute()
    {
        return (int) round($this->seats * 0.8);
    }

    public function getWeighCapacityThresholdAttribute()
    {
        return (int) round($this->weigh_and_go_slots * 0.8);
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
