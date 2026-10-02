<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    private const PUBLISH_REQUIRED = [
        'category_id' => 'kategori',
        'code'        => 'kode',
        'title'       => 'judul',
        'location'    => 'lokasi',
        'start_at'    => 'tanggal mulai',
        'end_at'      => 'tanggal selesai',
        'capacity'    => 'kapasitas',
    ];

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== Activity::STATUS_DRAFT) {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan draft yang dapat dipublikasikan.',
            ]);
        }

        $problems = $this->publishProblems($activity);

        if ($problems !== []) {
            throw ValidationException::withMessages(['status' => $problems]);
        }

        $activity->update(['status' => Activity::STATUS_PUBLISHED]);

        return $activity;
    }

    public function complete(Activity $activity): Activity
    {
        if ($activity->status !== Activity::STATUS_PUBLISHED) {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan published yang dapat diselesaikan.',
            ]);
        }

        $activity->update(['status' => Activity::STATUS_COMPLETED]);

        return $activity;
    }

    private function publishProblems(Activity $activity): array
    {
        $missing = [];

        foreach (self::PUBLISH_REQUIRED as $field => $label) {
            $value = $activity->{$field};

            if ($value === null || (is_string($value) && trim($value) === '')) {
                $missing[] = $label;
            }
        }

        if ($missing !== []) {
            return ['Kegiatan belum dapat dipublikasikan. Lengkapi dulu: ' . implode(', ', $missing) . '.'];
        }

        $problems = [];

        if ($activity->end_at->lt($activity->start_at)) {
            $problems[] = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
        }

        if ($activity->capacity < 1 || $activity->capacity > 500) {
            $problems[] = 'Kapasitas harus antara 1 dan 500.';
        }

        return $problems;
    }
}