<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Lemuel Herrera',
            'username' => 'lem',
            'role' => 'admin',
            'email' => 'lemuelherra@gmail.com',
            'password' => Hash::make('asdf1234'),
        ]);

        \App\Models\Settings::create([
            'code' => 'VENUE',
            'value' => '02',
            'setter' => 'lemuelherra@gmail.com',
        ]);

        \App\Models\Settings::create([
            'code' => 'PRIZE',
            'value' => '2',
            'setter' => 'lemuelherra@gmail.com',
        ]);

        \App\Models\Settings::create([
            'code' => 'ENABLED',
            'value' => 'Y',
            'setter' => 'lemuelherra@gmail.com',
        ]);
    }
}
