<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ptkp extends Model
{
    use SoftDeletes;

    protected $table = 'm_ptkp';

    protected $fillable = ['title', 'amount'];
}
