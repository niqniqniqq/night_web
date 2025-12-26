<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'day_of_week',
        'open_time',
        'close_time',
        'is_closed',
        'note',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i',
    ];

    public const DAYS = [
        0 => '日',
        1 => '月',
        2 => '火',
        3 => '水',
        4 => '木',
        5 => '金',
        6 => '土',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function getDayNameAttribute(): string
    {
        return self::DAYS[$this->day_of_week] ?? '';
    }

    public function getFormattedTimeAttribute(): string
    {
        if ($this->is_closed) {
            return '定休日';
        }

        if (!$this->open_time || !$this->close_time) {
            return '-';
        }

        return $this->open_time->format('H:i') . ' - ' . $this->close_time->format('H:i');
    }
}
