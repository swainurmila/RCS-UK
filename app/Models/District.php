<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function blocks() {
        return $this->hasMany(Block::class);
    }
   
public function amendmentSocieties()
{
    return $this->hasMany(AmendmentSociety::class, 'district');
}
public function societyRegistrations()
{
    return $this->hasMany(SocietyAppDetail::class, 'district_id', 'id');
}


}
