<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'description',
        'available',
        'menu_group_id',
    ];

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available', true);
    }

    public function menuGroup(): BelongsTo
    {
        return $this->belongsTo(MenuGroup::class);
    }
}
