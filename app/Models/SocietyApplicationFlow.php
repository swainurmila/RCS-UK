<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietyApplicationFlow extends Model
{
    protected $table = 'society_application_flows';
    protected $fillable = [
        'application_id',
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
        'is_action_taken' => 'boolean'
    ];

    public function application()
    {
        return $this->belongsTo(SocietyAppDetail::class, 'application_id');
    }

    public function actor() //who can take action
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
