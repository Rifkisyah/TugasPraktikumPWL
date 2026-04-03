<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReturnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 15; $i++) {

            DB::Table('returns')->insert([
                'loan_detail_id' => $faker->randomElement(DB::Table('loan_detail')->pluck('id')->toArray()),
                'charge' => $faker->boolean(),
                'amount' => $faker->numberBetween(1000, 50000),
            ]);
        }
    }
}
