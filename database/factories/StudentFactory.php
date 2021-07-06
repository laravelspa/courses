<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => $this->faker->numberBetween($min = 1, $max = 100),
            'name' => $this->faker->name,
            'military_num' => $this->faker->numberBetween($min = 1000, $max = 3000),
            'section' => $this->faker->word,
        ];
    }
}
