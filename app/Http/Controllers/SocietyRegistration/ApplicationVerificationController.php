<?php

namespace App\Http\Controllers\SocietyRegistration;

use App\Http\Controllers\Controller;
use App\Models\AreaOfOperation;
use App\Models\Block;
use App\Models\District;
use App\Models\SocietyAppDetail;
use App\Models\SocietyApplicationFlow;
use App\Models\User;
use App\Services\SocietyWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApplicationVerificationController extends Controller
{
    protected $flowService;

    public function __construct(SocietyWorkflowService $flowService)
    {
        $this->flowService = $flowService;
    }
    public function social_regd_app_list()
    {
        $user = Auth::user();
        $role_id = $user->role_id;
        $roleName = $user->getRoleNames()->first();
        $districts = District::orderBy('name', 'ASC')->get();
        $all_districts = [];
        foreach ($districts as $k => $v) {
            $all_districts[$v->id] = $v->name;
        }
        // dd($all_districts);
        if ($role_id == 7) {
            $society_details = SocietyAppDetail::with('society_details', 'scheme')
                ->whereHas('society_details', function ($query) use ($user) {
                    $query->where('auth_id', $user->id);
                })
                ->get();
                // dd($society_details);
        } elseif (in_array($roleName, [ 'admin', 'superadmin'])) {
            $society_details = SocietyAppDetail::with(['flows', 'society_details'])
                ->get();
        } elseif (in_array($roleName, ['registrar'])) {
            $society_details = SocietyAppDetail::with(['flows', 'society_details'])->where("status", ">", 0)
                ->get();
        } else {
            $society_details = SocietyAppDetail::where(function ($query) {
                $query->where('submitted_to_role', auth()->user()->getRoleNames()->first())
                    ->where(function ($q) {
                        $q->whereNull('submitted_to_user_id')
                            ->orWhere('submitted_to_user_id', auth()->id());
                    })
                    ->where(function ($q) {
                        $user = auth()->user();
                        $roleName = $user->getRoleNames()->first();
                        if ($roleName === 'arcs') {
                            $q->where('block_id', $user->block_id);
                        } elseif ($roleName === 'ado') {
                            $q->where('district_id', $user->district_id);
                        } elseif ($roleName === 'drcs') {
                            $q->where('district_id', $user->district_id);
                        }
                    });
            })
                ->orWhereHas('flows', function ($q) {
                    $q->where('from_user_id', auth()->id()); // Applications the user has acted on before
                })
                ->with(['flows', 'society_details'])
                ->get();
        }
        // return $society_details;
        return view('social_regd_app_list', compact('society_details', 'all_districts'));
    }

    public function takeAction(Request $request)
    {

        $validated = $request->validate([
            'application_id' => 'required|exists:society_app_details,id',
            'action' => 'required|in:approve,reject,revert,resend_for_recheck',
            'remarks' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:10240', // Max 10MB files
        ]);
        $app = SocietyAppDetail::findOrFail($request->application_id);

        try {
            match ($request->action) {
                'approve' => $this->flowService->approve($app, $request),
                'reject' => $this->flowService->reject($app, $request),
                'revert' => $this->flowService->revert($app, $request),
                'resend_for_recheck' => $this->flowService->resendToLower($app, $request),
            };

            $message = match ($request->action) {
                'approve' => 'Application approved successfully.',
                'reject' => 'Application rejected.',
                'revert' => 'Application reverted to previous level.',
                'resend_for_recheck' => 'Application sent back for recheck.',
            };
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            return $e;
            return redirect()->back()->with('error', 'Something went wrong while processing the action.');
        }
    }

    public function history(SocietyAppDetail $application)
    {
        $history = $application->flows()->with(['fromUser', 'toUser'])->get();
        $app = $application->load('society_details:id,society_name,applied_on');
        return view('society-registration.official.history', compact('history', 'app'));
    }
}