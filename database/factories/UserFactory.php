<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    $randomRole = $faker->randomElement(['user', 'buddy', 'admin']);
    $randomStatus = null;
    $randomNl = null;
    $randomFr = null;
    $randomEn = null;
    $randomInfo = null;
    $randomAvailableTimes= null;

    if ($randomRole == 'buddy') {
        $randomStatus = $faker->randomElement(['undecided', 'declined', 'accepted']);
        $randomNl = true;
        $randomFr = $faker->boolean;
        $randomEn = $faker->boolean;
        $randomInfo = $faker->realText(1000);

        $randomAvailableTimes = '[';
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $daysCount = count($days);

        foreach ($days as $key => $day) {
            $trueOrFalse = $faker->boolean ? 'true' : 'false';
            if ($key == $daysCount - 1) {
                $finalComma = '';
            }
            else {
                $finalComma = ',';
            }
            $randomAvailableTimes .= '{"day":"' . $day . '","available":' . $trueOrFalse . ',"from":"' . $faker->time('H:i') . '","to":"' . $faker->time('H:i') . '"}' . $finalComma;
        }
        $randomAvailableTimes .= ']';
    }

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make(Str::random(8)),
        'avatar_path' => 'https://picsum.photos/id/' . $faker->numberBetween(0, 1084) . '/640/480',
        'role' => $randomRole,
        'status' => $randomStatus,
        'nl' => $randomNl,
        'fr' => $randomFr,
        'en' => $randomEn,
        'info' => $randomInfo,
        'available_times' => $randomAvailableTimes,
        'ip_address' => $faker->ipv4,
        'created_at' => now(),
        'updated_at' => now(),
        'remember_token' => Str::random(10),
    ];
});
