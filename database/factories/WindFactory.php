<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wind>
 */
class WindFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $windSignals=['Tropical Depression', 'Tropical Storm','Severve Tropical Storm', 'Typhoon','Super Typhoon'];

        return [
            //
            'location'=>$this->faker->city(),
            'wind_signal'=>$this->faker->randomElement($windSignals),
            'movement' => $this->faker->randomElement(['North','South','East','West','Northeast','Northwest', 'Southeast', 'Southwest']),
            'intensity'=>$this->faker->randomFloat(1,10,200). 'km/h',
        ];
    }
}
