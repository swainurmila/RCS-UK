<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    //
    protected $table = 'audits';
    protected $fillable = [
        'audit_ref_no',
        'ca_firm_name',
        'ca_firm_reg_no',
        'ca_name',
        'ca_membership_no',
        'audit_period',
        'ca_email',
        'ca_address',
        'ca_mobile_no',
        'ca_website',
        'audit_for',
        'status'
    ];
    const AUDIT_FOR_BANK = 1;
    const AUDIT_FOR_SOCIETY = 2;

    protected $casts = [
        'audit_for' => 'integer',
    ];

    public function societyDetails()
    {
        return $this->hasOne(AuditSocietyDetails::class,'audit_id','id');
    }

    public function bankDetails()
    {
        return $this->hasOne(AuditBankDetails::class);
    }

    public function caReport()
    {
        return $this->hasOne(AuditCaReport::class);
    }

    public function appDetail()
    {
        return $this->hasOne(SocietyAppDetail::class, 'app_id', 'id');
    }
     public function society_details()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_detail_id', 'id');
    }
}
