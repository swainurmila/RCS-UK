<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectorReport extends Model
{
    protected $table = 'inspector_reports';
    protected $fillable = [
        'society_id',
        'permanent_inspection_date',
        'member_knowledge',
        'panchayat_suitability',
        'family_wilingness',
        'family_wilingness_reason',
        'is_bank_capital_available',
        'authority_name',
        'authority_designation',
        'authority_signature'
    ];

    public function society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
    }
}