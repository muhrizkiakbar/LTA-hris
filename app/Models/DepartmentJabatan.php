<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentJabatan extends Model
{
    protected $table = 'm_department_jabatan';

    protected $fillable = ['title', 'department_id', 'jabatan_id','kode'];

    public function getDepartmentAttribute()
    {
        return Department::find($this->department_id);
    }

    public function getJabatanAttribute()
    {
        return Department::find($this->jabatan_id);
    }
}
