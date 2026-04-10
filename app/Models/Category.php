<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    /**
     * Get all inventories that belong to this category.
     */
    public function inventories(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
