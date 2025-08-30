<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_divisions extends Model
{
    protected $table = 'sub_divisions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'district_id'
    ];
}
