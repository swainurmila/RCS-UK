<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmendmentApplicationFlow extends Model
{
    protected $table = 'amendment_application_flows';

    protected $fillable = [
        'amendment_id',
        'from_role',
        'from_user_id',
        'to_role',
        'to_user_id',
        'direction',
        'action',
        'remarks',
        'attachments',
        'is_action_taken',
        'acted_by'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_action_taken' => 'boolean',
    ];

    // Relationships

    public function amendment()
    {
        return $this->belongsTo(AmendmentSociety::class, 'amendment_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
