<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tehsil extends Model
{
    public function district() {
        return $this->belongsTo(District::class);
    }
}
