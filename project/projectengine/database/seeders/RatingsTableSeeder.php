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
        Rating::insert([
            'user_id' => '1',
            'repair_id' => '1',
            'rating' => 5,
            'review' => "wszystko ok",

        ]);
    }
}
