<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLokasi extends Model
{
    protected $table = 'users_lokasi';

    protected $fillable = ['users_id','lokasi_id'];

    public function getLokasiAttribute()
    {
        return Lokasi::find($this->lokasi_id);   
    }
}
