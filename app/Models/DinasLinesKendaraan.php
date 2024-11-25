<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasLinesKendaraan extends Model
{
  protected $table = 'dinas_lines_kendaraan';
  protected $fillable = ['dinas_id','dinas_kendaraan_id','jarak','estimasi_harga','sharing_kendaraan','lokasi_asal_id','lokasi_tujuan_id','jarak_toleransi','dinas_biaya_tol_id','dinas_biaya_tol_harga','pemakaian_bbm','total_harga','twoway','twoway_tol'];

  public function getKendaraanAttribute()
  {
    return DinasKendaraan::find($this->dinas_kendaraan_id);
  }

  public function getLokasiAsalAttribute()
  {
    return Lokasi::find($this->lokasi_asal_id);
  }

  public function getLokasiTujuanAttribute()
  {
    return Lokasi::find($this->lokasi_tujuan_id);
  }
}
