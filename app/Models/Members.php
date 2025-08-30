<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SocietyRegistration;

class Members extends Model
{
    protected $table = 'members';
    protected $fillable = [
        'name',
        'contact_no',
        'aadhar_no',
        'society_id',
        'member_declaration_id',
        'gender',
        'category',
        'is_married',
        'father_spouse_name',
        'is_buisness',
        'buisness_name',
        'address',
        'business',
        'designation',
        'signature',
        'start_date',
        'end_date',
        'membership_form',
        'declaration1',
        'declaration2',
    ];
    // public function memberdeclaration()
    // {
    //     return $this->belongsTo(Member_declaration::class, 'id');
    // }

    public function society_details()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id', 'id');
    }

    public function society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'member_declaration_id', 'id');
    }
    public function member_declaration()
    {
        return $this->belongsTo(Member_declaration::class, 'member_declaration_id');
    }
}