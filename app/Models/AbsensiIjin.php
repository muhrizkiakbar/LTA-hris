<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiIjin extends Model
{
  protected $table = "absensi_ijin";

  protected $fillable = [
    'kd',
    'users_id', 
    'date_start',
    'date_end', 
    'absensi_ijin_type_id',
    'file',
    'periksa_id',
    'periksa_st',
    'approval1_id',
    'approval1_st',
    'approval2_id',
    'approval2_st',
    'department_id',
    'jabatan_id',
    'department_jabatan_id',
    'lokasi_id',
    'divisi_id',
    'status',
    'keterangan',
		'reject_id',
		'reject_excuse'
  ];

  public function getEmployeeAttribute()
  {
    return User::find($this->users_id);
  }

  public function getAbsensiIjinTypeAttribute()
  {
    return AbsensiIjinType::find($this->absensi_ijin_type_id);
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
