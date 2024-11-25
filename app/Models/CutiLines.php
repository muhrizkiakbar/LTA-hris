<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutiLines extends Model
{
    use SoftDeletes;
    protected $table = 'cuti_lines';
    protected $fillable = [
        'cuti_header_id',
        'date',
        'date_ph',
        'date_ph_end',
        'cuti_type_id',
        'value',
        'desc',
        'time_in',
        'time_out',
        'cuti_lines_id',
        'approval_st'
    ];

    public function getCutiTypeAttribute()
    {
        return CutiType::find($this->cuti_type_id);
    }
}
