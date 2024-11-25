<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalItem extends Model
{
    use SoftDeletes;

    protected $table = 'appraisal_item';

    protected $fillable = ['appraisal_key_id','title','desc'];

    protected $appends = [
        'appraisal_key'
    ];

    public function getAppraisalKeyAttribute()
    {
        return AppraisalKey::find($this->appraisal_key_id);
    }
}
