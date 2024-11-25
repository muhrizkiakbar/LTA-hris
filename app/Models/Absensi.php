<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "absensi";

    protected $fillable = ['nik', 'date', 'time'];

    public function getEmployeeAttribute()
    {
        $get = User::where('nik', $this->nik)->first();
        if (empty($get)) {
            return '-';
        } else {
            return $get->name;
        }
    }
}
