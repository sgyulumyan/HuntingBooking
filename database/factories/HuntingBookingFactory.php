<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\HuntingBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\HuntingBooking>
 */
class HuntingBookingFactory extends Factory
{
    protected $model = HuntingBooking::class;

    public function definition(): array
    {
        return [
            'tour_name' => $this->faker->words(5, true),
            'hunter_name' => $this->faker->name(),
            'guide_id' => Guide::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'participants_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
