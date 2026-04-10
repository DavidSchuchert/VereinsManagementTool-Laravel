<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zahlungsart extends Model
{
    use SoftDeletes;
    protected $table = 'zahlungsarten';
    protected $fillable = ['name'];
}
