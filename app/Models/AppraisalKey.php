<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalKey extends Model
{
    use SoftDeletes;

    protected $table = 'appraisal_key';

    protected $fillable = ['title'];
}
