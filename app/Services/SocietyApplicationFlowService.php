<?php

namespace App\Services;

use App\Models\SocietyAppDetail;
use App\Models\SocietyApplicationFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocietyApplicationFlowService
{
    /**
     * Approve the application and move it to the next role.
     *
     * @param SocietyAppDetail $app
     * @param Request $request
     * @return void
     */
    public function approve(SocietyAppDetail $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            // Log the flow of the approval action
            SocietyApplicationFlow::create([
                'application_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => $request->to_role,
                'to_user_id' => $request->to_user_id,
                'direction' => 'forward', // Indicating forward flow
                'action' => 'approve',
                'remarks' => $request->remarks,
                'attachments' => json_encode($request->attachments ?? []), // Handling attachments
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            // Update the application status and other relevant fields
            $app->update([
                'current_role' => $request->to_role,
                'submitted_to_user_id' => $request->to_user_id,
                'status' => $request->to_role === 'final' ? '2' : '1',
            ]);
        });
    }

    /**
     * Reject the application and update its status.
     *
     * @param Application $app
     * @param Request $request
     * @return void
     */
    public function reject(SocietyAppDetail $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            // Log the flow of the rejection action
            SocietyApplicationFlow::create([
                'application_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => null, // No specific role for rejection
                'to_user_id' => null, // No specific user for rejection
                'direction' => 'reverse', // Indicating reverse flow
                'action' => 'reject',
                'remarks' => $request->remarks,
                'attachments' => json_encode($request->attachments ?? []),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);


            // Update the application's status to rejected
            $app->update(['status' => '5']);
        });
    }

    /**
     * Revert the application and send it back to the applicant.
     *
     * @param Application $app
     * @param Request $request
     * @return void
     */
    public function revert(SocietyAppDetail $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            // Log the flow of the revert action
            SocietyApplicationFlow::create([
                'application_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => 'applicant', // Sending back to the applicant
                'to_user_id' => null, // No specific user in revert
                'direction' => 'reverse', // Indicating reverse flow
                'action' => 'revert',
                'remarks' => $request->remarks,
                'attachments' => json_encode($request->attachments ?? []),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            // Update the application status to reverted and reset user assignment
            $app->update([
                'current_role' => 'applicant',
                'submitted_to_user_id' => null,
                'status' => '3',
            ]);
        });
    }

    /**
     * Send the application to BCO for verification.
     *
     * @param Application $app
     * @param Request $request
     * @return void
     */
    public function sendToBco(SocietyAppDetail $app, Request $request)
    {
        DB::transaction(function () use ($app, $request) {
            // Log the flow of sending to BCO action
            SocietyApplicationFlow::create([
                'application_id' => $app->id,
                'from_role' => $app->current_role,
                'from_user_id' => auth()->id(),
                'to_role' => $request->to_role,
                'to_user_id' => null, // No specific user in this case
                'direction' => 'forward', // Indicating forward flow
                'action' => 'send_bco',
                'remarks' => $request->remarks,
                'attachments' => json_encode($request->attachments ?? []),
                'is_action_taken' => true,
                'acted_by' => auth()->id(),
            ]);

            // Update the application status to under verification by BCO
            $app->update([
                'current_role' => $request->to_role,
                'submitted_to_user_id' => $request->to_user_id,
                'status' => 'under_verification',
            ]);
        });
    }
}
