<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use App\Models\Session;
use Faker\Generator as Faker;

$factory->define(Session::class, function (Faker $faker) {
    return [
        'group_id' => factory(Group::class)->create(),
        'day_id' => $faker->numberBetween(1, 7),
        'start_at' => '10:00',
        'end_at' => '11:00',
        'capacity' => random_int(10, 30),
    ];
});
