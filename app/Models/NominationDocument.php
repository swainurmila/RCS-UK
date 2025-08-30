<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominationDocument extends Model
{

    protected $fillable = [
        'nomination_id',
        'is_new_society',
        'formation_date',
        'last_election_date',
        'election_certificate',
        'balance_sheet',
        'audit_report',
        'proposal',
        'members_list',
        'ward_allocation',
        'challan_receipt',
        'secretary_name',
        'secretary_signature',
        'chairman_name',
        'chairman_signature',
        'remark','remark_file','approved'
    ];

    public function nomination()
    {
        return $this->belongsTo(Nomination::class);
    }
}

