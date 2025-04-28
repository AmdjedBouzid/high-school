<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create a super admin
        DB::table('users')->insert([
            [
                'first_name' => 'Amdjed',
                'last_name' => 'Bouzid',
                'username' => 'amdjedbouzid',
                'email' => 'amdjedbouzid9@gmail.com',
                'password' => Hash::make('amdjed2004'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create 5 admins
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'first_name' => "Admin{$i}",
                'last_name' => "User{$i}",
                'username' => "admin{$i}",
                'email' => "admin{$i}@example.com",
                'password' => Hash::make('amdjed2004'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create 20 supervisors and their info
        for ($i = 1; $i <= 20; $i++) {
            $userId = DB::table('users')->insertGetId([
                'first_name' => "Supervisor{$i}",
                'last_name' => "User{$i}",
                'username' => "supervisor{$i}",
                'email' => "supervisor{$i}@example.com",
                'password' => Hash::make('amdjed2004'),
                'role_id' => 3, // Assuming 3 is the ID for "Supervisor"
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('supervisor_infos')->insert([
                'user_id' => $userId,
                'phone_number' => '05' . str_pad((string)rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'address' => "Address {$i}",
                'sexe' => $i % 2 === 0 ? 'M' : 'F',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
