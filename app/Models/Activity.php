<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_COMPLETED = 'completed';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_COMPLETED,
    ];

    protected $fillable = [
        'category_id', 'code', 'title', 'description',
        'start_at', 'end_at', 'location', 'capacity',
        'poster_path', 'status',
    ];

    protected static function booted(): void
    {
        // Kebijakan force delete: file poster ikut dihapus HANYA saat record dihapus permanen.
        // Soft delete tidak menyentuh file, supaya restore tetap menampilkan poster.
        static::forceDeleted(function (Activity $activity) {
            if ($activity->poster_path) {
                Storage::disk('public')->delete($activity->poster_path);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at'   => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function posterUrl(): ?string
    {
        return $this->poster_path ? asset('storage/' . $this->poster_path) : null;
    }

    public function scopeSearch($query, ?string $keyword)
    {
        return $query->when($keyword, function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                      ->orWhere('code', 'like', "%{$keyword}%");
            });
        });
    }

    public function scopeFilterCategory($query, $categoryId)
    {
        return $query->when($categoryId, fn ($q, $id) => $q->where('category_id', $id));
    }

    public function scopeFilterStatus($query, ?string $status)
    {
        return $query->when($status, fn ($q, $s) => $q->where('status', $s));
    }

    public function scopeSortByStart($query, ?string $direction)
    {
        return $query->orderBy('start_at', $direction === 'oldest' ? 'asc' : 'desc');
    }
}