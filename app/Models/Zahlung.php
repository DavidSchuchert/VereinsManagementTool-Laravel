<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\LogsActivity;

class Zahlung extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'zahlungen';

    protected $fillable = [
        'betrag',
        'datum',
        'zahlungsart_id',
        'typ',
        'beschreibung',
        'rechnungsnr',
        'file_path',
        'user_id',
    ];

    public function zahlungsart()
    {
        return $this->belongsTo(Zahlungsart::class, 'zahlungsart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
