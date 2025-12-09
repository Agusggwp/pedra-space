<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  // database/seeders/UserSeeder.php
public function run()
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@toko.com',
        'password' => bcrypt('12345678'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Kasir 1',
        'email' => 'kasir@toko.com',
        'password' => bcrypt('12345678'),
        'role' => 'kasir',
    ]);
}
}
