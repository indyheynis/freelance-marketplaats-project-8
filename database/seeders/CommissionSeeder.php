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
                'deadline' => '2026-05-31',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Website Development',
                'description' => 'Develop a responsive e-commerce website with a user-friendly interface.',
                'budget' => 2000.00,
                'status' => 'in_progress',
                'deadline' => '2026-06-15',
                'category_id' => 2,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Social Media Marketing',
                'description' => 'Create and manage social media campaigns to increase brand awareness.',
                'budget' => 800.00,
                'status' => 'open',
                'deadline' => '2026-07-30',
                'category_id' => 3,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Promo Video',
                'description' => 'Produce a 60-second promotional video for our product launch.',
                'budget' => 1500.00,
                'status' => 'open',
                'deadline' => '2026-06-20',
                'category_id' => 4,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Product Photography',
                'description' => 'Capture high-quality product photos for our online store.',
                'budget' => 600.00,
                'status' => 'completed',
                'deadline' => '2026-04-15',
                'category_id' => 5,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Landing Page Copy',
                'description' => 'Write persuasive copy for a high-converting landing page.',
                'budget' => 350.00,
                'status' => 'open',
                'deadline' => '2026-05-10',
                'category_id' => 6,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Mobile App Redesign',
                'description' => 'Redesign the UI/UX of our existing iOS and Android apps.',
                'budget' => 3500.00,
                'status' => 'in_progress',
                'deadline' => '2026-08-01',
                'category_id' => 7,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Fitness Tracker App',
                'description' => 'Build a cross-platform mobile app for tracking fitness goals.',
                'budget' => 4000.00,
                'status' => 'open',
                'deadline' => '2026-09-15',
                'category_id' => 8,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'SEO Audit & Optimization',
                'description' => 'Conduct a full SEO audit and implement improvements for higher rankings.',
                'budget' => 900.00,
                'status' => 'open',
                'deadline' => '2026-05-25',
                'category_id' => 9,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Explainer Animation',
                'description' => 'Create a 90-second animated explainer video for our SaaS product.',
                'budget' => 1800.00,
                'status' => 'open',
                'deadline' => '2026-07-10',
                'category_id' => 10,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Commercial Voice Over',
                'description' => 'Record a professional voice over for a 30-second radio commercial.',
                'budget' => 400.00,
                'status' => 'completed',
                'deadline' => '2026-04-01',
                'category_id' => 11,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Dutch to English Translation',
                'description' => 'Translate 10,000 words of marketing content from Dutch to English.',
                'budget' => 700.00,
                'status' => 'in_progress',
                'deadline' => '2026-05-20',
                'category_id' => 12,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Sales Data Analysis',
                'description' => 'Analyze our Q1 sales data and provide actionable insights.',
                'budget' => 550.00,
                'status' => 'open',
                'deadline' => '2026-05-05',
                'category_id' => 13,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => '3D Product Visualization',
                'description' => 'Create photorealistic 3D renders of our new furniture line.',
                'budget' => 1200.00,
                'status' => 'open',
                'deadline' => '2026-06-30',
                'category_id' => 14,
                'user_id' => 1,
                'created_at' => now(),
            ],
            [
                'title' => 'Podcast Intro Music',
                'description' => 'Compose and produce a 15-second energetic podcast intro jingle.',
                'budget' => 300.00,
                'status' => 'open',
                'deadline' => '2026-05-15',
                'category_id' => 15,
                'user_id' => 1,
                'created_at' => now(),
            ],
        ];
        DB::table('commissions')->insert($commissions);
    }
}
