<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Shop extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'area_id',
        'station_id',
        'name',
        'slug',
        'catch_copy',
        'description',
        'thumbnail',
        'address',
        'building',
        'phone',
        'access',
        'price_info',
        'system_info',
        'official_url',
        'is_featured',
        'is_active',
        'published_at',
        'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function businessTypes(): BelongsToMany
    {
        return $this->belongsToMany(BusinessType::class, 'shop_business_types')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    public function primaryBusinessType(): BelongsToMany
    {
        return $this->belongsToMany(BusinessType::class, 'shop_business_types')
            ->wherePivot('is_primary', true);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ShopImage::class)->orderBy('sort_order');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ShopSchedule::class)->orderBy('day_of_week');
    }

    public function castMembers(): HasMany
    {
        return $this->hasMany(Cast::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    public function scopeWithBusinessType($query, $businessTypeId)
    {
        return $query->whereHas('businessTypes', function ($q) use ($businessTypeId) {
            $q->where('business_types.id', $businessTypeId);
        });
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function getAverageRatingAttribute(): ?float
    {
        $avg = $this->approvedReviews()->avg('rating_overall');
        return $avg ? round($avg, 1) : null;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    public function getMainImageAttribute(): ?string
    {
        $image = $this->images()->where('image_type', 'main')->first();
        return $image ? $image->image_path : $this->thumbnail;
    }
}
