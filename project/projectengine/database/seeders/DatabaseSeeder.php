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
        User::factory()->create([
            'name' => 'Marek Kowalski',
            'email' => 'marek@kow.com',
            'password' => '12345678',

        ]);
        User::factory()->create([
            'name' => 'Kamil Slimka',
            'email' => 'kamil@slim.com',
            'password' => '12345678',

        ]);
        User::factory()->create([
            'name' => 'Zbigniew Kucharski',
            'email' => 'zb@kuch.com',
            'password' => '12345678',

        ]);

        Admin::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@admin.com',
            'password' => '1234',
            
        ]);
        Admin::factory()->create([
            'name' => 'Kamil Nowak',
            'email' => 'kamil@nowak.com',
            'password' => '12345678',
            
        ]);

        Device::insert([
           /*  [
                'brand' => 'Samsung',
                'model' => 'S23',
                'serial_number' => '0385298571',
                'purchase_date' => '2023-10-10',
                'end_of_warranty' => '2025-10-10', // poprawny format!
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => '1',
            ], */
            [
                'brand' => 'iPhone',
                'model' => '13 Pro',
                'serial_number' => '7512012957',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2026-05-07',
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => 1,
            ],
             [
                'brand' => 'iPhone',
                'model' => '15 Pro',
                'serial_number' => '1912012942',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2026-05-07',
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => 2,
            ],
            [
                'brand' => 'Samsung',
                'model' => 'S24',
                'serial_number' => '0373412942',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2026-05-07',
                'is_registered' => true,
                'type' => 'smartphone',
                'user_id' => 3,
            ],
            [
                'brand' => 'Acer Predator',
                'model' => 'G15',
                'serial_number' => '0373232942',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2026-05-07',
                'is_registered' => true,
                'type' => 'PC',
                'user_id' => 4,
            ],
            [
                'brand' => 'Samsung',
                'model' => 'S24 Plus',
                'serial_number' => '9993412888',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2022-05-07',
                'is_registered' => false,
                'type' => 'smartphone',
                'user_id' => 3,
            ],
            [
                'brand' => 'Huawei',
                'model' => 'P50',
                'serial_number' => '9943412888',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2022-05-07',
                'is_registered' => false,
                'type' => 'smartphone',
                'user_id' => 3,
            ],
            [
                'brand' => 'Google',
                'model' => 'Pixel 8',
                'serial_number' => '3221412888',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2022-05-07',
                'is_registered' => false,
                'type' => 'smartphone',
                'user_id' => 2,
            ],
            [
                'brand' => 'Realme',
                'model' => '12 Pro',
                'serial_number' => '3276512876',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2022-05-07',
                'is_registered' => false,
                'type' => 'smartphone',
                'user_id' => 1,
            ],
            [
                'brand' => 'Google',
                'model' => 'Pixel 8 Pro',
                'serial_number' => '1237412888',
                'purchase_date' => '2024-05-07',
                'end_of_warranty' => '2022-05-07',
                'is_registered' => false,
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
                'report_date' => '2024-5-10',
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wyświetlacz nie reaguje na dotyk'
            ],
            [
                'device_id' => '6',
                'employee_id' => '1',
                'user_id' => '3',
                'report_date' => '2024-5-29',
                'user_notes' => 'Rozwalona obudowa',
                'status' => 'ukończono',
                'repair_title' => 'Plecki odpadają od telefonu, wgnieciona ramka.'
            ],
            [
                'device_id' => '7',
                'employee_id' => '1',
                'user_id' => '2',
                'report_date' => '2024-5-25',
                'user_notes' => 'Zniszczony ekran',
                'status' => 'ukończono',
                'repair_title' => 'Ekran jest cały stłuczony, nie reaguje na dotyk.'
            ],
            [
                'device_id' => '8',
                'employee_id' => '1',
                'user_id' => '1',
                'report_date' => '2024-5-25',
                'user_notes' => 'Zniszczony ekran',
                'status' => 'ukończono',
                'repair_title' => 'Ekran jest cały stłuczony, nie reaguje na dotyk.'
            ],
            [
                'device_id' => '2',
                'employee_id' => '1',
                'user_id' => '2',
                'report_date' => '2024-5-10',
                'user_notes' => 'Zepsuta bateria',
                'status' => 'zgłoszone',
                'repair_title' => 'Telefon wyłącza się bo wyjęciu ładowarki'
            ],
            [
                'device_id' => '3',
                'employee_id' => '1',
                'user_id' => '3',
                'report_date' => '2024-5-10',
                'user_notes' => 'Zepsuta bateria',
                'status' => 'ukończono',
                'repair_title' => 'Telefon wyłącza się bo wyjęciu ładowarki'
            ],
            [
                'device_id' => '9',
                'user_id' => '1',
                'employee_id' => null,
                'report_date' => '2024-5-25',
                'user_notes' => 'Rozbity ekran',
                'status' => 'zgłoszone',
                'repair_title' => 'Wyświetlacz nie reaguje na dotyk'
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
                'user_id' => '3',
                'repair_id' => '2',
                'amount' => '560.00',
                'status' => 'completed',
                'payment_date' => '2024-5-29',
                'payment_method' => 'credit_card',
            ],
            [    
                'user_id' => '2',
                'repair_id' => '3',
                'amount' => '720.00',
                'status' => 'completed',
                'payment_date' => '2024-5-28',
                'payment_method' => 'credit_card',
            ],
            [    
                'user_id' => '1',
                'repair_id' => '3',
                'amount' => '440.00',
                'status' => 'completed',
                'payment_date' => '2024-5-27',
                'payment_method' => 'credit_card',
            ],

        ]);

        Rating::insert([
            [            
                'user_id' => '3',
                'repair_id' => '2',
                'rating' => '5',
                'review' => 'Super obsługa!'
            ],
            [            
                'user_id' => '2',
                'repair_id' => '3',
                'rating' => '4',
                'review' => 'Jest ok.'
            ],



        ]);



    }
}
