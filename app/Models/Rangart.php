<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rangart extends Model
{
    use SoftDeletes;
    protected $table = 'rangarten';
    protected $fillable = ['name'];
}
