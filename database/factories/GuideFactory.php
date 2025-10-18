<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    protected $model = Guide::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'experience_years' => $this->faker->numberBetween(0, 30),
            'is_active' => $this->faker->boolean(80),
        ];
    }

    public function active(): self
    {
        return $this->state(fn () => ['is_active' => true]);
    }

    public function inactive(): self
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
