<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditSocietyDetails extends Model
{
    //
    protected $table = 'audit_society_details';
    protected $fillable = [
        'audit_id',
        'society_id',
        'district',
        'block',
        'society_type',
        'society_chairman_name',
        'society_secretary_name',
        'balance_sheet',
        'profit_loss_statement',
        'other_docs'
    ];
    public function audit()
    {
        return $this->belongsTo(Audit::class, 'audit_id');
    }
}
