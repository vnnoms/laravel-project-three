<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
    'category_id', 'code', 'title', 'description', 'activity_date', 'status',
    ];
    protected $casts = [
        'activity_date' => 'date',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }   
}