<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = "training";

    protected $fillable = [
        'title','klasifikasi_training_id','date','trainer'
    ];

    public function getKlasifikasiAttribute()
    {
      return KlasifikasiTraining::find($this->klasifikasi_training_id);
    }
}
