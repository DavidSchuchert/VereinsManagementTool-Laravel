<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventar extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'inventar';

    protected $fillable = [
        'artikel',
        'ean',
        'menge',
        'bemerkung',
        'lagerstandort',
        
    ];
}
