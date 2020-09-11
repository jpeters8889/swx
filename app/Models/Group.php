<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property EloquentCollection sessions
 * @property string name
 * @property User user
 */
class Group extends Model
{
    use HasSlug;

    protected $guarded = [];

    public function announcements()
    {
        return $this->hasMany(GroupAnnouncement::class);
    }

    public function getSessionListAttribute()
    {
        $sessions = [];

        $this->sessions()
            ->orderBy('group_id')
            ->orderBy('day_id')
            ->orderBy('start_at')
            ->get()
            ->each(static function (Session $session) use (&$sessions) {
                $startAt = Carbon::parse($session->start_at);

                $format = 'g:ia';

                if ($startAt->format('i') === '00') {
                    $format = 'ga';
                }

                if ($session->new_member_session) {
                    $format .= '\*';
                }

                if (array_key_exists($session->day->day, $sessions)) {
                    $sessions[$session->day->day][] = $startAt->format($format);
                    return;
                }

                $sessions[$session->day->day] = [$startAt->format($format)];
            });

        return $sessions;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function groupSessions()
    {
        return $this->hasMany(GroupSession::class);
    }

    public function latestAnnouncement()
    {
        return $this->announcements()
            ->whereDate('start_at', '<', Carbon::now())
            ->whereDate('end_at', '>=', Carbon::now())
            ->latest()
            ->first();
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
