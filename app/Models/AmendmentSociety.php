<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmendmentSociety extends Model
{
    protected $table = 'amendment_societies';
    protected $fillable = ['name', 'total_members','district','block', 'address', 'e18_certificate', 'total_board_members', 'quorum_members', 'amendment_ref_no', 'submitted_to_role', 'submitted_to_user_id', 'status', 'user_id', 'current_role','society_category'];

    public function managing_committee()
    {
        return $this->hasOne(ManagingCommitte::class, 'society_id', 'id');
    }

    public function aam_sabha_meeting()
    {
        return $this->hasOne(AamSabhaMeeting::class, 'society_id', 'id');
    }

    public function voting_on_amendments()
    {
        return $this->hasOne(VotingOnAmendments::class, 'society_id', 'id');
    }
    public function society_detail()
    {
        return $this->belongsTo(SocietyRegistration::class, 'name', 'id');
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
            'registrar' => 'Registrar',
        ];

        $currentRole = strtolower($this->current_role);
        $lastFlow = $this->flows()->latest()->first();
        $actedRole = strtolower(optional($lastFlow)->from_role);
        $actedRoleLabel = $roleLabels[$actedRole] ?? 'Officer';

        return match ($this->status) {
            0 => [
                'text' => 'Draft',
                'class' => 'soft-secondary text-secondary',
            ],
            1 => [
                /* 'text' => $lastFlow ? "Verified by {$actedRoleLabel}" : 'Applied',
                'class' => 'soft-primary text-primary', */
                'text' => $lastFlow
                    ? (
                        $this->submitted_to_role == 'arcs'
                        ? 'Re-submitted by Applicant'
                        : "Verified by {$actedRoleLabel}"
                    )
                    : 'Applied',
                'class' => 'soft-primary text-primary',
            ],
            2 => [
                'text' => 'Approved',
                'class' => 'soft-success text-success',
            ],
            3 => [
                'text' => "Reverted by {$actedRoleLabel}",
                'class' => 'soft-warning text-warning',
            ],
            4 => [
                'text' => "Recheck Requested by {$actedRoleLabel}",
                'class' => 'soft-info text-info',
            ],
            5 => [
                'text' => "Rejected by {$actedRoleLabel}",
                'class' => 'soft-danger text-danger',
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'soft-secondary text-secondary',
            ],
        };
    }


    public function flows()
    {
        return $this->hasMany(AmendmentApplicationFlow::class, 'amendment_id', 'id');
    }
    public function society_details()
    {
        return $this->hasOne(SocietyRegistration::class, 'id', 'name');
    }
}
