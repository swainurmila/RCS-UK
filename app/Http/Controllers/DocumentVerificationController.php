<?php

namespace App\Http\Controllers;

use App\Models\SocietyAppDetail;
use App\Models\SocietyRegisterDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DocumentVerificationController extends Controller
{
     public function verifyDocument(Request $request)
       {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:society_app_details,id',
            'field' => [
                'required',
                Rule::in([
                    'meeting1', 'meeting2', 'meeting3', 
                    'society_by_laws', 'all_id_proof',
                    'all_application_form', 'all_declaration_form', 'challan_proof'
                ])
            ],
            'status' => 'required|in:approved,rejected,pending',
            'remarks' => 'required_if:status,rejected|nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $app = SocietyAppDetail::findOrFail($request->application_id);
            $documents = SocietyRegisterDocuments::where('society_id', $app->app_id)->firstOrFail();

            $documents->update([
                "{$request->field}_status" => $request->status,
                "{$request->field}_remarks" => $request->remarks
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document verification updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update document verification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function uploadRevisedDocument(Request $request)
  {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:society_app_details,id',
            'field' => [
                'required',
                Rule::in([
                    'meeting1', 'meeting2', 'meeting3', 
                    'society_by_laws', 'all_id_proof',
                    'all_application_form', 'all_declaration_form', 'challan_proof'
                ])
            ],
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $app = SocietyAppDetail::findOrFail($request->application_id);
            $documents = SocietyRegisterDocuments::where('society_id', $app->app_id)->firstOrFail();

            // Delete old revised file if exists
            if ($documents->{"{$request->field}_revised"}) {
                Storage::disk('public')->delete($documents->{"{$request->field}_revised"});
            }

            $path = $request->file('file')->store('revised-documents', 'public');

            $documents->update([
                "{$request->field}_revised" => $path,
                "{$request->field}_status" => 'pending', // Reset status for re-verification
                "{$request->field}_remarks" => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Revised document uploaded successfully',
                'file_path' => Storage::url($path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload revised document',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function completeVerification(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|exists:society_app_details,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $app = SocietyAppDetail::findOrFail($request->application_id);
            $documents = SocietyRegisterDocuments::where('society_id', $app->app_id)->firstOrFail();

            // Verify all documents are approved
            $requiredFields = [
                'meeting1', 'meeting2', 'meeting3', 
                'society_by_laws', 'all_id_proof',
                'all_application_form', 'all_declaration_form', 'challan_proof'
            ];

            foreach ($requiredFields as $field) {
                if ($documents->{"{$field}_status"} !== 'approved') {
                    return response()->json([
                        'success' => false,
                        'message' => 'All documents must be approved before completing verification'
                    ], 400);
                }
            }

            // Mark verification as complete
            $app->update([
                'document_verification_complete' => true,
                'document_verification_completed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document verification completed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete document verification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
