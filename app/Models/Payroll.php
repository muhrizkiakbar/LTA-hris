<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
		protected $table = 'payroll';
		protected $fillable = [
			'periode',
			'distrik_id',
			'lock',
			'hari_kerja'
		];

		public function getDistrikAttribute()
		{
			return Distrik::find($this->distrik_id);	
		}
}
