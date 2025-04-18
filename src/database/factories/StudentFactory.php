<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\RecordStatus;
use App\Models\Student;
use App\Models\StudentType;

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
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'class' => fake()->word(),
            'code' => fake()->word(),
            'record_status_id' => RecordStatus::factory(),
            'student_type_id' => StudentType::factory(),
        ];
    }
}
