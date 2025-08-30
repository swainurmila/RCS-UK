<?php

namespace App\Services;

use App\Models\AssignCommittee;
use App\Models\Complaint;
use App\Models\ComplaintApplicationFlow;
use App\Models\ComplaintApplicationFlowLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;


class ComplaintWorkFlowService
{

    protected function getHierarchy(Complaint $app): array
    {
        $submittedToRole = optional($app)->submitted_to_role;

        // Define your forwarding hierarchy in config/complaint_workflow.php
        // dd(config('complaint_workflow.hierarchy')['drcs'] ?? 'not found');
        $hierarchy = config('complaint_workflow.hierarchy', []);

        // Return an array of forwardable roles based on the submitted_to_role
        return $hierarchy[$submittedToRole] ?? [];
    }

    /* protected function getHierarchy(Complaint $app): array
    {
        $complaintRole = optional($app->submitted_to_role);
        return config("complaint_workflow." . ($complaintRole === 3 ? 'apex.hierarchy'));
    } */

    /*  protected function getReverseHierarchy(Complaint $app): array
    {
        $societyCategory = optional($app->society_details)->society_category;
        return config("complaint_workflow." . ($societyCategory === 3 ? 'apex.reverse_hierarchy' : 'standard.reverse_hierarchy'));
    } */

    /* protected function getNextRoleForApp(Complaint $app, string $currentRole, string $direction = 'forward'): ?string
    {
        $flowMap = $direction === 'reverse' ? $this->getReverseHierarchy($app) : $this->getHierarchy($app);
        return $flowMap[$currentRole] ?? null;
    } */

    /* protected function getNextRoleForApp(Complaint $app, string $currentRole, string $direction = 'forward'): ?string
    {
        $flowMap = $this->getHierarchy($app);
        return $flowMap[$currentRole][0] ?? null;
    } */

    protected function getNextRoleForApp(Complaint $app, string $currentRole, string $direction = 'forward'): ?string
    {
        $flowMap = config('complaint_workflow.hierarchy');
        // Log/Debug check (optional)
        logger()->info('FlowMap Check', [
            'currentRole' => $currentRole,
            'flowMap' => $flowMap,
            'mappedRoles' => $flowMap[$currentRole] ?? null
        ]);
        // Return the first forwardable role for the current role
        return $flowMap[$currentRole][0] ?? null;
    }

    protected function getNextRoleForAppComm(AssignCommittee $commapp, string $currentRole, string $direction = 'forward'): ?string
    {
        $flowMap = config('complaint_workflow.hierarchy');
        // Log/Debug check (optional)
        logger()->info('FlowMap Check', [
            'currentRole' => $currentRole,
            'flowMap' => $flowMap,
            'mappedRoles' => $flowMap[$currentRole] ?? null
        ]);
        // Return the first forwardable role for the current role
        return $flowMap[$currentRole][0] ?? null;
    }

