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
            'info' => 'Uilenspiegel en sprak tot den prins, het geld te ontvangen--die voor een kroezeken water; maar dit.',
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
            'info' => null,
            'available_times' => null,
        ]]);
    }
}
