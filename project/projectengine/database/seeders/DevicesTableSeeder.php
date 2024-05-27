<?php

namespace Database\Seeders;

use App\Models\Device;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::insert([
            'brand' => 'Samsung',
            'model' => 'S23',
            'serial_number' => '8957981372527',
            'purchase_date' => '2023-10-10',
            'is_registered' => true,
            'end_of_warranty' => '2025-10-10', // poprawny format!
            'type' => 'smartphone',
            'user_id' => '1',
        ]);
    }
}
