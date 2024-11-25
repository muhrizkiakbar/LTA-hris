<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollLines extends Model
{
    use HasFactory;
		protected $table = 'payroll_lines';
		protected $fillable = [
			'payroll_id',
			'periode',
			'users_id',
			'nik',
			'department_id',
			'jabatan_id',
			'lokasi_id',
			'join_date',
			'gaji_pokok',
			'tunjangan_jabatan',
			'tunjangan_makan',
			'tunjangan_transport',
			'tunjangan_sewa',
			'tunjangan_pulsa',
			'tunjangan_lain',
			'incentive_reg',
			'incentive_gm',
			'lembur',
			'principal',
			'thr',
			'trf15',
			'total_klaim',
			'nama_principle_klaim',
			'potongan_alpa',
			'potongan_telat',
			'potongan_absensi',
			'potongan_jht',
			'potongan_jp',
			'potongan_kes',
			'potongan_pph21',
			'potongan_batal_nota',
			'potongan_pinjaman',
			'total_trf',
			'full_pendapatan',
			'full_potongan',
			'mdp',
			'daily_gaji_pokok',
			'off'
		];

		public function getUserDetailAttribute()
		{
			return User::find($this->users_id);
		}

		public function getDepartmentAttribute()
    {
    	return Department::find($this->department_id);
    }

		public function getJabatanAttribute()
    {
			return Jabatan::find($this->jabatan_id);
    }

		public function getLokasiAttribute()
    {
			$get = Lokasi::find($this->lokasi_id);
			if (empty($get)) {
					return '-';
			} else {
					return $get->title;
			}
    }
}
