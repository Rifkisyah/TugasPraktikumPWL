<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 30; $i++) {

            DB::Table('books')->insert([
                'title' => $faker->title(),
                'author' => $faker->name(),
                'year' => $faker->year(),
                'publisher' => $faker->company(),
                'city' => $faker->city(),
                'cover' => $faker->imageUrl(200, 300, 'books', true),
                'bookshelf_id' => $faker->randomElement(DB::Table('bookshelves')->pluck('id')->toArray()),
                'categories_id' => $faker->randomElement(DB::Table('categories')->pluck('id')->toArray()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
