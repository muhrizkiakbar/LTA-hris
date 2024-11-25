<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiRemarks extends Model
{
  protected $table = "absensi_remarks";

  protected $fillable = [
    'users_id', 
    'date',
    'remarks'
  ];

  public function getEmployeeAttribute()
  {
    return User::find($this->users_id);
  }
}
