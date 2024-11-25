<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPeringatan extends Model
{
  protected $table = "surat_peringatan";

  protected $fillable = ['kd','users_id','m_sp_id','date','expired','pelanggaran','nomor'];

  public function getSpAttribute()
  {
    return Sp::find($this->m_sp_id);
  }

  public function getUserAttribute()
  {
    return User::find($this->users_id);
  }
}
