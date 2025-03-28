<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(PermissionManagerTablesSeeder::class);
        $this->call(ProductOptionSeeder::class);
        $this->call(ProductFieldSeeder::class);
        $this->call(ProductFieldOptionSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(DepositSeeder::class);
        $this->call(PrivacySeeder::class);
    }
}
