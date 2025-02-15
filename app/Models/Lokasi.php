<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use SoftDeletes;

    protected $table = "m_lokasi";

    protected $fillable = ['title','kode','uang_makan'];
}
