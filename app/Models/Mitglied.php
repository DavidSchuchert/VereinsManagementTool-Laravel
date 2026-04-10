<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\LogsActivity;

class Mitglied extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'mitglieder';

    protected $fillable = [
        'vorname',
        'nachname',
        'geburtsdatum',
        'plz',
        'ort',
        'strasse',
        'hausnummer',
        'telefon',
        'email',
        'eintrittsdatum',
        'austrittsdatum',
        'rang_id',
    ];

    public function rangart()
    {
        return $this->belongsTo(Rangart::class, 'rang_id');
    }
}
