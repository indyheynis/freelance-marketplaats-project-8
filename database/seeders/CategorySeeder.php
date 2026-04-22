<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Graphic Design'],
            ['name' => 'Web Development'],
            ['name' => 'Digital Marketing'],
            ['name' => 'Video Production'],
            ['name' => 'Photography'],
            ['name' => 'Copywriting'],
            ['name' => 'UI/UX Design'],
            ['name' => 'Mobile App Development'],
            ['name' => 'SEO Optimization'],
            ['name' => 'Animation'],
            ['name' => 'Voice Over'],
            ['name' => 'Translation'],
            ['name' => 'Data Analysis'],
            ['name' => '3D Modeling'],
            ['name' => 'Music Production'],
        ];
        DB::table('categories')->insert($categories);
    }
}
