<?php

namespace App\Services;

use App\Mail\AmendmentRejectNotificationMail;
use App\Mail\AmendmentRevertNotificationMail;
use App\Models\AmendmentSociety;
use App\Models\AmendmentApplicationFlow;
use App\Models\AmendmentApplicationStatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AmendmentWorkflowService
{
    protected function getHierarchy(AmendmentSociety $app): array
    {
        $societyCategory = optional($app->society_details)->society_category;
        return config("amendment_workflow." . ($societyCategory === 'Apex' ? 'apex.hierarchy' : 'standard.hierarchy'));
    }

    protected function getReverseHierarchy(AmendmentSociety $app): array
    {
        $societyCategory = optional($app->society_details)->society_category;
        return config("amendment_workflow." . ($societyCategory === 'Apex' ? 'apex.reverse_hierarchy' : 'standard.reverse_hierarchy'));
    }

    protected function getNextRoleForApp(AmendmentSociety $app, string $currentRole, string $direction = 'forward'): ?string
    {
        // if (!$currentRole) {
        //     return null;
        // }

        $flowMap = $direction === 'reverse' ? $this->getReverseHierarchy($app) : $this->getHierarchy($app);
        return $flowMap[strtolower($currentRole)] ?? null;
    }


    public function approve(AmendmentSociety $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            $toRole = $request->to_role ?? $this->getNextRoleForApp($app, $app->current_role, 'forward');

            $userId = $this->getDefaultUserForRole($toRole, $app);
            $attachments = $this->uploadFiles($request);

            AmendmentApplicationFlow::create([
                'amendment_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => $toRole,
                'to_user_id' => $userId,
                'direction' => 'forward',
                'action' => $toRole === null ? 'approve' : 'verification',
                'remarks' => $request->remarks,
                'attachments' => json_encode($attachments),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            $oldStatus = $app->status;
            $newStatus = $toRole === null ? 2 : 1; // 2: final approved, 1: under review

            $app->update([
                'current_role' => $toRole,
                'submitted_to_role' => $toRole,
                'submitted_to_user_id' => $userId,
                'status' => $newStatus,
            ]);

            $this->logStatusChange($app, 'approve', $oldStatus, $newStatus, $request->remarks);
        });
    }

    public function resendToLower(AmendmentSociety $app, Request $request)
    {
        // return 1;
        DB::transaction(function () use ($app, $request) {
            $toRole = $request->to_role ?? $this->getNextRoleForApp($app, $app->current_role, 'reverse');
            $userId = $this->getDefaultUserForRole($toRole, $app);
            $attachments = $this->uploadFiles($request);

            AmendmentApplicationFlow::create([
                'amendment_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => $toRole,
                'to_user_id' => $userId,
                'direction' => 'reverse',
                'action' => 'recheck',
                'remarks' => $request->remarks,
                'attachments' => json_encode($attachments),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            $oldStatus = $app->status;
            $newStatus = 4; // Sent back to lower role for recheck

            $app->update([
                'current_role' => $toRole,
                'submitted_to_role' => $toRole,
                'submitted_to_user_id' => $userId,
                'status' => $newStatus,
            ]);

            $this->logStatusChange($app, 'resend', $oldStatus, $newStatus, $request->remarks);
        });
    }

    public function revert(AmendmentSociety $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            $attachments = $this->uploadFiles($request);

            AmendmentApplicationFlow::create([
                'amendment_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => 'society',
                'to_user_id' => null,
                'direction' => 'reverse',
                'action' => 'revert',
                'remarks' => $request->remarks,
                'attachments' => json_encode($attachments),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            $oldStatus = $app->status;
            $newStatus = 3; // Sent back to applicant for correction

            $app->update([
                'current_role' => null,
                'submitted_to_user_id' => null,
                'status' => $newStatus,
            ]);

            $this->logStatusChange($app, 'revert', $oldStatus, $newStatus, $request->remarks);
            $society = $app->society_details;
            $user = $society?->applicantUser;

            $email = $user?->email;
            $mobile = $user?->mobile;

            if ($email) {
                Mail::to($email)->send(new AmendmentRevertNotificationMail($society->society_name, $request->remarks));
            }

            // if ($mobile) {
            //     $this->sendSMS($mobile, "Your amendment has been reverted. Remarks: {$request->remarks}");
            // }
        });
    }

    public function reject(AmendmentSociety $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            $attachments = $this->uploadFiles($request);

            AmendmentApplicationFlow::create([
                'amendment_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => 'society',
                'to_user_id' => $app->user_id,
                'direction' => 'reverse',
                'action' => 'reject',
                'remarks' => $request->remarks,
                'attachments' => json_encode($attachments),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            $oldStatus = $app->status;
            $newStatus = 5; // Final Rejected

            $app->update([
                'status' => $newStatus,
                // 'current_role' => 'society',
                'current_role' => null,
                'submitted_to_user_id' => null,
            ]);


            $this->logStatusChange($app, 'reject', $oldStatus, $newStatus, $request->remarks);
            // After $this->logStatusChange(...)
            $society = $app->society_details;
            $user = $society?->applicantUser;

            $email = $user?->email;
            $mobile = $user?->mobile;

            if ($email) {
                Mail::to($email)->send(new AmendmentRejectNotificationMail($society->society_name, $request->remarks));
            }

            // if ($mobile) {
            //     $this->sendSMS($mobile, "Your amendment has been rejected. Remarks: {$request->remarks}");
            // }
        });
    }

    protected function uploadFiles(Request $request): array
    {
        $attachments = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('amendment_attachments', 'public');
                $attachments[] = $path;
            }
        }
        return $attachments;
    }

    protected function logStatusChange(AmendmentSociety $app, string $actionType, string $oldStatus, string $newStatus, ?string $remarks = null)
    {
        AmendmentApplicationStatusLog::create([
            'amendment_id' => $app->id,
            'action_type' => $actionType,
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'performed_by_role' => $app->current_role,
            'performed_by_user' => auth()->id(),
            'remarks' => $remarks,
        ]);
    }

    protected function getDefaultUserForRole(?string $role, AmendmentSociety $app): ?int
    {
        if (!$role) return null;
        return User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        })
            ->when($app->district_id, fn($q) => $q->where('district_id', $app->district_id))
            ->when($app->block_id, fn($q) => $q->where('block_id', $app->block_id))
            ->value('id');
    }
}
