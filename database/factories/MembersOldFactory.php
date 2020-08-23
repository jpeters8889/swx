<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MembersOld;
use Faker\Generator as Faker;

$factory->define(MembersOld::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
