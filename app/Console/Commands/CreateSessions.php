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
        Session::query()
            ->where('day_id', Carbon::now()->dayOfWeek + 1)
            ->where('live', true)
            ->get()
            ->each(static function (Session $session) {
                $now = Carbon::now();

                $newDate = $now->addWeeks($session->advance_weeks_to_create + 1);

                if ($session->groupSessions()->whereDate('date', $newDate)->exists()) {
                    return;
                }

                $session->groupSessions()->create([
                    'group_id' => $session->group_id,
                    'date' => $newDate,
                ]);
            });
    }
}
