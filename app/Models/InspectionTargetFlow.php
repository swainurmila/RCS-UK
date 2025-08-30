<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionTargetFlow extends Model
{
    public function actedBy()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }
}
