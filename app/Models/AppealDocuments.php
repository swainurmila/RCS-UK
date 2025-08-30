<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppealDocuments extends Model
{
    public function appeal()
    {
        return $this->belongsTo(Appeal::class, 'appeal_id');
    }

    public function askingUser()
    {
        return $this->belongsTo(User::class, 'asking_id');
    }
}
