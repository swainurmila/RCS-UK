<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    protected $table = 'scheme';
    protected $fillable = ['name', 'created_at', 'updated_at'];
    
}
