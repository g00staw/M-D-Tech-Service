<?php

namespace Database\Seeders;

use App\Models\Repair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Repair::insert(
            [
                [
                    'device_id' => '1',
                    'employee_id' => '1',
                    'user_id' => '1',
                    'report_date' => '2024-5-10', // poprawny format!
                    'user_notes' => 'Rozbity ekran',
                    'status' => 'zgłoszone',
                ],
                
            ]
        );
    }
}
