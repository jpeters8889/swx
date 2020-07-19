<?php

use App\Models\Day;
use App\Models\Session;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    public function run()
    {
        factory(Session::class)->create([
            'group_id' => 1,
            'day_id' => Day::TUESDAY,
            'start_at' => '17:30',
            'end_at' => '18:15',
            'new_member_session' => 1,
            'capacity' => 25,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 1,
            'day_id' => Day::TUESDAY,
            'start_at' => '18:30',
            'end_at' => '19:15',
            'capacity' => 25,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 2,
            'day_id' => Day::TUESDAY,
            'start_at' => '09:30',
            'end_at' => '18:15',
            'new_member_session' => 1,
            'capacity' => 30,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 2,
            'day_id' => Day::TUESDAY,
            'start_at' => '10:30',
            'end_at' => '11:15',
            'capacity' => 30,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 3,
            'day_id' => Day::THURSDAY,
            'start_at' => '12:15',
            'end_at' => '13:00',
            'capacity' => 30,
            'advance_weeks_to_create' => 3,
        ]);
    }
}
