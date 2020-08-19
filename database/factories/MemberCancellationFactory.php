<?php

/** @var Factory $factory */

use App\Models\MemberCancellation;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(MemberCancellation::class, function (Faker $faker) {
    return [
        'email' => $faker->email
    ];
});
