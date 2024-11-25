<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marriage extends Model
{
    use SoftDeletes;

    protected $table = 'm_marriage';

    protected $fillable = [];
}
