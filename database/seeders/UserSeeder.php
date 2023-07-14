<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Please use the .env file to store the Admin Credentials.
        User::create([
            'name' => env('DB_SEEDER_NAME'),
            'email' => env('DB_SEEDER_EMAIL'),
            'password' => Hash::make(env('DB_SEEDER_PASSWORD')),
        ]);
    }
}
