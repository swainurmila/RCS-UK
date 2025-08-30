<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditAlotment extends Model
{
    protected $table='audit_alotments';
    protected $fillable=['fy_id','dept_auditor_id','society_type_id','district_id','block_id','society_id','status',     'audit_start_date_auditor','audit_end_date_auditor','audit_start_date_society','audit_end_date_society','current_role','ca_id','user_id'];

    public function society()
    {
        return $this->belongsTo(SocietyAppDetail::class, 'society_id');
    }
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
    
    public function societyType()
    {
        return $this->belongsTo(SocietyType::class, 'society_type_id');
    }
    
    public function auditor()
    {
        return $this->belongsTo(User::class, 'dept_auditor_id');
    }
    
    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class, 'fy_id');
    }
}
