<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlasifikasiTraining extends Model
{
  protected $table = 'klasifikasi_training';

  protected $fillable = ['title','st'];
}
