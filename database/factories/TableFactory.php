<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Table::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'week_number' => $this->faker->numberBetween($min = 1, $max = 100),
            'program_id' => $this->faker->numberBetween($min = 1, $max = 100),
            'pdf_src' => 'test.pdf',
            'date_from' => now(),
            'date_to' => now(),
        ];
    }
}
