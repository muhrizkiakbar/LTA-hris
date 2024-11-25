<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResignInterviewScore extends Model
{
    use HasFactory;
	
		public function getResignInterviewAttribute()
		{
			return ResignInterview::find($this->resign_interviews_id);
		}
}
