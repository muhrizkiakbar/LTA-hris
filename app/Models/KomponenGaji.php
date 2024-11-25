<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    use HasFactory;
		protected $table = 'komponen_gaji';
		protected $fillable = [
			'users_id',
			'department_id',
			'jabatan_id',
			'lokasi_id',
			'gaji_pokok',
			'tunjangan_jabatan',
			'tunjangan_transport',
			'tunjangan_makan',
			'tunjangan_sewa',
			'tunjangan_pulsa',
			'tunjangan_lain',
			'active',
			'bpjs_except'
 		];

		public function getUserAttribute()
		{
			return User::find($this->users_id);
		}
}
