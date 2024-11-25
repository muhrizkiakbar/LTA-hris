<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mutasi extends Model
{
    use SoftDeletes;
    protected $table = 'mutasi';
    protected $fillable = [
        'user_id',
        'department_id',
        'divisi_id',
        'm_jabatan_id',
        'm_department_jabatan_id',
        'tgl_mutasi',
        'status',
        'mutasi_sts_id',
        'atasan_id',
        'lokasi_id'
    ];

    public function getDepartmentAttribute()
    {
        return Department::find($this->department_id);
    }

    public function getDivisiAttribute()
    {
        return Divisi::find($this->divisi_id);
    }

    public function getEmployeeAttribute()
    {
        return User::find($this->user_id);
    }

    public function getLvlAttribute()
    {
        return Jabatan::find($this->m_jabatan_id);
    }

    public function getJabatanAttribute()
    {
        return DepartmentJabatan::find($this->m_department_jabatan_id);
    }

    public function getMutasiStsAttribute()
    {
        return MutasiSts::find($this->mutasi_sts_id);
    }
}
