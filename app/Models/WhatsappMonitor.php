<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappMonitor extends Model
{
    use HasFactory;
		protected $table = "whatsapp_monitor";
    protected $fillable = ['teks','no_wa','message','subject','status_api','message_api','lokasi_id','date'];

		public function getStatusAttribute()
		{
			$status = $this->status_api;

			if ($status=='200') 
			{
				$label = '<span class="badge badge-success">'.$this->message_api.'</span>';
			}
			else
			{
				$label = '<span class="badge badge-danger">'.$this->message_api.'</span>';
			}

			return $label;
		}
}
