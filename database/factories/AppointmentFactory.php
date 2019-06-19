<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Appointment;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    $randomDayOfMonth = $faker->numberBetween(1, 28);
    $randomDayOfMonth = str_pad($randomDayOfMonth, 2, '0', STR_PAD_LEFT);
    $randomMonth = $faker->numberBetween(6, 12);
    $randomMonth = str_pad($randomMonth, 2, '0', STR_PAD_LEFT);
    $randomDay = '2019-' . $randomMonth . '-' . $randomDayOfMonth;

    $randomFromTimeHour = str_pad($faker->numberBetween(7, 15), 2, '0', STR_PAD_LEFT);
    $randomToTimeHour = str_pad($faker->numberBetween(16, 23), 2, '0', STR_PAD_LEFT);

    $randomFromTimeMinute = $faker->numberBetween(0, 55);
    $randomFromTimeMinute = roundUpToAny($randomFromTimeMinute, 5);
    $randomFromTimeMinute = str_pad($randomFromTimeMinute, 2, '0', STR_PAD_LEFT);

    $randomToTimeMinute = $faker->numberBetween(0, 55);
    $randomToTimeMinute = roundUpToAny($randomToTimeMinute, 5);
    $randomToTimeMinute = str_pad($randomToTimeMinute, 2, '0', STR_PAD_LEFT);

    $randomToTime = $randomToTimeHour . ':' . $randomToTimeMinute;
    $randomFromTime = $randomFromTimeHour . ':' . $randomFromTimeMinute;

    return [
        'user_id' => 201,
        'buddy_id' => $faker->numberBetween(1, 200),
        'day' => $randomDay,
        'time_from' => $randomFromTime,
        'time_to' => $randomToTime,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
