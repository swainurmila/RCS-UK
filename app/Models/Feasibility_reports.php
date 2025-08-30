<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feasibility_reports extends Model
{
    protected $table = 'feasibility_reports';
    protected $fillable = [
        'society_id',
        'society_name',
        'society_formation_reason',
        'society_type',
        'society_based_on',
        'bank_name',
        'society_bank_distance',
        'membership_limit',
        'total_members_ready_to_join',
        'is_member_active',
        'chairman_name',
        'secretary_name',
        'is_member_understood_rights',
        'is_member_awared_objectives',
        'is_existing_society',
        'society_registration_date',
        'society_completion_time',
        'additional_info',
        'area_operation',
        'authority_name',
        'authority_designation',
        'authority_signature',
    ];

    public function society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
    }
}