<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Active', 'Inactive', 'Suspended', 'Graduated', 'Withdrawn'];
        foreach ($statuses as $status) {
            DB::table('record_statuses')->insert([
                'name' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
