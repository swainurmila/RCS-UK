<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $table = 'otps';
    protected $fillable = ['role', 'user_id', 'otp', 'otp_ex_time', 'msg_id', 'status', 'error_code','email','mob_no'];
}
