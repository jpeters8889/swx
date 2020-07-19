<?php

namespace App\Console\Commands;

use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateSessions extends Command
{
    protected $signature = 'sw:create-sessions';

    public function handle()
    {
        $now = Carbon::now();

        Session::query()
            ->where('day_id', $now->dayOfWeek + 1)
            ->get()
            ->each(static function (Session $session) use ($now) {
                $newDate = $now->addWeeks($session->advance_weeks_to_create);

                if ($session->groupSessions()->where('date', $newDate)->exists()) {
                    return;
                }

                $session->groupSessions()->create([
                    'group_id' => $session->group_id,
                    'date' => $newDate,
                ]);
            });
    }
}
