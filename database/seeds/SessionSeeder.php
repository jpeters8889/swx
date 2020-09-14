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
            'seats' => 25,
            'weigh_and_go_slots' => 7,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 1,
            'day_id' => Day::TUESDAY,
            'start_at' => '18:30',
            'end_at' => '19:15',
            'seats' => 25,
            'weigh_and_go_slots' => 7,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 2,
            'day_id' => Day::TUESDAY,
            'start_at' => '09:30',
            'end_at' => '18:15',
            'seats' => 30,
            'weigh_and_go_slots' => 7,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 2,
            'day_id' => Day::TUESDAY,
            'start_at' => '10:30',
            'end_at' => '11:15',
            'seats' => 30,
            'has_weigh_and_go' => false,
            'weigh_and_go_slots' => 0,
            'advance_weeks_to_create' => 3,
        ]);

        factory(Session::class)->create([
            'group_id' => 3,
            'day_id' => Day::THURSDAY,
            'start_at' => '12:15',
            'end_at' => '13:00',
            'has_seats' => false,
            'has_weigh_and_go' => true,
            'seats' => 0,
            'weigh_and_go_slots' => 10,
            'advance_weeks_to_create' => 3,
        ]);
    }
}