    public function approve(Complaint $app, Request $request)
    {
        // dd($app);
        try {
            DB::transaction(function () use ($app, $request) {
                // dd($request->all());

                $toRole = $request->to_role ?? $this->getNextRoleForApp($app, $app->current_role, 'forward');
                // dd($toRole, $app->current_role, $request->to_role, strtolower($toRole));
                // dd($app, $app->current_role, $request->to_role, $toRole, $request);

                if ($toRole === 'arcs') {
                    $userId = $this->getDefaultUserForRoleARCS($toRole, $app);
                } else {
                    $userId = $this->getDefaultUserForRole($toRole, $app);
                }

                // dd($userId);
                // dd($request);
                $attachments = [];
                if ($request->hasFile('files')) {
                    foreach ($request->file('files') as $file) {
                        $path = $file->store('official_attachments', 'public');
                        $attachments[] = $path;
                    }
                }
                // dd($attachments);
                ComplaintApplicationFlow::create([
                    'complaint_id' => $app->id,
                    'from_role' => $app->current_role,
                    'from_user_id' => auth()->id(),
                    'to_role' => $toRole,
                    'to_user_id' => $userId,
                    'direction' => 'forward',
                    'action' =>  $toRole === null ? 'approve' : 'verification',
                    'remarks' => $request->remarks,
                    'attachments' => json_encode($attachments),
                    'is_action_taken' => true,
                    'acted_by' => auth()->id(),
                ]);

                if ($app->current_role === 'arcs') {
                    AssignCommittee::where('complaint_id', $app->id)
                        ->update([
                            'current_role' => strtolower($toRole),
                            'status' => 2
                        ]);
                }

                $oldStatus = 0; //Moved from applied  to In Review process
                $newStatus = $toRole === null ? '2' : '1'; //1=> Still under Review 2=>Final Approved

                $app->update([
                    'current_role' => $toRole,
                    'submitted_to_role' => $toRole,
                    'submitted_to_user_id' => $userId,
                    'status' => $toRole === null ? '2' : '1', // 2 = final
                ]);
                // $this->logStatusChange($app, 'approve', $oldStatus, $newStatus, $request->remarks);
                $this->logStatusChange($app, null, 'approve', $oldStatus, $newStatus, $request->remarks);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function committeeforward(AssignCommittee $commapp, Request $request)
    {
        // dd($commapp->complaint_id);
        try {
            DB::transaction(function () use ($commapp, $request) {
                // dd($request->all());
                $complaint = $commapp->getCommitteeMember;
                // dd($complaint->current_role);

                $toRole = $request->to_role ?? $this->getNextRoleForAppComm($commapp, $commapp->current_role, 'forward');

                // dd($toRole, $complaint->current_role, $request->to_role);
                // dd($app, $app->current_role, $request->to_role, $toRole, $request);
                $userId = $this->getDefaultUserForRoleCommittee($toRole, $commapp);
                // dd($userId);
                // dd($toRole);
                $attachments = [];
                if ($request->hasFile('commfiles')) {
                    foreach ($request->file('commfiles') as $file) {
                        $path = $file->store('official_attachments', 'public');
                        $attachments[] = $path;
                    }
                }
                // dd($attachments);
                ComplaintApplicationFlow::create([
                    'complaint_id' => $commapp->complaint_id,
                    // 'from_role' => 'Committee Member',
                    'from_role' => $commapp->current_role,
                    'from_user_id' => auth()->id(),
                    'to_role' => strtolower($toRole),
                    'to_user_id' => $userId,
                    'direction' => 'forward',
                    'action' =>  $toRole === null ? 'approve' : 'verification',
                    'remarks' => $request->commremarks,
                    'attachments' => json_encode($attachments),
                    'is_action_taken' => true,
                    'acted_by' => auth()->id(),
                ]);

                $oldStatus = 0; //Moved from applied  to In Review process
                $newStatus = 4;
                // $newStatus = $toRole === null ? '2' : '1'; //1=> Still under Review 2=>Final Approved

                AssignCommittee::where('complaint_id', $commapp->complaint_id)
                    ->update([
                        'current_role' => strtolower($toRole),
                        'status' => 2
                    ]);

                $com = Complaint::findOrFail($commapp->complaint_id);
                $com->update([
                    'current_role' => $toRole,
                    'submitted_to_role' => $toRole,
                    'submitted_to_user_id' => $userId,
                    'status' => 4
                ]);
                // $this->logStatusChange($commapp, 'committeeforward', $oldStatus, $newStatus, $request->commremarks);.
                $this->logStatusChange($com, $commapp, 'committeeforward', $oldStatus, $newStatus, $request->commremarks);
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function resendToLower(Complaint $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            $toRole = $request->to_role ?? $this->getNextRoleForApp($app, $app->current_role, 'reverse');
            $userId = $this->getDefaultUserForRole($toRole, $app);
            $attachments = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('official_attachments', 'public');
                    $attachments[] = $path;
                }
            }
            ComplaintApplicationFlow::create([
                'complaint_id' => $app->id,
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
            $newStatus = 4; //Sent back to previous verifier for rechack 

            $app->update([
                'current_role' => $toRole,
                'submitted_to_role' => $toRole,
                'submitted_to_user_id' => $userId,
                'status' => '4', // status for recheck
            ]);
            $this->logStatusChange($app, 'approve', $oldStatus, $newStatus, $request->remarks);
        });
    }

    public function revert(Complaint $app, Request $request)
    {
        try {
            DB::transaction(function () use ($app, $request) {
                // Log the flow of the revert action
                $attachments = [];
                if ($request->hasFile('files')) {
                    foreach ($request->file('files') as $file) {
                        $path = $file->store('official_attachments', 'public');
                        $attachments[] = $path;
                    }
                }
                ComplaintApplicationFlow::create([
                    'complaint_id' => $app->id,
                    'from_role' => $app->current_role,
                    'from_user_id' => auth()->id(),
                    'to_role' => 'society', // Sending back to the applicant
                    'to_user_id' => null,
                    'direction' => 'reverse', // Indicating reverse flow
                    'action' => 'revert',
                    'remarks' => $request->remarks,
                    'attachments' => json_encode($attachments),
                    'is_action_taken' => true,
                    'acted_by' => auth()->id(),
                ]);
                $oldStatus = $app->status;
                $newStatus = 3; //Sent back for correction (to applicant)
                // Update the application status to reverted and reset user assignment
                $app->update([
                    'current_role' => null,
                    'submitted_to_user_id' => null,
                    'status' => 3,
                ]);
                $this->logStatusChange($app, 'revert', $oldStatus, $newStatus, $request->remarks);
            });
        } catch (\Throwable $th) {
            dd($th);
            throw $th;
        }
    }

    public function reject(Complaint $app, Request $request)
    {
        // dd($request->all());
        DB::transaction(function () use ($app, $request) {
            $attachments = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('official_attachments', 'public');
                    $attachments[] = $path;
                }
            }
            // dd($attachments);
            // Log the flow of the rejection action
            ComplaintApplicationFlow::create([
                'complaint_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => "society",
                'to_user_id' =>  $app->user_id,
                'direction' => 'reverse', // Indicating reverse flow
                'action' => 'reject',
                'remarks' => $request->remarks,
                'attachments' => json_encode($attachments),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            $oldStatus = $app->status;
            $newStatus = 5; //Application rejected (final)
            // Update the application's status to rejected
            $app->update([
                'status' => 5,
                'current_role' => null,
                'submitted_to_user_id' => null,
            ]);
            $this->logStatusChange($app, 'reject', $oldStatus, $newStatus, $request->remarks);
        });
    }

    protected function logStatusChange(Complaint $app, ?AssignCommittee $commapp = null, string $actionType, string $oldStatus, string $newStatus, ?string $remarks = null)
    {
        if ($commapp && in_array($commapp->designation, ['ado', 'adco'])) {
            ComplaintApplicationFlowLog::create([
                'complaint_id' => $commapp->complaint_id,
                'action_type' => $actionType,
                'old_value' => $oldStatus,
                'new_value' => $newStatus,
                'performed_by_role' => strtolower($commapp->current_role),
                'performed_by_user' => auth()->id(),
                'remarks' => $remarks,
            ]);
        } else {
            ComplaintApplicationFlowLog::create([
                'complaint_id' => $app->id,
                'action_type' => $actionType,
                'old_value' => $oldStatus,
                'new_value' => $newStatus,
                'performed_by_role' => $app->current_role,
                'performed_by_user' => auth()->id(),
                'remarks' => $remarks,
            ]);
        }
    }

    /*  protected function getDefaultUserForRole(?string $role, Complaint $app): ?int
    {
        // dd($role);
        if (!$role) return null;

        return User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        })
            ->when($app->district_id, fn($q) => $q->where('district_id', $app->district_id))
            ->when(($app->getUserBlock)->block_id, fn($q) => $q->where('block_id', ($app->getUserBlock)->block_id))
            ->value('id'); // or first()->id if you want the User model
    } */


    protected function getDefaultUserForRole(?string $role, Complaint $app): ?int
    {
        if (!$role) return null;

        //  $districtId = $app->district;
        // $blockId = optional($app->getUserBlock)->block_id;
        logger()->info('Finding user for role', [
            'role' => $role,
            // 'district_id' => $districtId,
            // 'block_id' => $blockId
        ]);

        $user = User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        })
            // ->when($districtId, fn($q) => $q->where('district_id', $districtId))
            // ->when($blockId, fn($q) => $q->where('block_id', $blockId))
            ->first();
        // return $user;
        logger()->info('User found', ['user' => $user]);

        return $user?->id;
    }

    protected function getDefaultUserForRoleARCS(?string $role, Complaint $app): ?int
    {
        // dd($role);

        if (!$role) return null;
        $roleId = Role::where('name', $role)->pluck('id');
        // dd($roleId);
        $districtId = $app->district;
        // return $blockId = optional($app->getUserBlock)->block_id;
        logger()->info('Finding user for role', [
            'role' => $role,
            'district_id' => $districtId,
            // 'block_id' => $blockId
        ]);
        $user = User::where('role_id', $roleId)->where('district_id', $districtId)->first();

        /* $user = User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        })
            ->when($districtId, fn($q) => $q->where('district_id', $districtId))
            // ->when($blockId, fn($q) => $q->where('block_id', $blockId))
            ->first(); */
        // dd($user);
        logger()->info('User found', ['user' => $user]);

        return $user?->id;
    }

    protected function getDefaultUserForRoleCommittee(?string $role, AssignCommittee $commapp): ?int
    {

        if (!$role) return null;
        // dd($role);
        // $districtId = $commapp->district_id;
        // $blockId = $commapp->block_id;

        logger()->info('Finding user for role', [
            'role' => $role,
            /* 'district_id' => $districtId,
            'block_id' => $blockId */
        ]);

        $user = User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        })
            // ->when($districtId, fn($q) => $q->where('district_id', $districtId))
            // ->when($blockId, fn($q) => $q->where('block_id', $blockId))
            ->first();
        logger()->info('User found', ['user' => $user]);

        return $user?->id;
    }
}