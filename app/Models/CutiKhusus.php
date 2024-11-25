<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutiKhusus extends Model
{
    use SoftDeletes;
    protected $table = 'cuti_khusus';
}
