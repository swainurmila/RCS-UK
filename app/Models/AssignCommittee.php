<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignCommittee extends Model
{
    protected $table = 'assign_committees';

    protected $fillable = [
        'complaint_id',
        'designation',
        'member_id',
        'district_id',
        'block_id',
        'user_id',
        'current_role',
        'status',
    ];

    public function getCommitteeMember()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id', 'id');
    }

    public function getUserMember()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}