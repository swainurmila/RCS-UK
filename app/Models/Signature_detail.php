<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature_detail extends Model
{
    protected $table = 'signature_details';
    protected $fillable = [
        'society_id',
        'authority_name',
        'authority_designation',
        'authority_signature'
    ];

    public function society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
    }
}
