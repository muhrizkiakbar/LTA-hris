<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollConfig extends Model
{
    use HasFactory;
		protected $table = 'payroll_config';
		protected $fillable = [
			'hari_kerja'
		];
}
