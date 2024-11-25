<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingLines extends Model
{
    protected $table = "training_lines";

    protected $fillable = [
        'training_id','user_id','department_jabatan_id','lokasi_id','belting_id','hasil','review','note'
    ];

    public function getTrainingAttribute()
    {
        return Training::find($this->training_id);
    }

    public function getEmployeeAttribute()
    {
        return User::find($this->user_id);
    }

    public function getJabatanAttribute()
    {
        return DepartmentJabatan::find($this->department_jabatan_id);
    }

    public function getLokasiAttribute()
    {
        return Lokasi::find($this->lokasi_id);
    }

    public function getBeltingAttribute()
    {
        return Belting::find($this->belting_id);
    }
}
