<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollIncentive extends Model
{
    use HasFactory;
		protected $table = 'payroll_incentive';
		protected $fillable = [
			'periode'
		];
}
