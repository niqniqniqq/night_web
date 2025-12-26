<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CastImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'cast_id',
        'image_path',
        'alt_text',
        'image_type',
        'sort_order',
    ];

    public function cast(): BelongsTo
    {
        return $this->belongsTo(Cast::class);
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
