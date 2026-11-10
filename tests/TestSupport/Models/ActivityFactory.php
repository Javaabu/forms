<?php

namespace Javaabu\Forms\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'date_a' => $this->faker->date,
            'date_b' => $this->faker->date,
            'date_c' => $this->faker->dateTime,
            'date_d' => $this->faker->date,
            'date_e' => $this->faker->dateTime,
        ];
    }
}
