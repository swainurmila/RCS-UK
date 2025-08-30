<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditCaReport extends Model
{
    //
    protected $table='audit_ca_reports';
    protected $fillable = [
        'audit_id', 
        'auditor_certificate_opinion', 
        'audit_type', 
        'remark', 
        'signature'
    ];

    
}
