<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LoansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 15; $i++) {

            DB::Table('loans')->insert([
                'user_npm' => $faker->randomElement(DB::Table('Users')->pluck('npm')->toArray()),
                'loan_at' => $faker->dateTime(),
                'return_at' => $faker->dateTime(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
