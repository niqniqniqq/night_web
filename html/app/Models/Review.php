<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'user_id',
        'nickname',
        'title',
        'content',
        'rating_overall',
        'rating_service',
        'rating_atmosphere',
        'rating_cost_performance',
        'visit_date',
        'is_approved',
        'is_featured',
        'helpful_count',
        'ip_address',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'visit_date' => 'date',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getAverageRatingAttribute(): float
    {
        return round(($this->rating_overall + $this->rating_service + $this->rating_atmosphere + $this->rating_cost_performance) / 4, 1);
    }

    public function incrementHelpfulCount(): void
    {
        $this->increment('helpful_count');
    }
}
