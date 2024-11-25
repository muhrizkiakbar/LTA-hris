<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaksin extends Model
{
    protected $table = "vaksin";
    protected $fillable = ['users_id','vaksin_type_id','date','desc','file'];

    public function getVaksinTypeAttribute()
    {
        return VaksinType::find($this->vaksin_type_id);
    }

    public function getEmployeeAttribute()
    {
        return User::find($this->users_id);
    }
}
