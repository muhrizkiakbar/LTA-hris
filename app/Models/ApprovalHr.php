<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalHr extends Model
{
    protected $table = 'approval_hr';

    protected $fillable = ['users_id','lokasi_id'];
    
    public function getEmployeeAttribute()
    {
        return User::find($this->users_id);
    }

    public function getLokasiAttribute()
    {
        return Lokasi::find($this->lokasi_id);
    }
}
