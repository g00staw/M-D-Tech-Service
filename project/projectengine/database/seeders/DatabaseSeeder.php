<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Techservice;
use App\Models\User;
use App\Models\Admin;
use App\Models\Device;
use App\Models\Employee;
use App\Models\Rating;
use App\Models\Repair;
use App\Models\Payment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '1234',

        ]);

        Admin::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@admin.com',
            'password' => '1234',
        ]);

        Device::insert([
            [
                'brand' => 'Samsung',
                'model' => 'S23',
                'serial_number' => '0385298571',
                'purchase_date' => '2023-10-10',
                'end_of_warranty' => '2025-10-10', // poprawny format!
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => '1',
            ],
            [
                'brand' => 'iPhone',
                'model' => '13 Pro',
                'serial_number' => '7512012957',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2026-05-07',
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => null,
            ],
            [
                'brand' => 'iPhone',
                'model' => '15 Pro',
                'serial_number' => '1912012942',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2026-05-07',
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => 1,
            ],

        ]);

        Employee::factory()->create([
            'name' => 'employee Test',
            'email' => 'emp@emp.com',
            'password' => bcrypt('1234'), 
            'salary' => 4250,
        ]);

        Employee::factory()->create([
            'name' => 'Zbigniew Kucharski',
            'email' => 'zbg.kucharski@gmail.com',
            'password' => bcrypt('1234'), 
            'salary' => 3750,
        ]);

        Repair::insert([
            [
                'device_id' => '1',
                'employee_id' => '1',
                'user_id' => '1',
                'report_date' => '2024-5-10', // poprawny format!
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wymiana ekranu'
            ],
            [
                'device_id' => '1',
                'employee_id' => '1',
                'user_id' => '1',
                'report_date' => '2024-5-11', // poprawny format!
                'user_notes' => 'Telefon sie wyłącza po wyciągnięciu ładowarki',
                'status' => 'zgłoszone',
                'repair_title' => 'Problem z baterią'
            ],
            [
                'device_id' => '1',
                'employee_id' => '1',
                'user_id' => '1',
                'report_date' => '2024-5-12', // poprawny format!
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wymiana ekranu'
            ],
            [
                'device_id' => '1',
                'employee_id' => '1',
                'user_id' => '1',
                'report_date' => '2024-5-13', // poprawny format!
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wymiana ekranu'
            ],
            [
                'device_id' => '1',
                'employee_id' => '1',
                'user_id' => '1',
                'report_date' => '2024-5-14', // poprawny format!
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wymiana ekranu'
            ],
            [
                'device_id' => '1',
                'employee_id' => null,
                'user_id' => '1',
                'report_date' => '2024-5-15', // poprawny format!
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wymiana ekranu'
            ],

        ]);

        Rating::insert([
            [
                'user_id' => '1',
                'repair_id' => '1',
                'rating' => 5,
                'review' => "wszystko ok",
            ],
            [
                'user_id' => '1',
                'repair_id' => '2',
                'rating' => 5,
                'review' => "wszystko ok",
            ],
            [
                'user_id' => '1',
                'repair_id' => '3',
                'rating' => 5,
                'review' => "wszystko ok",
            ],
            [
                'user_id' => '1',
                'repair_id' => '4',
                'rating' => 5,
                'review' => "wszystko ok",
            ],
            [
                'user_id' => '1',
                'repair_id' => '5',
                'rating' => 5,
                'review' => "wszystko ok",
            ],
            [
                'user_id' => '1',
                'repair_id' => '6',
                'rating' => 5,
                'review' => "wszystko ok",
            ],

        ]);

        Techservice::insert([
            [
                'title' => 'Wymiana baterii smartphona',
                'description' => 'Wymiana baterii na nową w smartphonie wraz z gwarancją na dwa lata.',
                'price_min' => '150.00',
                'price_max' => '750.00',
            ],
            [
                'title' => 'Naprawa gniazda ładowania smartphona',
                'description' => 'Naprawa gniazda ładowania w smartphonie wraz z gwarancją na rok.',
                'price_min' => '100.00',
                'price_max' => '350.00',
            ],
            [
                'title' => 'Wymiana dysku twardego',
                'description' => 'Wymiana dysku twardego na nowy wraz z gwarancją na dwa lata.',
                'price_min' => '100.00',
                'price_max' => '400.00',
            ],
            [
                'title' => 'Naprawa klawiatury laptopa',
                'description' => 'Naprawa klawiatury w laptopie wraz z gwarancją na dwa lata.',
                'price_min' => '150.00',
                'price_max' => '550.00',
            ],
            [

                'title' => 'Czyszczenie laptopa / komputera',
                'description' => 'Profesjonalne czyszczenie laptopa /komputera wraz z wymianą past termoprzewodzących oraz termopadów.',
                'price_min' => '100.00',
                'price_max' => '300.00',
            ],
            [

                'title' => 'Wymiana / naprawa procesora w komputerze',
                'description' => 'Wymiana / naprawa procesora na nowy w komputerze wraz z gwarancją na dwa lata.',
                'price_min' => '200.00',
                'price_max' => '2000.00',
            ],
            [

                'title' => 'Naprawa zasilacza komputera',
                'description' => 'Naprawa zasilacza w komputerze wraz z gwarancją na dwa lata.',
                'price_min' => '200.00',
                'price_max' => '1000.00',
            ],

        ]);

        Payment::insert([
            [
                'user_id' => 1,
                'repair_id' => 1,
                'amount' => 150.00,
                'payment_date' => '2024-5-21',
                'status' => 'completed',
                'payment_method' => 'credit_card'
            ],
            [
                'user_id' => 1,
                'repair_id' => 2,
                'amount' => 200.50,
                'payment_date' => '2024-5-20',
                'status' => 'completed',
                'payment_method' => 'paypal'
            ],
            [
                'user_id' => 1,
                'repair_id' => 3,
                'amount' => 75.00,
                'payment_date' => '2024-5-19',
                'status' => 'completed',
                'payment_method' => 'cash'
            ],
            [
                'user_id' => 1,
                'repair_id' => 4,
                'amount' => 120.75,
                'payment_date' => '2024-5-18',
                'status' => 'completed',
                'payment_method' => 'credit_card'
            ],
            [
                'user_id' => 1,
                'repair_id' => 5,
                'amount' => 99.99,
                'payment_date' => '2024-5-17',
                'status' => 'completed',
                'payment_method' => 'paypal'
            ],
            [
                'user_id' => 1,
                'repair_id' => 6,
                'amount' => 130.00,
                'payment_date' => '2024-5-16',
                'status' => 'completed',
                'payment_method' => 'cash'
            ],
        ]);


    }
}
