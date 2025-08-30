<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementApplicationDetails extends Model
{
    protected $table = 'settlement_application_details';

    protected $fillable = [
        'user_id',
        'applicant_name',
        'father_name',
        'mobile_number	',
        'email',
        'full_address',
        'status',
        'submitted_to_role',
        'submitted_to_user_id',
        'current_role'
    ];
}