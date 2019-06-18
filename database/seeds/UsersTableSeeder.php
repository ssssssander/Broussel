<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 200)->create();

        DB::table('users')->insert([
        [
            'name' => 'Louis Desmedt',
            'email' => 'user@example.com',
            'password' => bcrypt('user123456'),
            'role' => 'user',
            'status' => null,
            'nl' => null,
            'fr' => null,
            'en' => null,
            'motivation' => null,
            'info' => null,
            'available_times' => null,
        ],
        [
            'name' => 'Lisa Lenaerts',
            'email' => 'buddy@example.com',
            'password' => bcrypt('buddy123456'),
            'role' => 'buddy',
            'status' => 'accepted',
            'nl' => true,
            'fr' => false,
            'en' => false,
            'motivation' => 'Oranje noemen. Zijne heilige Majesteit spreekt dien man niet dadelijk opkraamt! En met den neus omhoog, zeggende: --Riekt gij dien donderslag? Ziet gij die vrouwe? --Ik ken ze niet, \'t zijn die eener rijke hoeve, goed voorzien van groot en struisch, diep is mijn bus, sprak Uilenspiegel, gij ziet er niet in, om den schoot Onzer Moeder de Heilige Kerk; moest ik hem in en bedekte hem met de.',
            'info' => 'De mannen stemden hiermee in, en antwoordde niet, dronk, betaalde en vertrok. De zeven vertrokken naar Petegem, langsheen de Leie, met het beste schip van Treslong eene kog van Biscaye, die geladen was met de tanden in bijtend, groef hij een man geeft, en ik drink op den weg deed meer dan drie vademen achteruit gleed; en, vlug als eene musch op een gebarsten doedelzak, terwijl een lieftallig.',
            'available_times' => '"[{\"day\":\"monday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"wednesday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"friday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"saturday\",\"available\":true,\"from\":\"18:15\",\"to\":\"23:20\"}]"',
        ],
        [
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'role' => 'admin',
            'status' => null,
            'nl' => null,
            'fr' => null,
            'en' => null,
            'motivation' => null,
            'info' => null,
            'available_times' => null,
        ],
        [
            'name' => env('EXAMPLE_ADMIN_NAME'),
            'email' => env('EXAMPLE_ADMIN_EMAIL'),
            'password' => bcrypt(env('EXAMPLE_ADMIN_PASSWORD')),
            'role' => 'admin',
            'status' => null,
            'nl' => null,
            'fr' => null,
            'en' => null,
            'motivation' => null,
            'info' => null,
            'available_times' => null,
        ]]);
    }
}
