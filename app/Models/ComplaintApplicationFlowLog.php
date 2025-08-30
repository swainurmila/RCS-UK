<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintApplicationFlowLog extends Model
{
    protected $table = 'complaint_application_flow_logs';
    protected $fillable = [
        'complaint_id',
        'action_type',
        'old_value',
        'new_value',
        'performed_by_role',
        'performed_by_user',
        'remarks',
        'by_authorized_Person_id',
        'forward_by_designation',
        'forward_to_designation',
        'forward_to_authorized_Person_id'
    ];
}