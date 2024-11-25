<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasBiayaTol extends Model
{
    protected $table = 'dinas_biaya_tol';
    protected $fillable = ['title','biaya'];
}
