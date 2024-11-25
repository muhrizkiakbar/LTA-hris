<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalScore extends Model
{
    use SoftDeletes;

    protected $table = 'appraisal_score';

    protected $fillable = ['kd','users_id','date_start','date_end','lokasi_id','atasan_id','manager_id','department_id','divisi_id','jabatan_id','department_jabatan_id','review_atasan','review_manager','atasan_st','manager_st'];

    public function getEmployeeAttribute()
    {
        return User::find($this->users_id);
    }

    public function getAtasanAttribute()
    {
        return User::find($this->atasan_id);
    }

    public function getLokasiAttribute()
    {
        return Lokasi::find($this->lokasi_id);
    }

    public function getScoreTotalAttribute()
    {
        return AppraisalScoreLines::where('appraisal_score_id', $this->id)->sum('score');
    }

    public function getDepartmentAttribute()
    {
        return Department::find($this->department_id);
    }

    public function getJabatanAttribute()
    {
        return Jabatan::find($this->jabatan_id);
    }

    public function getDepartmentJabatanAttribute()
    {
        return DepartmentJabatan::find($this->department_jabatan_id);
    }

    public function getDivisiAttribute()
    {
        return Divisi::find($this->divisi_id);
    }

    public function getKontrakAttribute()
    {
        return KontrakKerja::where('user_id',$this->users_id)->where('status',1)->orderBy('id','DESC')->limit(1)->first();
    }
}
