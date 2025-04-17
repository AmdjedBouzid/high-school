<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentState;

class StudentStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Active'],
            ['name' => 'Inactive'],
            ['name' => 'Suspended'],
            ['name' => 'Graduated'],
            ['name' => 'Withdrawn'],
        ];

        foreach ($states as $state) {
            StudentState::create($state);
        }
    }
}
