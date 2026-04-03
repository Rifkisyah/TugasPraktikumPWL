<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {

            $KodeJurusan = '55201';
            $KodeAngkatan = $faker->numberBetween(21, 25);
            $KodeUnik = str_pad($i + 1, 2, '0', STR_PAD_LEFT);

            $npm = (int) ($KodeJurusan . $KodeAngkatan . $KodeUnik);

            DB::Table('users')->insert([
                'npm' => $npm,
                'username' => $faker->username(),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => $faker->dateTime(),
                'password' => Hash::make($faker->password()),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
