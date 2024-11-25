<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasUang extends Model
{
    protected $table = 'dinas_uang';
    protected $fillable = ['jabatan_id','uang_makan','uang_hotel'];

    public function getJabatanAttribute()
    {
        return Jabatan::find($this->jabatan_id);
    }
}
