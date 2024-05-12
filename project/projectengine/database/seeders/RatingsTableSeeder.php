<?php

namespace Database\Seeders;

use App\Models\Rating;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{

    public function run(): void
    {
        /**
         * Run the database seeds.
         */
        Rating::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '1234',
        ]);
    }
}
