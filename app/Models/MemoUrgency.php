<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoUrgency extends Model
{
    protected $table = 'memo_urgency';

    protected $fillable = [
        'title'
    ];
}
