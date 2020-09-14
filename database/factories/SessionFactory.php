<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use App\Models\Session;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    return [
        'day_id' => $faker->numberBetween(1, 7),
        'start_at' => '10:00',
        'end_at' => '11:00',
        'has_seats' => true,
        'has_weigh_and_go' => true,
        'seats' => random_int(10, 30),
        'weigh_and_go_slots' => random_int(5, 10),
        'first_session_date' => Carbon::today(),
    ];
});
