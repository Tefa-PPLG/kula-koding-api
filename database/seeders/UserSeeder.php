<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "username" => "admin",
            "kelas" => "admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("admin"),
            "isVerified" => 1,
            "role" => "admin"
        ]);

        $faker = \Faker\Factory::create();

        for ($i=0; $i < 20; $i++) { 
            User::create([
                "username" => $faker->name(),
                "kelas" => $faker->name(),
                "email" => $faker->email(),
                "password" => Hash::make($faker->password()),
                "isVerified" => 0,
                "role" => "user"
            ]);
        }
    }
}
