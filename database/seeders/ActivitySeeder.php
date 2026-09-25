<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::create([
            'title' => 'Creating Website Portfolio',
            'description' => 'Using html for basic structure',
            'activity_date' => '2026-09',
            'category' => 'Website Programming',
            'status' => 'Done',
        ]);

        Activity::create([
            'title' => 'Styling Website Portfolio',
            'description' => 'Using css for styling and layout to enhance the current html structure',
            'activity_date' => '2026-09',
            'category' => 'Website Development',
            'status' => 'Done',
        ]);

        Activity::create([
            'title' => 'Interactivity Website Portfolio',
            'description' => 'Using javascript for user interactivity',
            'activity_date' => '2026-09',
            'category' => 'Website Development',
            'status' => 'Done',
        ]);
    }
}