<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmendmentApplicationStatusLog extends Model
{
    protected $table = 'amendment_application_status_logs';

    protected $fillable = [
        'amendment_id',
        'action_type',
        'old_value',
        'new_value',
        'performed_by_role',
        'performed_by_user',
        'remarks',
    ];

    // Define relationships to other models
    public function amendment()
    {
        return $this->belongsTo(AmendmentSociety::class, 'amendment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by_user');
    }
}
