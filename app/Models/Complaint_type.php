<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint_type extends Model
{
    protected $table = 'complaint_types';
    protected $fillable = [
        'name','value'
    ];
}
