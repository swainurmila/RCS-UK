<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementDeclarationDetails extends Model
{
    protected $table = 'settlement_declaration_details';

    protected $fillable = [
        'settlement_id',
        'is_confirmed',
        'Upload_signature',
        'is_individual',
        'upload_resolution',
        'aadhar_upload',
    ];
}