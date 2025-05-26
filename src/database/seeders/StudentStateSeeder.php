<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentStateSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Active', 'Inactive', 'Suspended', 'Graduated', 'Withdrawn'];
        foreach ($statuses as $status) {
            DB::table('student_states')->insert([
                'name' => $status,
            ]);
        }
    }
}
