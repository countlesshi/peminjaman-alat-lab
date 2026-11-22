<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = ['lab_id', 'code', 'name', 'item_condition'];

    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}