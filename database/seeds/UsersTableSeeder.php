<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        [
            'name' => 'Thee Kop',
            'email' => 't.k@hotmail.com',
            'password' => bcrypt('azerty123'),
            'role' => 0,
            'status' => null,
            'info' => null,
            'available_times' => null,
        ],
        [
            'name' => 'Bert Bollen',
            'email' => 'bert.bollen@hotmail.com',
            'password' => bcrypt('bertbollen123'),
            'role' => 1,
            'status' => 'accepted',
            'info' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken. Het heeft niet alleen vijf eeuwen overleefd maar is ook, vrijwel onveranderd, overgenomen in elektronische letterzetting. Het is in de jaren \'60 populair geworden met de introductie van Letraset vellen met Lorem Ipsum passages en meer recentelijk door desktop publishing software zoals Aldus PageMaker die versies van Lorem Ipsum bevatten.',
            'available_times' => '"[{\"day\":\"monday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"wednesday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"friday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"saturday\",\"available\":true,\"from\":\"18:15\",\"to\":\"23:20\"}]"',
        ],
        [
            'name' => 'Az Zer',
            'email' => 'a.b@c.com',
            'password' => bcrypt('11111111'),
            'role' => 1,
            'status' => 'accepted',
            'info' => 'Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de standaard proeftekst in deze bedrijfstak sinds de 16e eeuw, toen een onbekende drukker een zethaak met letters nam en ze door elkaar husselde om een font-catalogus te maken. Het heeft niet alleen vijf eeuwen overleefd maar is ook, vrijwel onveranderd, overgenomen in elektronische letterzetting. Het is in de jaren \'60 populair geworden met de introductie van Letraset vellen met Lorem Ipsum passages en meer recentelijk door desktop publishing software zoals Aldus PageMaker die versies van Lorem Ipsum bevatten.',
            'available_times' => '"[{\"day\":\"monday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"wednesday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"friday\",\"available\":true,\"from\":\"08:00\",\"to\":\"16:15\"},{\"day\":\"saturday\",\"available\":true,\"from\":\"18:15\",\"to\":\"23:20\"}]"',
        ]]);
    }
}
