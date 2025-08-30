<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';
    protected $primaryKey = 'id';

    protected $fillable = [
        'complaint_name',
        'complaint_title',
        'contact_number',
        'email',
        'complaint_type',
        'priority',
        'attachment',
        'division',
        'district',
        'sub_division',
        'block',
        'society',
        'description',
        'status',
        'com_no',
        'user_id',
        'submitted_to_role',
        'submitted_to_user_id',
        'current_role',
        'complaint_by',
        'aadhar_upload',
        'is_member_add',
        'forward_complaint_to'
    ];

    public function complaint_type_details()
    {
        return $this->belongsTo(Complaint_type::class, 'complaint_type', 'id');
    }

    public function division_details()
    {
        return $this->belongsTo(Divisions::class, 'division', 'id');
    }

    public function district_details()
    {
        return $this->belongsTo(District::class, 'district', 'id');
    }
    public function sub_division_details()
    {
        return $this->belongsTo(Sub_divisions::class, 'district', 'id');
    }
    public function block_details()
    {
        return $this->belongsTo(Block::class, 'block', 'id');
    }
    public function society_details()
    {
        return $this->belongsTo(SocietyRegistration::class, 'society', 'id');
    }

    public function complaint_by_society()
    {
        return $this->belongsTo(SocietyRegistration::class, 'complaint_by_society_id', 'id');
    }

    public function flows()
    {
        return $this->hasMany(ComplaintApplicationFlow::class, 'complaint_id', 'id');
    }

    /* public function getUserBlock()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    } */

    public function getCommittee()
    {
        return $this->hasMany(AssignCommittee::class, 'complaint_id', 'id');
    }


    public const STATUS_UNDER_PROCESS = 1; //pending after apply
    public const STATUS_APPROVED = 2; //approved
    public const STATUS_REVERTED = 3; //return to applicant
    public const STATUS_RECHECK = 4; // re checking 
    public const STATUS_REJECTED = 5; //reject
    public const STATUS_DRAFT = 0;

    public function getStatusLabelAttribute()
    {
        $roleLabels = [
            'arcs' => 'ARCS',
            'ado' => 'ADO',
            'drcs' => 'DRCS',
            'jrcs' => 'JRCS',
            'registrar' => 'RCS',
            'additionalrcs' => 'Additional RCS'
        ];

        $currentRole = strtolower($this->current_role);
        $submittedRole = strtolower($this->submitted_to_role);

        // Get last action from flow log
        $lastFlow = $this->flows()->latest()->first(); // assuming flows() is a hasMany

        $actedRole = strtolower(optional($lastFlow)->from_role);
        $actedRoleLabel = $roleLabels[$actedRole] ?? 'Officer';

        $actedRole1 = strtolower(optional($lastFlow)->to_role);
        $actedRoleLabel1 = $roleLabels[$actedRole1] ?? 'Officer';

        return match ($this->status) {
            0 => [
                'text' => 'Draft',
                'class' => 'soft-secondary text-secondary',
            ],
            1 => [
                /*  'text' => $lastFlow
                    ? "Verified by {$actedRoleLabel}"
                    : 'Applied',
                'class' => 'soft-primary text-primary', */
                'text' => $lastFlow
                    ?
                    "Verified by {$actedRoleLabel}"
                    : 'Applied',
                'class' => 'soft-primary text-primary',
                /* 'text' => $lastFlow
                    ? (
                        $this->submitted_to_role == 'arcs'
                        ? 'Re-submitted by Applicant'
                        : "Verified by {$actedRoleLabel}"
                    )
                    : 'Applied',
                'class' => 'soft-primary text-primary', */
            ],
            2 => [
                'text' => 'Resolved',
                'class' => 'soft-success text-success',
            ],
            3 => [
                'text' => "{$actedRoleLabel} Assign Committee Member",
                'class' => 'soft-warning text-warning',
            ],
            4 => [
                'text' => "Committee Member Forward to {$actedRoleLabel1}",
                'class' => 'soft-info text-info',
            ],
            5 => [
                'text' => "Forward to {$actedRoleLabel1}",
                'class' => 'soft-info text-info',
            ],
            6 => [
                'text' => "Forward to {$actedRoleLabel1}",
                'class' => 'soft-info text-info',
            ],
            7 => [
                'text' => "Forward to {$actedRoleLabel1}",
                'class' => 'soft-info text-info',
            ],
            8 => [
                'text' => "Forward to {$actedRoleLabel1}",
                'class' => 'soft-info text-info',
            ],
            9 => [
                'text' => "Forward to {$actedRoleLabel1}",
                'class' => 'soft-info text-info',
            ],


            10 => [
                'text' => "Rejected by {$actedRoleLabel}",
                'class' => 'soft-danger text-danger',
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'soft-secondary text-secondary',
            ],
        };
    }
}