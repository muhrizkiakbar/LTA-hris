<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sloting extends Model
{
    protected $table = 'sloting';
    
    protected $fillable = [
        'kd',
        'department_id',
        'department_jabatan_id',
        'cabang_id',
        'divisi_id',
				'jabatan_id',
        'users_id'
    ];

    protected $appends = [
        'employee','department','jabatan','cabang','divisi'
    ];

    public function getEmployeeAttribute()
    {
        return User::find($this->users_id);
    }

    public function getDepartmentAttribute()
    {
        return Department::find($this->department_id);
    }

    public function getJabatanAttribute()
    {
        return DepartmentJabatan::find($this->department_jabatan_id);
    }

    public function getCabangAttribute()
    {
        return Cabang::find($this->cabang_id);
    }

    public function getDivisiAttribute()
    {
        return Divisi::find($this->divisi_id);
    }

		public function getLevelAttribute()
    {
        return Jabatan::find($this->jabatan_id);
    }
}
