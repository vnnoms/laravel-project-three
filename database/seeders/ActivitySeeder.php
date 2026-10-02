<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 15) as $i) {
            Activity::create([
                'category_id' => $i % 2 === 0 ? 1 : 2,
                'code'        => sprintf('ACT-%03d', $i),
                'title'       => "Kegiatan contoh {$i}",
                'description' => 'Data uji.',
                'start_at'    => now()->addDays($i),
                'end_at'      => now()->addDays($i)->addHours(3),
                'location'    => $i === 1 ? null : 'Lab ' . (($i % 3) + 1),   // ACT-001 sengaja tidak lengkap
                'capacity'    => 20 + $i,
                'status'      => $i % 3 === 0 ? 'published' : 'draft',
            ]);
        }
    }
}