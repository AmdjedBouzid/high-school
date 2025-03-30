<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Absence;
use App\Models\Student;

class AbsenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Absence::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'day' => fake()->date(),
            'class_index' => fake()->word(),
            'address' => fake()->word(),
        ];
    }
}
