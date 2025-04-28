<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Grade;
use App\Models\Major;


class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $firstYear = Grade::where('name', 'First Year')->first();
        $secondYear = Grade::where('name', 'Second Year')->first();
        $thirdYear = Grade::where('name', 'Third Year')->first();

        $majors = [
            ['name' => 'Common Core Science and Technology', 'grade_id' => $firstYear->id],
            ['name' => 'Common Trunk Literature and Philosophy', 'grade_id' => $firstYear->id],
            ['name' => 'Mathematics', 'grade_id' => $secondYear->id],
            ['name' => 'Mechanical Engineering Technical', 'grade_id' => $secondYear->id],
            ['name' => 'Electrical Engineering Technical', 'grade_id' => $secondYear->id],
            ['name' => 'Literature and Philosophy', 'grade_id' => $secondYear->id],
            ['name' => 'Languages', 'grade_id' => $secondYear->id],
            ['name' => 'Science', 'grade_id' => $secondYear->id],
            ['name' => 'Mathematics', 'grade_id' => $thirdYear->id],
            ['name' => 'Mechanical Engineering Technical', 'grade_id' => $thirdYear->id],
            ['name' => 'Electrical Engineering Technical', 'grade_id' => $thirdYear->id],
            ['name' => 'Literature and Philosophy', 'grade_id' => $thirdYear->id],
            ['name' => 'Languages', 'grade_id' => $thirdYear->id],
            ['name' => 'Science', 'grade_id' => $thirdYear->id],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
