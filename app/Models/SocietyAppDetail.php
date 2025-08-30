<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SocietyAppDetail extends Model
{
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
        $submittedRole = strtolower($this->submitted_to_role);

        // Get last action from flow log
        $lastFlow = $this->flows()->latest()->first(); // assuming flows() is a hasMany

        $actedRole = strtolower(optional($lastFlow)->from_role);
        $actedRoleLabel = $roleLabels[$actedRole] ?? 'Officer';

        return match ($this->status) {
            0 => [
                'text' => 'Draft',
                'class' => 'soft-secondary text-secondary',
            ],
            // 1 => [
            //     /* 'text' => $lastFlow
            //         ? "Verified by {$actedRoleLabel}"
            //         : 'Applied',
            //     'class' => 'soft-primary text-primary', */

            //     'text' => $lastFlow
            //         ? (
            //             $this->submitted_to_role == 'arcs'
            //             ? 'Re-submitted by Applicant'
            //             : "Verified by {$actedRoleLabel}"
            //         )
            //         : 'Applied',
            //     'class' => 'soft-primary text-primary',
            // ],
            1 => [
                'text' => $lastFlow
                    ? (
                        strtolower($lastFlow->from_role) === 'applicant'
                        ? 'Re-submitted by Applicant'
                        : (
                            strtolower($lastFlow->from_role) === 'ado' && strtolower($lastFlow->to_role) === 'arcs'
                            ? 'Resent to ARCS'
                            : "Verified by {$actedRoleLabel}"
                        )
                    )
                    : 'Applied',
                'class' => 'soft-primary text-primary',
            ],

            2 => [
                'text' => 'Approved',
                'class' => 'soft-success text-success',
            ],
            // 3 => [
            //     'text' => "Reverted by {$actedRoleLabel}",
            //     'class' => 'soft-warning text-warning',
            // ],
            4 => [
                'text' => "Reverted  by {$actedRoleLabel}",
                'class' => 'soft-warning text-warning',
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

    public function getCutoffDateLabelAttribute()
    {
        if (!$this->cutoff_date) {
            return null;
        }

        $cutoff = Carbon::parse($this->cutoff_date)->startOfDay();
        $today = now()->startOfDay();
        $daysLeft = $today->diffInDays($cutoff, false);

        return $daysLeft;
    }

    public function getDaysLeftBadgeAttribute()
    {
        $daysLeft = $this->cutoffDateLabel;

        if (is_null($daysLeft)) {
            return [
                'text' => 'N/A',
                'class' => 'bg-secondary text-white',
            ];
        }

        if ($daysLeft < 0) {
            return [
                'text' => 'Expired ' . abs($daysLeft) . ' days ago',
                'class' => 'bg-danger text-white',
            ];
        }

        if ($daysLeft <= 30) {
            return [
                'text' => $daysLeft . ' days left',
                'class' => 'bg-danger text-white',
            ];
        }

        if ($daysLeft <= 50) {
            return [
                'text' => $daysLeft . ' days left',
                'class' => 'bg-warning text-dark',
            ];
        }

        if ($daysLeft <= 70) {
            return [
                'text' => $daysLeft . ' days left',
                'class' => 'bg-info text-white',
            ];
        }

        return [
            'text' => $daysLeft . ' days left',
            'class' => 'bg-primary text-white',
        ];
    }




    protected $table = 'society_app_details';
    protected $fillable = [
        'app_id',
        'app_no',
        'app_count',
        'app_phase',
        'scheme_id',
        'status',
        'user_id',
        'app_progress',
        'cutoff_date',
        'current_role',
        'division_id',
        'district_id',
        'block_id',
        'submitted_to_role',
        'submitted_to_user_id',
        'documents_verified',
        'documents_verified_by',
        'documents_verified_at'
    ];
    public function society_details()
    {
        return $this->belongsTo(SocietyRegistration::class, 'app_id', 'id');
    }
    public function scheme()
    {
        return $this->belongsTo(Scheme::class, 'scheme_id', 'id');
    }

    public function flows()
    {
        return $this->hasMany(SocietyApplicationFlow::class, 'application_id', 'id');
    }
    
}