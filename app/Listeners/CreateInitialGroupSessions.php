<?php

namespace App\Listeners;

use App\Events\SessionCreated;

class CreateInitialGroupSessions
{
    public function handle(SessionCreated $sessionCreated)
    {
        $session = $sessionCreated->session();

        for($x = 0; $x <= $session->advance_weeks_to_create; $x++) {
            $session->groupSessions()->create([
                'group_id' => $session->group_id,
                'date' => $session->first_session_date->addWeeks($x),
            ]);
        }
    }
}
