<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraisalScoreLines extends Model
{
    protected $table = 'appraisal_score_lines';

    protected $fillable = ['appraisal_score_id','appraisal_key_id','appraisal_item_id','score'];

    protected $appends = [
        'appraisal_key','appraisal_item'
    ];

    public function getAppraisalKeyAttribute()
    {
        return AppraisalKey::find($this->appraisal_key_id);
    }

    public function getAppraisalItemAttribute()
    {
        return AppraisalItem::find($this->appraisal_item_id);
    }
}
