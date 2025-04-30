<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,

            StudentStateSeeder::class,
            StudentTypeSeeder::class,
            GradeSeeder::class,
            MajorSeeder::class,
            SectionSeeder::class,
            StudentSeeder::class,

            // Add other seeders here
        ]);
    }
}
