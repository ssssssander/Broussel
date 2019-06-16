<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
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

function roundUpToAny($n, $x) {
    return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
}

$factory->define(User::class, function (Faker $faker) {
    $frenchOrDutch = $faker->boolean ? 'nl_BE' : 'fr_FR' ;
    $randomRole = $faker->randomElement(['user', 'buddy']);
    $randomStatus = null;
    $randomNl = null;
    $randomFr = null;
    $randomEn = null;
    $randomInfo = null;
    $randomAvailableTimes= null;
    $maleOrFemale = $faker->boolean ? 'male' : 'female' ;
    $avatarMenOrWomen = $maleOrFemale == 'male' ? 'men' : 'women' ;

    if ($randomRole == 'buddy') {
        $randomStatus = $faker->randomElement(['undecided', 'declined', 'accepted']);
        $randomNl = $frenchOrDutch == 'nl_BE' ? true : $faker->boolean;
        $randomFr = $frenchOrDutch == 'fr_FR' ? true : $faker->boolean;
        $randomEn = $faker->boolean;
        $randomInfo = $faker->realText(100);

        $randomAvailableTimes = '[';
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $daysCount = count($days);

        foreach ($days as $key => $day) {
            $trueOrFalse = $faker->boolean ? 'true' : 'false';
            $randomFromTimeHour = str_pad($faker->numberBetween(7, 15), 2, '0', STR_PAD_LEFT);
            $randomToTimeHour = str_pad($faker->numberBetween(16, 23), 2, '0', STR_PAD_LEFT);

            $randomFromTimeMinute = $faker->numberBetween(0, 59);
            $randomFromTimeMinute = roundUpToAny($randomFromTimeMinute, 5);
            $randomFromTimeMinute = str_pad($randomFromTimeMinute, 2, '0', STR_PAD_LEFT);

            $randomToTimeMinute = $faker->numberBetween(0, 59);
            $randomToTimeMinute = roundUpToAny($randomToTimeMinute, 5);
            $randomToTimeMinute = str_pad($randomToTimeMinute, 2, '0', STR_PAD_LEFT);

            $randomToTime = $randomToTimeHour . ':' . $randomToTimeMinute;
            $randomFromTime = $randomFromTimeHour . ':' . $randomFromTimeMinute;

            if ($key == $daysCount - 1) {
                $finalComma = '';
            }
            else {
                $finalComma = ',';
            }
            $randomAvailableTimes .= '{"day":"' . $day . '","available":' . $trueOrFalse . ',"from":"' . $randomFromTime . '","to":"' . $randomToTime . '"}' . $finalComma;
        }
        $randomAvailableTimes .= ']';
    }

    return [
        'name' => $faker->firstName($maleOrFemale) . ' ' . $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make(Str::random(8)),
        'avatar_path' => 'https://randomuser.me/api/portraits/' . $avatarMenOrWomen . '/' . $faker->numberBetween(1, 99). '.jpg',
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
