<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Cast extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'name',
        'slug',
        'profile_image',
        'age',
        'height',
        'blood_type',
        'birthplace',
        'hobby',
        'special_skill',
        'self_introduction',
        'message',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
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

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CastImage::class)->orderBy('sort_order');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(CastBlog::class);
    }

    public function publishedBlogs(): HasMany
    {
        return $this->hasMany(CastBlog::class)
            ->where('is_published', true)
            ->orderByDesc('published_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getProfileImageUrlAttribute(): ?string
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : null;
    }

    public function getHeightDisplayAttribute(): ?string
    {
        return $this->height ? $this->height . 'cm' : null;
    }

    public function getMainImageAttribute(): ?string
    {
        // まずprofile_imageをチェック、なければimagesからprofileタイプを探す
        if ($this->profile_image) {
            return $this->profile_image;
        }

        $image = $this->images()->where('image_type', 'profile')->first()
            ?? $this->images()->first();

        return $image?->image_path;
    }
}
