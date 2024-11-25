<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CutiHeader extends Model
{
    use SoftDeletes, LogsActivity;
    protected $table = 'cuti_header';
    protected $fillable = [
        'kd',
        'employee_id',
        'employee_exchange_id',
        'cuti_type_id',
        'desc',
        'date',
        'approval',
        'lama_cuti',
        'cuti_qty',
        'date_start',
        'date_end',
        'cuti_khusus_id',
        'periode',
        'periode_type',
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
				'reject_excuse',
				'date_expired'
    ];

		public function getActivitylogOptions(): LogOptions
    {
			$data = [
				'kd',
        'employee_id',
        'employee_exchange_id',
        'cuti_type_id',
        'desc',
        'date',
        'approval',
        'lama_cuti',
        'cuti_qty',
        'date_start',
        'date_end',
        'cuti_khusus_id',
        'periode',
        'periode_type',
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

			return LogOptions::defaults()
											 ->logOnly($data)
											 ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}")
											 ->logOnlyDirty()
											 ->useLogName('Cuti Header');
    }

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

    public function getKhususAttribute()
    {
        return CutiKhusus::find($this->cuti_khusus_id);
    }

    public function getEmployeeExchangeAttribute()
    {
        return User::find($this->employee_exchange_id);
    }

		public function getRejectUserAttribute()
		{
				return User::find($this->reject_id);
		}
}
