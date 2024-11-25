<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoType extends Model
{
    protected $table = 'memo_type';

    protected $fillable = [
        'title'
    ];
}
