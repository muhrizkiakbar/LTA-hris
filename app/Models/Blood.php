<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blood extends Model
{
    use SoftDeletes;

    protected $table = 'm_blood';

    protected $fillable = [];
}
