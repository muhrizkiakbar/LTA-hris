<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiIjinLines extends Model
{
    protected $table = "absensi_ijin_lines";

    protected $fillable = [
        'absensi_ijin_id',
        'users_id',
        'date',
        'absensi_ijin_type_id',
        'status'
    ];

    public function getAbsensiIjinTypeAttribute()
    {
        return AbsensiIjinType::find($this->absensi_ijin_type_id);
    }
}
