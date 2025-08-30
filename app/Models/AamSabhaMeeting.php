<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AamSabhaMeeting extends Model
{
    protected $table='amendment_aam_sabha_meetings';
    protected $fillable=[ 'society_id','noticeOfAamSabha','communication_method','other_communication','ag_meeting_date','meeting_notice',];
}
