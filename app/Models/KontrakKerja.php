<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KontrakKerja extends Model
{
    protected $table = 'kontrak_kerja';
    protected $fillable = [
        'user_id',
        'tgl_start',
        'employee_sts_id',
        'tgl_end',
        'dokumen',
        'status'
    ];

    public function getEmployeeAttribute()
    {
        return User::find($this->user_id);
    }

    public function getEmployeeStsAttribute()
    {
        return EmployeeSts::find($this->employee_sts_id);
    }
}
