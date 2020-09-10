<?php

/** @var Factory $factory */

use App\Models\GroupAnnouncement;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(GroupAnnouncement::class, function (Faker $faker) {
    return [
        'announcement' => $faker->paragraph,
        'start_at' => Carbon::now(),
        'end_at' => Carbon::now()->addWeek(),
    ];
});
