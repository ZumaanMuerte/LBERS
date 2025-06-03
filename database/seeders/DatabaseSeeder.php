<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\WindSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            EarthquakeSeeder::class,
            WindSeeder::class,
            DisasterReportSeeder::class,
            AdminAccountSeeder::class,
        ]);
    }
}
