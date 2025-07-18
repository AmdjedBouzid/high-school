<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Section;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $sections = Section::all();
        $studentIndex = 1;

        foreach ($sections as $section) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('students')->insert([
                    'first_name' => "Student{$studentIndex}",
                    'last_name' => "Lastname{$studentIndex}",
                    'code' => "S" . strtoupper(Str::random(5)) . $studentIndex,
                    'section_id' => $section->id,
                    'student_state_id' => rand(1, 5),
                    'student_type_id' => rand(1, 2),
                ]);
                $studentIndex++;
            }
        }
    }
}
