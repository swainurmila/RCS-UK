<?php

namespace App\Services;

use App\Models\SocietyAppDetail;
use App\Models\SocietyApplicationFlow;
use App\Models\SocietyApplicationStatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\SocietyRevertNotificationMail;
use App\Mail\SocietyRejectNotificationMail;

class SocietyWorkflowService
{
  protected function getHierarchy(SocietyAppDetail $app): array
  {
    // dd($app->society_details);
    // type => for apex or eny thing society type 
    $societyCategory = optional($app->society_details)->society_category;
    // dd($societyCategory);
    return config("society_workflow." . ($societyCategory === 'Apex' ? 'apex.hierarchy' : 'standard.hierarchy'));
  }

  protected function getReverseHierarchy(SocietyAppDetail $app): array
  {
    $societyCategory = optional($app->society_details)->society_category;
    return config("society_workflow." . ($societyCategory === 'Apex' ? 'apex.reverse_hierarchy' : 'standard.reverse_hierarchy'));
  }

  protected function getNextRoleForApp(SocietyAppDetail $app, string $currentRole, string $direction = 'forward'): ?string
  {
    $flowMap = $direction === 'reverse' ? $this->getReverseHierarchy($app) : $this->getHierarchy($app);
    $nextSteps = $flowMap[$currentRole] ?? null;

    if (is_array($nextSteps)) {
      // ARCS logic: if already verified, skip ADO
      if ($currentRole === 'arcs') {
        return $app->documents_verified ? 'drcs' : 'ado';
      }

      return $nextSteps[0];
    }

    return $nextSteps;
  }


  public function approve(SocietyAppDetail $app, Request $request)
  {
    DB::transaction(function () use ($app, $request) {
      $toRole = $request->to_role ?? $this->getNextRoleForApp($app, $app->current_role, 'forward');
      //  dd($app, $app->current_role, $request->to_role, $toRole);
      $userId = $this->getDefaultUserForRole($toRole, $app);

      $attachments = [];
      if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
          $path = $file->store('official_attachments', 'public');
          $attachments[] = $path;
        }
      }

      $isDocVerification = $app->current_role === 'ado' && $toRole === 'arcs';

      if ($isDocVerification) {
        $app->documents_verified = true;
        $app->documents_verified_by = auth()->id();
        $app->documents_verified_at = now();
      }

      SocietyApplicationFlow::create([
        'application_id' => $app->id,
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
      $newStatus = $toRole === null ? 2 : 1;

      $app->update([
        'current_role' => $toRole,
        'submitted_to_role' => $toRole,
        'submitted_to_user_id' => $userId,
        'status' => $newStatus,
        'documents_verified' => $app->documents_verified,
        'documents_verified_by' => $app->documents_verified_by,
        'documents_verified_at' => $app->documents_verified_at,
      ]);

      $this->logStatusChange($app, $isDocVerification ? 'doc_verified' : 'approve', $oldStatus, $newStatus, $request->remarks);
    });
  }

  public function resendToLower(SocietyAppDetail $app, Request $request)
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
      SocietyApplicationFlow::create([
        'application_id' => $app->id,
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

   public function revert(SocietyAppDetail $app, Request $request)
  {
     try {
    DB::transaction(function () use ($app, $request) {
      $toRole = $request->to_role ?? $this->getNextRoleForApp($app, $app->current_role, 'reverse');
      $userId = $this->getDefaultUserForRole($toRole, $app);
      $attachments = [];
       $documentNames = [];
      if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
          $path = $file->store('official_attachments', 'public');
          $attachments[] = $path;
           $documentNames[] = $file->getClientOriginalName();
        }
      }
        $documentName = $documentNames[0] ?? 'Document';
      SocietyApplicationFlow::create([
        'application_id' => $app->id,
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
       $society = $app->society_details;
        $user = $society?->applicantUser;

        $email = $user?->email;
        $mobile = $user?->mobile;


        if ($email) {
          Mail::to($email)->send(new SocietyRevertNotificationMail($society->society_name, $documentName, $request->remarks));
        }
    });
     } catch (\Throwable $th) {
      throw $th;
    }

  }

  public function reject(SocietyAppDetail $app, Request $request)
  {
    DB::transaction(function () use ($app, $request) {
      $attachments = [];
      if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
          $path = $file->store('official_attachments', 'public');
          $attachments[] = $path;
        }
      }

      SocietyApplicationFlow::create([
        'application_id' => $app->id,
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
      $newStatus = 5;

      $app->update([
        'status' => $newStatus,
        'current_role' => null,
        'submitted_to_user_id' => null,
      ]);

      $this->logStatusChange($app, 'reject', $oldStatus, $newStatus, $request->remarks);

          $society = $app->society_details;
        $user = $society?->applicantUser;

        $email = $user?->email;
        $mobile = $user?->mobile;

      if ($email) {
        Mail::to($email)->send(new SocietyRejectNotificationMail($society->society_name, $request->remarks));
      }

 
    });
  }

  protected function logStatusChange(SocietyAppDetail $app, string $actionType, string $oldStatus, string $newStatus, ?string $remarks = null)
  {
    SocietyApplicationStatusLog::create([
      'application_id' => $app->id,
      'action_type' => $actionType,
      'old_value' => $oldStatus,
      'new_value' => $newStatus,
      'performed_by_role' => $app->current_role,
      'performed_by_user' => auth()->id(),
      'remarks' => $remarks,
    ]);
  }

  protected function getDefaultUserForRole(?string $role, SocietyAppDetail $app): ?int
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
