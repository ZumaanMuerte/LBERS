<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Earthquake;
use Illuminate\Database\Seeder;

class EarthquakeSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['Manila', 'Cebu', 'Davao', 'Baguio', 'Tacloban'];
        $intensities = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

        foreach (range(1, 10) as $i) {
            Earthquake::create([
                'date' => now()->subDays(rand(1, 100)),
                'location' => $locations[array_rand($locations)],
                'intensity_scale' => $intensities[array_rand($intensities)],
            ]);
        }
    }
}
