<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    protected $fillable = [
        'society_name',
        'society_category', // 1=Primary, 2=Central, 3=Apex
        'district_id',
        'block_id',
        'registration_number',
        'total_members',
        'user_id',
        'status', 'new_election_date', 'election_status',
        'administrator_name', 'administrator_designation', 'administrator_area',
        'administrator_join_date', 'administrator_days_of_working', 'election_completion_certificate', 'election_completed'
    ];

    public function documents()
    {
        return $this->hasOne(NominationDocument::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getSocietyCategoryLabelAttribute()
    {
        return match ($this->society_category) {
            1 => 'Primary',
            2 => 'Central',
            3 => 'Apex',
            default => 'Unknown',
        };
    }
   public function getLastElectionDateAttribute()
    {
        return $this->documents?->last_election_date ?? null;
    }
    public function getProposalDateAttribute()
    {
        return $this->created_at?->format('d-m-Y');
    }
    public function getNextElectionDateCalcAttribute()
    {
        if ($this->documents?->is_new_society) {
            return Carbon::parse($this->documents->formation_date)->addDays(90)->format('Y-m-d');
        }
        if ($this->documents?->last_election_date) {
            return Carbon::parse($this->documents->last_election_date)->addYears(5)->format('Y-m-d');
        }
        return null;
    }
    public function getDaysLeftAttribute()
    {
        $date = $this->new_election_date ?? $this->next_election_date_calc;
        if ($date) {
            return Carbon::now()->diffInDays(Carbon::parse($date), false);
        }
        return null;
    }
    public function getIsAdminAssignedAttribute()
    {
        return $this->administrator_name !== null;
    }
public function getStatusLabel()
{
    $statusMap = [
        0 => [
            'text' => 'Proposal Pending',
            'class' => 'bg-secondary'
        ],
        1 => [
            'text' => 'Proposal In Progress',
            'class' => 'bg-primary'
        ],
        2 => [
            'text' => 'Proposal Accepted',
            'class' => 'bg-info'
        ],
        3 => [
            'text' => 'New Election Date Assigned',
            'class' => 'bg-warning text-dark'
        ],
        4 => [
            'text' => 'Election in Progress',
            'class' => 'bg-purple'
        ],
        5 => [
            'text' => 'Election Completed',
            'class' => 'bg-success'
        ],
    ];
    
    return $statusMap[$this->status] ?? [
        'text' => 'Unknown',
        'class' => 'bg-secondary'
    ];
}
    public function getAdminDaysOfWorkingAttribute()
    {
        if ($this->administrator_join_date && !$this->election_completed) {
            return Carbon::parse($this->administrator_join_date)->diffInDays(now());
        }
        return $this->administrator_days_of_working;
    }
}
