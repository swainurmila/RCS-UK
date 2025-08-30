<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietyRegisterDocuments extends Model
{
    protected $table = 'society_register_documents';
    protected $fillable = [
        'society_id',
        'meeting1',
        'meeting2',
        'meeting3',
        'all_id_proof',
        'all_application_form',
        'all_declaration_form',
        'society_by_laws',
        'challan_proof',
            // Status fields
    'meeting1_status', 'meeting2_status', 'meeting3_status', 'society_by_laws_status',
    'all_id_proof_status', 'all_application_form_status', 'all_declaration_form_status', 'challan_proof_status',
    // Remarks fields
    'meeting1_remarks', 'meeting2_remarks', 'meeting3_remarks', 'society_by_laws_remarks',
    'all_id_proof_remarks', 'all_application_form_remarks', 'all_declaration_form_remarks', 'challan_proof_remarks',
    // Revised document fields
    'meeting1_revised', 'meeting2_revised', 'meeting3_revised', 'society_by_laws_revised',
    'all_id_proof_revised', 'all_application_form_revised', 'all_declaration_form_revised', 'challan_proof_revised'
    ];

    public function society()
{
    return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
}
}
