<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietyRegistration extends Model
{
    protected $table = 'society_details';
    protected $fillable = ['auth_id', 'scheme_id', 'society_name', 'society_email', 'locality', 'post_office', 'developement_area', 'tehsil', 'district', 'nearest_station', 'society_category', 'applied_on', 'society_sector_type_id', 'is_credit_society'];

    protected $casts = [
        'applied_on' => 'datetime',
    ];

    // Relationship with Block (assuming 'developement_area' is the foreign key)
    public function block()
    {
        return $this->belongsTo(Block::class, 'developement_area', 'id'); // 'developement_area' is the foreign key in society_details
    }

    // Other existing relationships...
    public function membersObjectives()
    {
        return $this->hasOne(MembersObjective::class, 'society_id');
    }

    public function feasibilityReport()
    {
        return $this->hasOne(Feasibility_reports::class, 'society_id');
    }

    public function signatureDetails()
    {
        return $this->hasOne(InspectorReport::class, 'society_id');
    }
    /* public function signatureDetails()
    {
        return $this->hasOne(Signature_detail::class, 'society_id');
    } */

    public function memberDeclaration()
    {
        return $this->hasOne(Member_declaration::class, 'society_id');
    }

    public function members()
    {
        return $this->hasMany(Members::class, 'member_declaration_id');
    }
    public function districtName()
    {
        return $this->belongsTo(District::class, 'district', 'id');
    }
    public function getSocietyCategoryAttribute()
    {
        return match ((int) ($this->attributes['society_category'] ?? 0)) {
            1 => 'Primary',
            2 => 'Central',
            3 => 'Apex',
            default => 'N/A',
        };
    }

    public function appDetail()
    {
        return $this->hasOne(SocietyAppDetail::class, 'app_id', 'id');
    }

    public function societyType()
    {
        return $this->belongsTo(SocietyType::class, 'society_category', 'id');
    }

    public function registerDocuments()
    {
        return $this->hasOne(SocietyRegisterDocuments::class, 'society_id');
    }

    public function getSocietySectorType()
    {
        return $this->belongsTo(SocietySectorType::class, 'society_sector_type_id', 'id');
    }
    public function applicantUser()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }
    public function tehsilName()
    {
        return $this->belongsTo(Tehsil::class, 'tehsil', 'id');
    }
    public function inspectionStatus()
    {
        return $this->hasOne(InspectionTargetSociety::class, 'society_id', 'id');
    }
}
