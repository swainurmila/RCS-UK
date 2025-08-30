<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionTarget extends Model
{
    public function getStatusLabelAttribute()
    {
        $roleLabels = [
            'arcs' => 'ARCS',
            'ado' => 'ADO',
            'drcs' => 'DRCS',
            'jrcs' => 'JRCS',
            'registrar' => 'Registrar',
            'rcs' => 'RCS',
            'adco' => 'ADCO',
            'supervisor' => 'Supervisor',
            'applicant' => 'Applicant',
        ];

        $pendingAtLabels = [
            1 => 'Pending at DRCS',
            2 => 'Pending at ARCS',
            3 => 'Pending at ADCO',
            4 => 'Pending at ADO',
            5 => 'Pending at Supervisor',
        ];

        // Get latest flow action (if any)
        $lastFlow = $this->flows()->latest()->first();
        $actedRole = strtolower(optional($lastFlow)->from_role);
        $actedRoleLabel = $roleLabels[$actedRole] ?? 'Officer';

        return match (intval($this->status)) {
            0 => [
                'text' => 'Draft',
                'class' => 'bg-secondary text-white',
            ],
            1, 2, 3, 4, 5 => [
                'text' => $pendingAtLabels[$this->status] ?? 'Pending',
                'class' => 'bg-primary text-white',
            ],
            6 => [ // Reverted
                'text' => "Reverted by {$actedRoleLabel}",
                'class' => 'bg-warning text-dark',
            ],
            7 => [ // Rejected
                'text' => "Rejected by {$actedRoleLabel}",
                'class' => 'bg-danger text-white',
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-secondary text-white',
            ],
        };

    }


    public function districtName()
    {
        return $this->hasOne(District::class, 'id', 'dist_id');
    }

    public function designation()
    {
        return $this->hasOne(Role::class, 'id', 'designation_id');
    }

    public function AssignedOfficer()
    {
        return $this->hasOne(User::class, 'id', 'assigned_officer_id');
    }

    public function CreatedBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    public function flows()
    {
        return $this->hasMany(InspectionTargetFlow::class, 'inspection_target_id');
    }

}