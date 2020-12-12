<?php

namespace Database\Factories;

use App\Metric;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Metric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(20),
            'value' => $this->faker->numberBetween(10,1000),
            'sort'  =>  $this->faker->randomDigit(),
            'pub'   =>  $this->faker->boolean(),
        ];
    }
}
