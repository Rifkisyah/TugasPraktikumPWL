<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookshelvesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::Table('bookshelves')->insert([
            [
                'code' => '001',
                'name' => 'ilmu pengetahuan umum'
            ],
            [
                'code' => '005',
                'name' => 'Program Komputer'
            ],
            [
                'code' => '016',
                'name' => 'Biografi Subjek'
            ],
            [
                'code' => '031',
                'name' => 'Ensiklopedi dalam bahasa Indonesia'
            ]
        ]);
    }
}
