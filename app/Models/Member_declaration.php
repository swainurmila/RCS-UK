<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member_declaration extends Model
{
    protected $table = 'member_declarations';
    protected $fillable = [
        'is_declared','society_id'
    ];
    // public function members()
    // {
    //     return $this->hasMany(Members::class, 'member_declaration_id ');
    // }

    public function society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society_id');
    }
    
    public function members()
    {
        return $this->hasMany(Members::class, 'member_declaration_id');
    }
}