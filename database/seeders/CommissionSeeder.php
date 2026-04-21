<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commissions = [
            [
                'title' => 'Logo Design',
                'description' => 'Design a modern and creative logo for our new brand.',
                'budget' => 500.00,
                'status' => 'open',
                'deadline' => '2024-07-31',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Website Development',
                'description' => 'Develop a responsive e-commerce website with a user-friendly interface.',
                'budget' => 2000.00,
                'status' => 'open',
                'deadline' => '2024-08-15',
                'category_id' => 2,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Social Media Marketing',
                'description' => 'Create and manage social media campaigns to increase brand awareness.',
                'budget' => 800.00,
                'status' => 'open',
                'deadline' => '2024-09-30',
                'category_id' => 3,
                'user_id' => 1,
                'created_at' => now(),
            ],
        ];
        DB::table('commissions')->insert($commissions);
    }
}
