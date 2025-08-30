<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementDisputeDetails extends Model
{
    protected $table = 'settlement_dispute_details';

    protected $fillable = [
        'settlement_id',
        'against_the_defendant',
        'plaintiff_seek_arbitration',
        'cause_of_action_arose',
        'valuation_case',
        'valuation_case_amount',
        'desired_relief',
        'witnesses_and_documents',
    ];
}
