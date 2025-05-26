<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
use App\Models\Major;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $majors = Major::all();

        foreach ($majors as $major) {
            Section::create([
                'name' => 'A',
                'major_id' => $major->id,
            ]);

            Section::create([
                'name' => 'B',
                'major_id' => $major->id,
            ]);
        }
    }
}
