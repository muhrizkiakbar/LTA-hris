<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'm_department';

    protected $fillable = ['title', 'direktur_id','kode'];

    public function getDirekturAttribute()
    {
        return User::find($this->direktur_id);
    }
}
