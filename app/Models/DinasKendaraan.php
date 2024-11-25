<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasKendaraan extends Model
{
    protected $table = 'dinas_kendaraan';
    protected $fillable = ['title','km','harga_bbm'];
}
