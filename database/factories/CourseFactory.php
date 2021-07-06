<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uid' => $this->faker->uuid,
            'course_number' => $this->faker->numberBetween($min = 10, $max = 200),
            'name' => $this->faker->name,
            'date_from' => now(),
            'date_to' => now(),
        ];
    }
}
