<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocietySectorType extends Model
{
    use HasFactory, SoftDeletes;
     protected $table = 'society_sector_types';
    protected $fillable = [
        'cooperative_sector_name',
        'is_active',
    ];
}
