<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'category_id', 'code', 'title', 'description',
        'start_at', 'end_at', 'location', 'capacity', 'status',
    ];

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