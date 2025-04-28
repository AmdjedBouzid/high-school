<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['created_at' => now(), 'name' => 'super-admin', 'updated_at' => now()],
            ['created_at' => now(), 'name' => 'admin', 'updated_at' => now()],
            ['created_at' => now(), 'name' => 'Supervisor', 'updated_at' => now()],

        ]);
    }
}
