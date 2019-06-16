<?php

use Illuminate\Database\Seeder;

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
            'name' => 'Thee Kop',
            'email' => 't.k@hotmail.com',
            'password' => bcrypt('azerty123'),
            'role' => 'user',
            'status' => null,
            'nl' => null,
            'fr' => null,
            'en' => null,
            'info' => null,
            'available_times' => null,
        ],
        [
            'name' => 'Sander',
            'email' => 's.b@hotmail.com',
            'password' => null,
            'role' => 'buddy',
            'status' => 'undecided',
            'nl' => true,
            'fr' => null,
            'en' => null,
            'info' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken. Het heeft niet alleen vijf eeuwen overleefd maar is ook, vrijwel onveranderd, overgenomen in elektronische letterzetting. Het is in de jaren \'60 populair geworden met de introductie van Letraset vellen met Lorem Ipsum passages en meer recentelijk door desktop publishing software zoals Aldus PageMaker die versies van Lorem Ipsum bevatten.',
            'available_times' => '"[{\"day\":\"monday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"wednesday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"friday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"saturday\",\"available\":true,\"from\":\"18:15\",\"to\":\"23:20\"}]"',
        ],
        [
            'name' => 'Bert Bollen',
            'email' => 'bert.bollen@hotmail.com',
            'password' => bcrypt('bertbollen123'),
            'role' => 'buddy',
            'status' => 'accepted',
            'nl' => true,
            'fr' => false,
            'en' => false,
            'info' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken. Het heeft niet alleen vijf eeuwen overleefd maar is ook, vrijwel onveranderd, overgenomen in elektronische letterzetting. Het is in de jaren \'60 populair geworden met de introductie van Letraset vellen met Lorem Ipsum passages en meer recentelijk door desktop publishing software zoals Aldus PageMaker die versies van Lorem Ipsum bevatten.',
            'available_times' => '"[{\"day\":\"monday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"wednesday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"friday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"saturday\",\"available\":true,\"from\":\"18:15\",\"to\":\"23:20\"}]"',
        ],
        [
            'name' => 'Azzie Zerpel',
            'email' => 'a.b@c.com',
            'password' => null,
            'role' => 'buddy',
            'status' => 'accepted',
            'nl' => true,
            'fr' => true,
            'en' => false,
            'info' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken. Het heeft niet alleen vijf eeuwen overleefd maar is ook, vrijwel onveranderd, overgenomen in elektronische letterzetting. Het is in de jaren \'60 populair geworden met de introductie van Letraset vellen met Lorem Ipsum passages en meer recentelijk door desktop publishing software zoals Aldus PageMaker die versies van Lorem Ipsum bevatten.',
            'available_times' => '"[{\"day\":\"monday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"wednesday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"friday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"saturday\",\"available\":true,\"from\":\"18:15\",\"to\":\"23:20\"}]"',
        ],
        [
            'name' => config('app.admin_name'),
            'email' => config('app.admin_email'),
            'password' => bcrypt( config('app.admin_password')),
            'role' => 'admin',
            'status' => null,
            'nl' => null,
            'fr' => null,
            'en' => null,
            'info' => null,
            'available_times' => null,
        ]]);
    }
}
