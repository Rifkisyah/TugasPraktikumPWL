<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LoanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 15; $i++) {

            DB::Table('loan_detail')->insert([
                'loan_id' => $faker->randomElement(DB::Table('loans')->pluck('id')->toArray()),
                'book_id' => $faker->randomElement(DB::Table('books')->pluck('id')->toArray()),
                'is_return' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
