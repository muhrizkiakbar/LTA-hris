<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direktur extends Model
{
    use SoftDeletes;

    protected $table = 'm_direktur';

    protected $fillable = ['title','email','nohp','ttd'];
}
