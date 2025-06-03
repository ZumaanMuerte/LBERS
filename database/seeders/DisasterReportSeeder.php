<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DisasterReport;
use App\Models\Earthquake;
use App\Models\Wind;
use Illuminate\Database\Seeder;


class DisasterReportSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Minimal', 'Moderate', 'Severe', 'Worst', 'Catastrophic'];

        // Sample 5 from earthquakes
        Earthquake::inRandomOrder()->take(5)->get()->each(function ($eq) use ($statuses) {
            DisasterReport::create([
                'disaster_id' => $eq->id,
                'disaster_type' => 'earthquake',
                'date' => $eq->date,
                'location' => $eq->location,
                'damage_status' => $statuses[array_rand($statuses)],
            ]);
        });

        // Sample 5 from winds
        Wind::inRandomOrder()->take(5)->get()->each(function ($wind) use ($statuses) {
            DisasterReport::create([
                'disaster_id' => $wind->id,
                'disaster_type' => 'wind',
                'date' => $wind->date,
                'location' => $wind->location,
                'damage_status' => $statuses[array_rand($statuses)],
            ]);
        });
    }
}

