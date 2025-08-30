<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisions extends Model
{
    protected $table = 'divisions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'state_id',
        'name'
    ];
}
