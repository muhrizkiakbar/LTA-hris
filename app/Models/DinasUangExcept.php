<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DinasUangExcept extends Model
{
    use HasFactory;

		protected $table = 'dinas_uang_except';
		protected $fillable = ['jabatan_id','department_id','lokasi_asal_id','lokasi_tujuan_id','uang_makan','uang_hotel'];

		public function getJabatanAttribute()
		{
			return Jabatan::find($this->jabatan_id);
		}

		public function getDepartmentAttribute()
		{
			return Department::find($this->department_id);
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
