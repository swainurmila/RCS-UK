<?php

namespace App\Http\Controllers\Settlement;

use App\Http\Controllers\Controller;
use App\Models\SettlementApplicationDetails;
use App\Models\SettlementDeclarationDetails;
use App\Models\SettlementDisputeDetails;
use App\Models\SettlementEvidenceDetails;
use App\Models\SettlementPartiesInvolvedDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SettlementController extends Controller
{
    public function showDashboard()
    {
        return view('settlement.dashboard');
    }

    public function addSettlement()
    {
        return view('settlement.addsettlement');
    }


    public function saveApplication(Request $request)
    {
        // return $request;
        // dd($request->all());
        try {
            $input_data = $request->all();
            $step = $input_data['step'];
            session()->put('currentStep', $step);
            // Validation rules for each step
            // $validationRules = $this->getValidationRules($step);
            // $validatedData = $request->validate($validationRules);

            if ($step == 1) {
                // return "hello";
                $settlement_details_data = $input_data;
                unset($settlement_details_data['step']);
                if (isset($input_data['settlement_id']) && !empty($input_data['settlement_id'])) {
                    // var_dump($input_data['settlement_id']);exit;
                    unset($settlement_details_data['_token']);
                    unset($settlement_details_data['settlement_id']);
                    $settlement_details_data['updated_at'] = date("Y/m/d H:i:s");
                    $settlement_details = SettlementApplicationDetails::where('id', (int) $input_data['settlement_id'])->update($settlement_details_data);
                    // return $settlement_details_data;
                } else {
                    // Registering the society
                    $settlement_details_data['user_id'] = @auth()->id();
                    $settlement_details = SettlementApplicationDetails::create($settlement_details_data);
                }
                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'settlementDetailsId' => (isset($input_data['settlement_id']) && !empty($input_data['settlement_id'])) ? $input_data['settlement_id'] : $settlement_details->id
                ]);
            } else if ($step == 2) {
                // return 'hy';
                $parties_data = $input_data;

                // Make sure this is set correctly
                $parties_data['settlement_id'] = $request->input('settlement_id') ?? session()->get('settlementDetailsId');

                // Clean up
                unset($parties_data['_token'], $parties_data['step']);

                if (!empty($input_data['parties_detailsId'])) {
                    // Update record in the correct table
                    SettlementPartiesInvolvedDetails::where('id', (int) $input_data['parties_detailsId'])->update($parties_data);
                    $record_id = $input_data['parties_detailsId'];
                } else {
                    // Create new record in the correct table
                    $created = SettlementPartiesInvolvedDetails::create($parties_data);
                    $record_id = $created->id;
                }

                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'parties_detailsId' => $record_id
                ]);
            } else if ($step == 3) {
                $dispute_data = $input_data;

                $dispute_data['settlement_id'] = $request['settlement_id'] ?? session()->get('settlementDetailsId');

                unset($dispute_data['_token'], $dispute_data['step']);

                if (isset($input_data['disputeId']) && !empty($input_data['disputeId'])) {
                    $disputeId = (int) $input_data['disputeId'];
                    unset($dispute_data['disputeId']);
                    $dispute_data['updated_at'] = now();
                    SettlementDisputeDetails::where('id', $disputeId)->update($dispute_data);
                } else {
                    $dispute_declaration = SettlementDisputeDetails::create($dispute_data);
                    $disputeId = $dispute_declaration->id;
                }

                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'disputeId' => $disputeId,
                ]);
            } else if ($step == 4) {
                $declaration_data = $input_data;

                // Use session or from request
                $declaration_data['settlement_id'] = $declaration_data['settlement_id'] ?? session()->get('settlementDetailsId');

                $declaration_data['is_confirmed'] = $request->has('is_confirmed') ? 1 : 0;

                $declaration_data['is_individual'] = $request->input('is_individual', null);

                if ($request->hasFile('Upload_signature')) {
                    $declaration_data['Upload_signature'] = $request->file('Upload_signature')->store('uploads', 'public');
                }

                if ($request->hasFile('upload_resolution')) {
                    $declaration_data['upload_resolution'] = $request->file('upload_resolution')->store('uploads', 'public');
                }

                if ($request->hasFile('aadhar_upload')) {
                    $declaration_data['aadhar_upload'] = $request->file('aadhar_upload')->store('uploads', 'public');
                }

                // Remove keys that don't belong to DB columns
                unset($declaration_data['_token'], $declaration_data['step']);

                if (!empty($declaration_data['declarationId'])) {
                    $id = (int) $declaration_data['declarationId'];
                    unset($declaration_data['declarationId']);
                    $declaration_data['updated_at'] = now();

                    SettlementDeclarationDetails::where('id', $id)->update($declaration_data);
                } else {
                    $created = SettlementDeclarationDetails::create($declaration_data);
                    $id = $created->id;
                }

                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'declarationId' => $id,
                ]);

                /*  $declaration_data = $input_data;

                // Set settlement_id
                $declaration_data['settlement_id'] = $declaration_data['settlement_id'] ?? session()->get('settlementDetailsId');

                $declaration_data['is_confirmed'] = $request->has('is_confirmed') ? 1 : 0;

                $declaration_data['is_individual'] = $request->input('is_individual', null);

                if ($request->hasFile('Upload_signature')) {
                    $declaration_data['Upload_signature'] = $request->file('Upload_signature')->store('uploads', 'public');
                }

                if ($request->hasFile('upload_resolution')) {
                    $declaration_data['upload_resolution'] = $request->file('upload_resolution')->store('uploads', 'public');
                }

                if ($request->hasFile('aadhar_upload')) {
                    $declaration_data['aadhar_upload'] = $request->file('aadhar_upload')->store('uploads', 'public');
                }

                // Clean up
                unset($declaration_data['_token'], $declaration_data['step']);

                if (!empty($declaration_data['declarationId'])) {
                    $id = (int) $declaration_data['declarationId'];
                    unset($declaration_data['declarationId']);
                    $declaration_data['updated_at'] = now();

                    SettlementDeclarationDetails::where('id', $id)->update($declaration_data);
                } else {
                    $created = SettlementDeclarationDetails::create($declaration_data);
                    $id = $created->id;
                }

                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'declarationId' => $id,
                ]); */
            } else if ($step == 5) {
                $evidence_data = $input_data;
                $evidence_data['settlement_id'] = (isset($evidence_data['settlement_id']) && !empty($evidence_data['settlement_id'])) ? $evidence_data['settlement_id'] : session()->get('settlementDetailsId');
                if ($request->hasFile('upload_challan_reciept')) {
                    $evidence_data['upload_challan_reciept'] = $request->file('upload_challan_reciept')->store('uploads', 'public');
                }

                if ($request->hasFile('upload_documentary_evidence')) {
                    $evidence_data['upload_documentary_evidence'] = $request->file('upload_documentary_evidence')->store('uploads', 'public');
                }

                if ($request->hasFile('upload_witness')) {
                    $evidence_data['upload_witness'] = $request->file('upload_witness')->store('uploads', 'public');
                }

                if (isset($input_data['evidence_id']) && !empty($input_data['evidence_id'])) {
                    unset($evidence_data['_token']);
                    unset($evidence_data['step']);
                    unset($evidence_data['evidence_id']);
                    $evidence_data['updated_at'] = Carbon::now();
                    $doc_details = SettlementEvidenceDetails::where('id', (int) $input_data['evidence_id'])->update($evidence_data);
                } else {
                    $doc_details = SettlementEvidenceDetails::create($evidence_data);
                }
                $evidence_id = (isset($input_data['evidence_id']) && !empty($input_data['evidence_id'])) ? $input_data['evidence_id'] : $doc_details->id;
                // dd($evidence_id);
                if ($evidence_id) {
                    $settlementAppDetailsId = $evidence_data['settlement_id'];
                    $upd = [];
                    $upd['status'] = 1;
                    $upd['submitted_to_role'] = "arcs"; // first application goes to arcs
                    $upd['current_role'] = "arcs";
                    // $cutofDays = config('society_workflow.application_life_period');
                    // $cutofDay = Carbon::now()->addDays($cutofDays);
                    // $cutofDay = $cutofDay->toDateString();
                    // $upd['cutoff_date'] = $cutofDay;
                    SettlementApplicationDetails::where('id', $settlementAppDetailsId)->update($upd);
                }
                session()->forget('settlementDetailsId');
                session()->forget('societyAppDetailsId');
                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'evidence_id' => $evidence_id
                ]);
            }
        } catch (\Exception $e) {
            return $e;
            return response()->json([
                'errors' => $e->getMessage()
            ], status: 500);
        }
    }




    // Step 5: Proof of Evidence Upload
    private function storeStep5(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount_paid' => 'required|numeric|min:0',
            'challan_no' => 'required|string|max:50',
            'challan_reciept' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'upload_documentary_evidence' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'upload_witness' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'upload_any_other_supporting' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['settlement_id'] = $request->settlement_id;

        try {
            // Handle file uploads
            $data['challan_reciept'] = $this->uploadFile($request->file('challan_reciept'), 'arbitration/challans');
            $data['upload_documentary_evidence'] = $this->uploadFile($request->file('upload_documentary_evidence'), 'arbitration/evidence');
            $data['upload_witness'] = $this->uploadFile($request->file('upload_witness'), 'arbitration/witnesses');
            $data['upload_any_other_supporting'] = $this->uploadFile($request->file('upload_any_other_supporting'), 'arbitration/supporting');

            if ($request->filled('evidence_id')) {
                $evidence = SettlementEvidenceDetails::findOrFail($request->evidence_id);
                $evidence->update($data);
            } else {
                $evidence = SettlementEvidenceDetails::create($data);
            }

            // Mark application as complete
            $application = SettlementApplicationDetails::find($request->settlement_id);
            $application->update(['status' => 'submitted']);

            return response()->json([
                'success' => true,
                'id' => $evidence->id,
                'message' => 'Application submitted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting application: ' . $e->getMessage()
            ], 500);
        }
    }

    // Helper function for file uploads
    private function uploadFile($file, $directory)
    {
        if (!$file) {
            return null;
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Store file
        $path = $file->storeAs($directory, $filename, 'public');

        return $path;
    }
}