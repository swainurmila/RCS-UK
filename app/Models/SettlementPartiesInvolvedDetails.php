<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementPartiesInvolvedDetails extends Model
{
    protected $table = 'settlement_parties_involved_details';

    protected $fillable = [
        'settlement_id',
        'name1',
        'address1',
        'name2',
        'address2',
        'name3',
        'address3',
        'dname1',
        'daddress1',
        'dname2',
        'daddress2',
        'dname3',
        'daddress3',
    ];
}