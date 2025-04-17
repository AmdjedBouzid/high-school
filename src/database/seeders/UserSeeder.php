<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        for($i=1; $i < 4; $i++) { 
            $user = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => "amdjedmr_{$i}",
                'email' => $faker->unique()->safeEmail,
                'role_id' => $i,
                'password' => '123456789',
            ]);
            $user->save();
        }
    }
}
