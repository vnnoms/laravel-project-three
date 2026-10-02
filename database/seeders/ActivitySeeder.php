<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Activity::create([
            'category_id'   => 1,
            'code'          => 'ACT-001',
            'title'         => 'Belajar Laravel Dasar',
            'description'   => 'Latihan CRUD dasar.',
            'activity_date' => '2026-10-10',
            'status'        => 'Planned',
        ]);
        Activity::create([
            'category_id' => 2,
            'code' => 'ACT-002',
            'title' => 'Styling Website Portfolio',
            'description' => 'Using css for styling and layout to enhance the current html structure',
            'activity_date' => '2026-09',
            'status' => 'Done',
        ]);

        Activity::create([
            'category_id' => 3,
            'code' => 'ACT-003',
            'title' => 'Interactivity Website Portfolio',
            'description' => 'Using javascript for user interactivity',
            'activity_date' => '2026-09',
            'status' => 'Done',
        ]);

        Activity::create([
            'category_id' => 4,
            'code' => 'ACT-004',
            'title' => 'Laravel Framework Introduction',
            'description' => 'Using framework for making easy web developer',
            'activity_date' => '2026-09',
            'status' => 'On-going',
        ]);

        Activity::create([
            'category_id' => 5,
            'code' => 'ACT-005',
            'title' => 'Database Migrate with SQLite',
            'description' => 'For providing the data from the database',
            'activity_date' => '2026-09',
            'status' => 'On-going',
        ]);
    }
}