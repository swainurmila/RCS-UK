<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietyApplicationStatusLog extends Model
{
    protected $table = 'society_application_status_logs';
    protected $fillable = [
        'application_id',
        'action_type',
        'old_value',
        'new_value',
        'performed_by_role',
        'performed_by_user',
        'remarks',
    ];

    // Define relationships to other models
    public function application()
    {
        return $this->belongsTo(SocietyAppDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by_user');
    }
}
