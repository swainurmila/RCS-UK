<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintApplicationFlow extends Model
{
    protected $table = 'complaint_application_flows';
    protected $fillable = [
        'complaint_id',
        'from_role',
        'from_user_id',
        'to_role',
        'to_user_id',
        'direction',
        'action',
        'remarks',
        'attachments',
        'is_action_taken',
        'acted_by',
        'signature',
        'by_authorized_Person_id',
        'forward_by_designation',
        'forward_to_designation',
        'forward_to_authorized_Person_id'
    ];
    protected $casts = [
        'attachments' => 'array',
        'is_action_taken' => 'boolean'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}