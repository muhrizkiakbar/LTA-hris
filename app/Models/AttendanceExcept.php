<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceExcept extends Model
{
    use HasFactory;

		protected $table = "attendance_except";

    protected $fillable = ['users_id', 'time'];
}
