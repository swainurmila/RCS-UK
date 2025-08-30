<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingOnAmendments extends Model
{
    protected $table='amendment_voting_on_amendments';
    protected $fillable=['society_id',
        'quorum_completed',
        'total_members',
        'members_present',
        'votes_favor',
        'votes_against',
        'total_voted',
        'abstain_members',
        'resolution_amendment',
        'resolution_file',];
}
