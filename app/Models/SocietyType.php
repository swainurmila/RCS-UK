<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietyType extends Model
{
    // use HasFactory;
    protected $table = 'society_type';
    protected $fillable = ['type'];
}
