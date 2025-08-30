<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagingCommitte extends Model
{
    protected $table='amendment_managing_committes';
    protected $fillable=['society_id','existing_bylaw','bylaw_section','proposed_amendment','purpose_of_amendment','approval','committee_approval_doc','registration_certificate'];
}
