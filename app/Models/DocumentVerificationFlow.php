<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVerificationFlow extends Model
{
   protected $fillable = [
        'society_app_detail_id',
        'document_id',
        'document_field',
        'status',
        'remarks',
        'verified_by'
    ];

    public function societyAppDetail()
    {
        return $this->belongsTo(SocietyAppDetail::class);
    }

    public function document()
    {
        return $this->belongsTo(SocietyRegisterDocuments::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

}
