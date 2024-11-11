<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zahlung extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'zahlungen';

    protected $fillable = [
        'betrag',
        'datum',
        'zahlungsart_id',
        'typ',
        'beschreibung',
        'rechnungsnr',
        'file_path',
    ];

    public function zahlungsart()
    {
        return $this->belongsTo(Zahlungsart::class, 'zahlungsart_id');
    }
}
