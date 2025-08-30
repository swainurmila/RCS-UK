<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementEvidenceDetails extends Model
{
    protected $table = 'settlement_evidence_details';

    protected $fillable = [
        'settlement_id',
        'amount_paid',
        'challan_no',
        'upload_challan_reciept',
        'upload_documentary_evidence',
        'upload_witness',
        'upload_any_other_supporting',
    ];
}