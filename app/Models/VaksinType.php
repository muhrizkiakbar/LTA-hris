<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaksinType extends Model
{
    protected $table = "vaksin_type";
    protected $fillable = ['title'];
}
