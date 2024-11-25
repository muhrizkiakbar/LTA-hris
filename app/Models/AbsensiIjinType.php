<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiIjinType extends Model
{
  protected $table = "absensi_ijin_type";

  protected $fillable = ['title','label'];
}
