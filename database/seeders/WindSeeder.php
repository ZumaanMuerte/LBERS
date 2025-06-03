<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Wind;
use Illuminate\Database\Seeder;

class WindSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['Manila', 'Cebu', 'Davao', 'Baguio', 'Tacloban'];
        $signals = [
            'Tropical Depression','Tropical Storm','Severe Tropical Storm','Typhoon','Super Typhoon'
        ];

        foreach (range(1, 10) as $i) {
            Wind::create([
                'date' => now()->subDays(rand(1, 100)),
                'location' => $locations[array_rand($locations)],
                'wind_signal' => $signals[array_rand($signals)],
            ]);
        }
    }
}

