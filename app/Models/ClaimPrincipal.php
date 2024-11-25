<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimPrincipal extends Model
{
    use HasFactory;
		protected $table = 'claim_principal';
    protected $fillable = ['title'];
}
