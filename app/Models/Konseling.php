<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
  protected $table = 'konseling';

  protected $fillable = ['users_id', 'date', 'catatan', 'file'];
}
