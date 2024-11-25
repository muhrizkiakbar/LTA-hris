<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dinas extends Model
{
    protected $table = "dinas";

    protected $fillable = [
        'kd',
        'users_id',
        'dinas_tipe_id',
        'date',
        'date_start',
        'date_end',
        'dinas_kendaraan_id',
        'desc',
        'trip_start',
        'trip_end',
        'jarak',
        'estimasi_harga',
        'uang_makan',
        'uang_hotel',
        'total_harga',
        'status',
        'periksa_id',
        'periksa_st',
        'approval1_id',
        'approval1_st',
        'approval1_excuse',
        'approval2_id',
        'approval2_st',
        'direktur_id',
        'reject_st',
        'reject_id',
        'department_id',
        'jabatan_id',
        'department_jabatan_id',
        'lokasi_id',
        'divisi_id',
        'catatan',
        'lama_dinas',
				'dinas_payment_id',
				'dinas_payment_proof',
				'dinas_payment_done',
				'trf_date'
    ];

    public function getEmployeeAttribute()
    {
        return User::find($this->users_id);
    }

    public function getDinasTipeAttribute()
    {
        return DinasTipe::find($this->dinas_tipe_id);
    }

    public function getDinasKendaraanAttribute()
    {
        return DinasKendaraan::find($this->dinas_kendaraan_id);
    }

    public function getTotalAttribute()
    {
        return 'Rp. '.number_format($this->total_harga,0,',','.');
    }

    public function getApprovalStsAttribute()
    {
			$role = auth()->user()->role_id;
			
			if($role==10)
			{
				$approval = $this->dinas_payment_id;

        if($approval==1)
        {
            return '<span class="badge badge-info">Pending</span>';
        }
        else if ($approval==2)
        {   
            return '<span class="badge badge-warning">On Payment</span>';
        }
        else if ($approval==3)
        {   
            return '<span class="badge badge-success">Done</span>';
        }
			}
			else
			{
				$approval = $this->status;

        if($approval==0)
        {
            return '<span class="badge badge-info">Open</span>';
        }
        else if ($approval==1)
        {   
            return '<span class="badge badge-success">Approve</span>';
        }
        else if ($approval==2)
        {   
            return '<span class="badge badge-danger">Reject</span>';
        }
			}
        
    }

    public function getPeriksaHrdAttribute()
    {
        return User::find($this->periksa_id);
    }

    public function getApprovalFirstAttribute()
    {
        return User::find($this->approval1_id);
    }

    public function getApprovalSecondAttribute()
    {
        return User::find($this->approval2_id);
    }

    public function getDepartmentAttribute()
    {
        return Department::find($this->department_id);
    }

    public function getJabatanAttribute()
    {
        return Jabatan::find($this->jabatan_id);
    }

    public function getDepartmentJabatanAttribute()
    {
        return DepartmentJabatan::find($this->department_jabatan_id);
    }

    public function getDivisiAttribute()
    {
        return Divisi::find($this->divisi_id);
    }

		public function getRejectUserAttribute()
		{
				return User::find($this->reject_id);
		}
}
