<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = 'inspections';
    protected $fillable = [
        'financial_year',
        'inspection_month',
        'district_id',
        'block_id',
        'society_type',
        'society_id',
        'upload_inspection',
        'assign_officer_id',
        'remarks',
        'submitted_to_user_id',
        'submitted_to_role',
        'current_role'
    ];

    public function society_details()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
    }

    public function flows()
    {
        return $this->hasMany(InspectionApplicationFlow::class, 'inspection_id', 'id');
    }
}