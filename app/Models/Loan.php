<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'start_at', 'end_at', 'status', 'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

   public function scopeOverlapping(Builder $query, $startAt, $endAt): Builder
    {
        return $query
            ->whereIn('status', ['dipesan', 'dipinjam'])
            ->where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt);
    }

    public function isLate(): bool
    {
        return $this->status === 'dipinjam' && $this->end_at->isPast();
    }

    public static function stats(): array
    {
        return [
            'dipesan'      => static::where('status', 'dipesan')->count(),
            'dipinjam'     => static::where('status', 'dipinjam')->count(),
            'terlambat'    => static::where('status', 'dipinjam')->where('end_at', '<', now())->count(),
            'dikembalikan' => static::where('status', 'dikembalikan')->count(),
        ];
    }
}