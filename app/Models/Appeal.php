<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function documents()
    {
        return $this->hasOne(AppealDocuments::class, 'appeal_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'appeal_by');
    }

    public function decision()
    {
        return $this->hasOne(AppealFinalDecision::class, 'appeal_id','id');
    }
}
