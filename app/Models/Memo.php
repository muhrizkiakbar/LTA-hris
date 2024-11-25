<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $table = 'memo';

    protected $fillable = [
        'users_id',
        'memo_type_id',
        'memo_urgency_id',
        'ref',
        'subject',
        'date',
        'desc',
        'department_id',
        'divisi_id',
        'department_jabatan_id',
        'jabatan_id'
    ];

    public function getMemoTypeAttribute()
    {
        return MemoType::find($this->memo_type_id);
    }

    public function getMemoUrgencyAttribute()
    {
        return MemoUrgency::find($this->memo_urgency_id);
    }

    public function getEmployeeAttribute()
    {
        return User::find($this->users_id);
    }
}
