<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    protected $table = "surat_tugas";

    protected $fillable = [
        'kd',
        'employee_id',
        'desc',
        'date',
        'approval',
        'date_start',
        'date_end',
        'periksa_id',
        'periksa_st',
        'approval1_id',
        'approval1_st',
        'approval2_id',
        'approval2_st',
        'direktur_id',
        'doc',
        'catatan',
        'department_id',
        'jabatan_id',
        'department_jabatan_id',
        'lokasi_id',
        'divisi_id',
				'reject_id',
				'reject_excuse'
    ];

    public function getEmployeeAttribute()
    {
        return User::find($this->employee_id);
    }

    public function getApprovalStsAttribute()
    {
        $approval = $this->approval;

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

    public function getDirekturAttribute()
    {
        return User::find($this->direktur_id);
    }

		public function getRejectUserAttribute()
		{
				return User::find($this->reject_id);
		}
}
