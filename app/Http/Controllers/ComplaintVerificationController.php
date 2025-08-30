<?php

namespace App\Http\Controllers;

use App\Models\AssignCommittee;
use App\Models\Complaint;
use App\Models\ComplaintApplicationFlow;
use App\Models\ComplaintApplicationFlowLog;
use App\Models\User;
use App\Services\ComplaintWorkFlowService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ComplaintVerificationController extends Controller
{

    protected $flowService;

    public function __construct(ComplaintWorkFlowService $flowService)
    {
        $this->flowService = $flowService;
    }

    public function compTakeAction(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'complaint_id' => 'required|exists:complaints,id',
            // 'action' => 'required|in:approve,reject,revert,resend_for_recheck',
            'action' => 'required|in:resolve,forward,',
            'remarks' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:10240', // Max 10MB files
        ]);
        $app = Complaint::findOrFail($request->complaint_id);
        // dd($app);

        try {
            match ($request->action) {
                'forward' => $this->flowService->approve($app, $request),
                'resolve' => $this->flowService->reject($app, $request),

                /* 'approve' => $this->flowService->approve($app, $request),
                'reject' => $this->flowService->reject($app, $request),
                'revert' => $this->flowService->revert($app, $request),
                'resend_for_recheck' => $this->flowService->resendToLower($app, $request), */
            };

            $message = match ($request->action) {
                'resolve' => 'Application resolved successfully.',
                'forward' => 'Application forwarded to next level.',
                'committeeforward' => 'Application forwarded to next level.',

                /* 'approve' => 'Application approved successfully.',
                'reject' => 'Application rejected.',
                'revert' => 'Application reverted to previous level.',
                'resend_for_recheck' => 'Application sent back for recheck.', */
            };

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            return $e;
            return redirect()->back()->with('error', 'Something went wrong while processing the action.');
        }
    }

    public function commTakeAction(Request $request)
    {

        // return $request;
        $validated = $request->validate([
            'id' => 'required|exists:assign_committees,id',
            'commaction' => 'required|in:committeeforward',
            'commremarks' => 'required|string',
            'commfiles.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:10240', // Max 10MB files
        ]);
        $commapp = AssignCommittee::findOrFail($request->id);
        // dd($commapp);

        try {
            match ($request->commaction) {
                'committeeforward' => $this->flowService->committeeforward($commapp, $request),
            };

            $message = match ($request->commaction) {
                'committeeforward' => 'Application forwarded to next level.',
            };

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            return $e;
            return redirect()->back()->with('error', 'Something went wrong while processing the action.');
        }
    }


    public function history(Complaint $complaint)
    {
        $history = $complaint->flows()->with(['fromUser', 'toUser'])->get();
        // $app = $complaint->load('society_details:id,society_name,applied_on', 'complaint_by_society:id,society_name');
        return view('complaint.history', compact('history', 'complaint'));
    }

    public function finalResolution(Request $request)
    {
        // return $request->com_id;
        $request->validate([
            'resremarks' => 'required|string|min:3',
            'resfiles.*' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'authorized_person_id' => 'required|exists:users,id',
            'signature' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'com_id' => 'required',
            'res_current_role' => 'required'
        ]);

        try {
            $attachments = [];
            if ($request->hasFile('resfiles')) {
                foreach ($request->file('resfiles') as $file) {
                    $path = $file->store('resolutions_official_attachments', 'public');
                    $attachments[] = $path;
                }
            }

            $signaturePath = null;
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')->store('resolutions/signatures', 'public');
            }

            $resolution = new ComplaintApplicationFlow();
            $resolution->complaint_id = $request->com_id;
            $resolution->from_role = strtolower($request->res_current_role);
            $resolution->from_user_id = auth()->id();
            $resolution->action = 'approve';
            $resolution->is_action_taken = true;
            $resolution->acted_by = auth()->id();
            $resolution->by_authorized_Person_id = $request->authorized_person_id;
            $resolution->remarks = $request->resremarks;
            $resolution->signature = $signaturePath;
            $resolution->attachments = json_encode($attachments);
            // return  $resolution;
            $resolution->save();

            $resolution_log = new ComplaintApplicationFlowLog();
            $resolution_log->complaint_id = $request->com_id;
            $resolution_log->action_type = 'approve';
            $resolution_log->old_value = 0;
            $resolution_log->new_value = 2;
            $resolution_log->performed_by_role = strtolower($request->res_current_role);
            $resolution_log->performed_by_user = auth()->id();
            $resolution_log->remarks =  $request->resremarks;
            $resolution_log->by_authorized_Person_id = $request->authorized_person_id;
            $resolution_log->save();

            $com = Complaint::findOrFail($request->com_id);
            $com->update([
                'current_role' => strtolower($request->res_current_role),
                'submitted_to_user_id' => auth()->id(),
                'status' => 2
            ]);

            return back()->with('success', 'Resolve successfully.');
        } catch (\Exception $e) {
            \Log::error('Resolution submission error: ' . $e->getMessage());

            return back()->with('error', 'An error occurred while submitting the resolution. Please try again.');
        }
    }





    public function forwardcomplaintapp(Request $request)
    {
        // return $request;
        $request->validate([
            'fwdremarks' => 'required|string|min:3',
            'fwdfiles.*' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'forward_to_designation' => 'required',
            'forward_to_authorized_Person_id' => 'required',
            'forward_by_designation' => 'required',
            'by_authorized_Person_id' => 'required',
            'com_id' => 'required',
            'res_current_role' => 'required'
        ]);

        try {
            $attachments = [];
            if ($request->hasFile('fwdfiles')) {
                foreach ($request->file('fwdfiles') as $file) {
                    $path = $file->store('forward_official_attachments', 'public');
                    $attachments[] = $path;
                }
            }

            // Get role
            $role = Role::whereRaw('LOWER(name) = ?', [strtolower($request->forward_to_designation)])->first();
            if (!$role) {
                return back()->with('error', 'Role not found.');
            }

            $toUser = null;

            if (strtolower($request->forward_to_designation) === 'arcs') {
                $com = Complaint::findOrFail($request->com_id);
                $toUser = User::where('role_id', $role->id)
                    ->where('district_id', $com->district)
                    ->first();
            } else {
                $toUser = User::where('role_id', $role->id)->first();
            }

            // Save resolution
            $resolution = new ComplaintApplicationFlow();
            $resolution->complaint_id = $request->com_id;
            $resolution->from_role = strtolower($request->res_current_role);
            $resolution->from_user_id = auth()->id();
            $resolution->action = 'verification';
            $resolution->to_role = $request->forward_to_designation;
            $resolution->to_user_id = $toUser?->id ?? null;
            $resolution->is_action_taken = true;
            $resolution->acted_by = auth()->id();
            $resolution->by_authorized_Person_id = $request->by_authorized_Person_id;
            $resolution->forward_by_designation = $request->forward_by_designation;
            $resolution->forward_to_designation = $request->forward_to_designation;
            $resolution->forward_to_authorized_Person_id = $request->forward_to_authorized_Person_id;
            $resolution->remarks = $request->fwdremarks;
            $resolution->attachments = json_encode($attachments);
            // return $resolution;
            $resolution->save();

            // Log
            $resolution_log = new ComplaintApplicationFlowLog();
            $resolution_log->complaint_id = $request->com_id;
            $resolution_log->action_type = 'approve';
            $resolution_log->old_value = 0;
            $resolution_log->new_value = 2;
            $resolution_log->performed_by_role = strtolower($request->res_current_role);
            $resolution_log->performed_by_user = auth()->id();
            $resolution_log->remarks = $request->fwdremarks;
            $resolution_log->by_authorized_Person_id = $request->by_authorized_Person_id;
            $resolution_log->forward_by_designation = $request->forward_by_designation;
            $resolution_log->forward_to_designation = $request->forward_to_designation;
            $resolution_log->forward_to_authorized_Person_id = $request->forward_to_authorized_Person_id;
            $resolution_log->save();

            // Update complaint
            $status = match (strtolower($request->forward_to_designation)) {
                'arcs' => 5,
                'drcs' => 6,
                'additionalrcs' => 7,
                'registrar' => 8,
                default => 1,
            };

            Complaint::where('id', $request->com_id)->update([
                'submitted_to_role' => strtolower($request->forward_to_designation),
                'current_role' => strtolower($request->forward_to_designation),
                'submitted_to_user_id' => $toUser?->id ?? null,
                'status' => $status
            ]);

            return back()->with('success', 'Application forwarded to next level.');
        } catch (\Exception $e) {
            // return $e;
            \Log::error('Resolution submission error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while submitting the resolution. Please try again.');
        }
    }
}