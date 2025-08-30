<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['name', 'member_type_id', 'gender', 'category', 'is_married', 'father_spouse_name', 'is_buisness', 'buisness_name', 'address', 'business', 'designation', 'signature', 'start_date', 'end_date', 'is_declared', 'created_at', 'updated_at'];
}
