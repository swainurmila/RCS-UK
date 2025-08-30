<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersObjective extends Model
{
    protected $table = 'members_objective';
    protected $fillable = [
        'society_id',
        'member_responsibility_type',
        'capital_valuation_type',
        'capital_amount',
        'society_operational_area',
        'society_objective',
        'society_share_value',
        'subscription_rate',
        'member_liability',
        'general_member_count',
        'society_record_language',
        'society_representative_name',
        'society_representative_address',
        'society_representative_signature',
        'society_secretary_name',
        'society_secretary_address',
        'society_secretary_signature'
    ];

    public function society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
    }
}