<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\LogsActivity;

class Inventar extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'inventar';

    protected $fillable = [
        'artikel',
        'ean',
        'menge',
        'bemerkung',
        'lagerstandort',
        'kategorie_id',
    ];

    /**
     * Get the category that belongs to this inventory item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
