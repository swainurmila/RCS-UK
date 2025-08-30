<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditBankDetails extends Model
{
    //
    protected $table = 'audit_bank_details';
    protected $fillable = [
        'audit_id',
        'bank_id',
        'district_id',
        'bank_address',
        'bank_head_office_address',
        'bank_letter_to_sbi',
        'balance_sheet',
        'profit_loss_statement',
        'lfar_annexture',
        'other_docs'
    ];

    public function districtRelation()
    {
        return $this->belongsTo(District::class, 'district_id');
    }


    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
