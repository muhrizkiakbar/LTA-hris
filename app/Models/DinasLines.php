<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasLines extends Model
{
    protected $table = "dinas_lines";

    protected $fillable = [
        'dinas_id',
        'users_id',
        'date',
        'status'
    ];
}
