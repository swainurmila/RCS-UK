<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Appeal;
use DB;
use App\Models\AppealReject;
use App\Models\AppealFinalDecision;
use Auth;
use App\Models\AppealApproval;
use App\Models\AppealDocuments;


class AppealController extends Controller
{
    public function index(){

        return view('appeal.dashboard');
    }

    public function appealForm(){

        $districts = District::orderBy('name', 'ASC')->get();
        return view('appeal.form', compact('districts'));

    }

    public function appealFormStore(Request $request){


        try {
            $request->validate([
                'appellant_name' => 'required|max:255',
                'father_name' => 'required|max:255',
                'phone_number' => 'required|digits:10',
                'designation' => 'required|max:255',
                'district' => 'required|exists:districts,id',
                'full_address' => 'required',
                'aadhar' => 'required',
                'signature_of_appellant' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                
                'typeoforder' => 'required|max:255',
                'orderno' => 'required|max:255',
                'subject' => 'required',
                'order' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'evidence' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'amtofchallan' => 'required',
                'challanreceipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

                'appeal_against' => 'required',
                'appeal_against_district' => 'required|exists:districts,id',
                'appeal_to' => 'nullable',
            ]);

            // Save all data
            $appeal = new Appeal();
            
            // Step 1 data
            $latestAppeal = Appeal::orderBy('id', 'desc')->first();
            $nextId = $latestAppeal ? $latestAppeal->id + 1 : 1;
            $appeal->appeal_no = '#AP' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            $appeal->appeal_by = Auth::user()->id;
            $appeal->appellant_name = $request->appellant_name;
            $appeal->father_name = $request->father_name;
            $appeal->phone_number = $request->phone_number;
            $appeal->designation = $request->designation;
            $appeal->district_id = $request->district;
            $appeal->full_address = $request->full_address;
            

            if ($request->hasFile('aadhar')) {
                $aadharFile = $request->file('aadhar');
                $aadharName = 'aadhar_'.time().'.'.$aadharFile->extension();
                $aadharFile->move(public_path('appeals/aadhar'), $aadharName);
                $appeal->aadhar = 'appeals/aadhar/'.$aadharName;
            }

            // Save signature file
            if ($request->hasFile('signature_of_appellant')) {
                $signatureFile = $request->file('signature_of_appellant');
                $signatureName = 'signature_'.time().'.'.$signatureFile->extension();
                $signatureFile->move(public_path('appeals/signatures'), $signatureName);
                $appeal->signature_of_appellant = 'appeals/signatures/'.$signatureName;
            }
            // Step 2 data
            $appeal->typeoforder = $request->typeoforder;
            $appeal->orderno = $request->orderno;
            $appeal->subject = $request->subject;
            $appeal->amtofchallan = number_format((float)$request->amtofchallan, 2, '.', '');
            
            // Save files
             if ($request->hasFile('order')) {
                $orderFile = $request->file('order');
                $orderName = 'order_'.time().'.'.$orderFile->extension();
                $orderFile->move(public_path('appeals/orders'), $orderName);
                $appeal->order = 'appeals/orders/'.$orderName;
            }
            if ($request->hasFile('evidence')) {
                $evidenceFile = $request->file('evidence');
                $evidenceName = 'evidence_'.time().'.'.$evidenceFile->extension();
                $evidenceFile->move(public_path('appeals/evidence'), $evidenceName);
                $appeal->evidence = 'appeals/evidence/'.$evidenceName;
            }

            if ($request->hasFile('challanreceipt')) {
                $challanFile = $request->file('challanreceipt');
                $challanName = 'challan_'.time().'.'.$challanFile->extension();
                $challanFile->move(public_path('appeals/challans'), $challanName);
                $appeal->challanreceipt = 'appeals/challans/'.$challanName;
            }

            $appeal->appeal_against = $request->appeal_against;
            $appeal->appeal_against_district_id = $request->appeal_against_district;
            $appeal->appeal_to = $request->appeal_to;
            
            $appeal->save();

            return response()->json([
                'success' => true,
                'message' => 'Appeal submitted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function appealList(){

        $appeals = Appeal::with('district','documents','decision')->where('appeal_to',Auth::user()->role_id)->orWhere('appeal_by',Auth::user()->id)->orderBy('id','desc')->get();


        return view("appeal.list",compact('appeals'));
    }


    public function reject(Request $request){
        DB::beginTransaction();
        try {
            $request->validate([
                'appeal_id' => 'required|exists:appeals,id',
                'rejection_remarks' => 'required|string|max:1000',
                'rejection_docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $appeal = Appeal::findOrFail($request->appeal_id);
            
            $appeal->status = 'Rejected';
            $appeal->save();

            if($appeal->save()){

                $appealReject = new AppealReject;
                $appealReject->appeal_id = $request->appeal_id;
                $appealReject->remarks = $request->rejection_remarks;
                $appealReject->rejected_by = Auth::user()->id;
                
                // Store rejection document if provided
                if ($request->hasFile('rejection_docs')) {
                    $file = $request->file('rejection_docs');
                    $fileName = 'rejection_'.time().'.'.$file->extension();
                    $file->move(public_path('appeals/rejections'), $fileName);
                    $appealReject->docs = 'appeals/rejections/'.$fileName;
                }
                
                $appealReject->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Appeal rejected successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting appeal: '.$e->getMessage()
            ], 500);
        }
    }

    public function storeFinalDecision(Request $request){
        DB::beginTransaction();
        try {
            $request->validate([
                'appeal_id' => 'required|exists:appeals,id',
                'remarks' => 'required|string|max:1000',
                'docs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $appeal = Appeal::findOrFail($request->appeal_id);
            
            $appeal->status = 'Final Decision Made';
            $appeal->save();

            if($appeal->save()){

                $appealfinalDecision = new AppealFinalDecision;
                $appealfinalDecision->appeal_id = $request->appeal_id;
                $appealfinalDecision->remarks = $request->remarks;
                $appealfinalDecision->final_by = Auth::user()->id;

                
                // Store rejection document if provided
                if ($request->hasFile('document')) {
                    $file = $request->file('document');
                    $fileName = 'document_'.time().'.'.$file->extension();
                    $file->move(public_path('appeals/docs'), $fileName);
                    $appealfinalDecision->docs = 'appeals/docs/'.$fileName;
                }
                
                $appealfinalDecision->save();
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Appeal final decision made .'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting appeal: '.$e->getMessage()
            ], 500);
        }
    }


    public function approve(Request $request)
    {

        DB::beginTransaction();
        try {
            $request->validate([
                'appeal_id' => 'required|exists:appeals,id',
                'respondent_phone' => 'required|string|max:20',
            ]);

            $appeal = Appeal::findOrFail($request->appeal_id);


                
            $appeal->status = 'Approved';
            $appeal->save();

            if($appeal->save()){
                $appealApproval = new AppealApproval;
                $appealApproval->appeal_id = $request->appeal_id;
                $appealApproval->approved_by = Auth::user()->id;
                $appealApproval->respondent_phone = $request->respondent_phone;
                $appealApproval->remarks = $request->approval_remarks;
            
                $appealApproval->save();
            }

            $this->notifyRespondentOfficer($appeal);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appeal approved successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error in approval appeal: '.$th->getMessage()
            ], 500);
        }
       
    }

    private function notifyRespondentOfficer($appeal)
    {
        return true;
        // Implement your notification logic here
        // This could be an email, SMS, or in-system notification
        // Example:
        // Notification::send($respondentOfficer, new AppealApprovedNotification($appeal));
        
        // SMS::send($appeal->respondent_phone, 'An appeal has been filed against you...');
    }


    public function requestDocuments(Request $request)
    {

        $request->validate([
            'appeal_id' => 'required|exists:appeals,id',
            'ask_to' => 'required|string',
            // 'hearing_date' => 'required|date|after:today',
            'request_message' => 'required|string',
        ]);

        $appeal = Appeal::findOrFail($request->appeal_id);


        if($appeal){
            $documents = new AppealDocuments;
            $documents->appeal_id = $appeal->id;
            $documents->asking_id = Auth::user()->id;
            $documents->ask_to = $request->ask_to == 'Appellant' ? $appeal->appeal_by : $appeal->appeal_against;
            $documents->requested_for = $request->request_message;
            $documents->save();
        }

        $appeal->status = 'Awaiting Documents';
        $appeal->save();

        // Notify the appellant about document request
        $this->notifyAppellant($appeal, $request->request_message);

        return response()->json([
            'success' => true,
            'message' => 'Document request sent successfully'
        ]);
    }


    private function notifyAppellant($appeal,$msg)
    {
        return true;
        // Implement your notification logic here
        // This could be an email, SMS, or in-system notification
        // Example:
        // Notification::send($respondentOfficer, new AppealApprovedNotification($appeal));
        
        // SMS::send($appeal->respondent_phone, 'An appeal has been filed against you...');
    }


    public function awaitingDocuments(){



        $id="";
        if(Auth::user()->role_id == '7'){
            $id = Auth::user()->id;
        }else{
            $id = Auth::user()->role_id;
        }

        $awaitingDocuments = AppealDocuments::with('appeal.district','appeal.user','askingUser')->where('ask_to',$id)->get();

        return view('appeal.awaiting_documents',compact('awaitingDocuments'));
    }


    public function submitDocuments(Request $request){
        $request->validate([
            'awaiting_id' => 'required|exists:appeal_documents,id',
            'document1' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'document2' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $awaiting = AppealDocuments::findOrFail($request->awaiting_id);

            if ($request->hasFile('document1')) {
                $file1 = $request->file('document1');
                $fileName1 = 'document1_'.time().'.'.$file1->extension();
                $file1->move(public_path('appeals/docs'), $fileName1);
                $awaiting->document_one = 'appeals/docs/'.$fileName1;
            }

            // Handle document 2 upload
            if ($request->hasFile('document2')) {
                $file2 = $request->file('document2');
                $fileName2 = 'document2_'.time().'.'.$file2->extension();
                $file2->move(public_path('appeals/docs'), $fileName2);
                $awaiting->document_two = 'appeals/docs/'.$fileName2;
            }

            $appeal = Appeal::findOrFail($awaiting->appeal_id);
            $appeal->status = "Document Received";
            $appeal->save();


            $awaiting->status = '1';
            $awaiting->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Documents submitted successfully!',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit documents: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function assignHiring(Request $request)
    {

        $request->validate([
            'appeal_id' => 'required|exists:appeals,id',
            'hiring_date' => 'required|date|after_or_equal:today',
            'hiring_remark' => 'required|string|min:10|max:500',
        ]);

        try {
            $appeal = Appeal::findOrFail($request->appeal_id);

            $appeal->hiring_date = $request->hiring_date;
            $appeal->hiring_remark = $request->hiring_remark;
            $appeal->status = 'Hiring';
            $appeal->hiring_assigned_by = Auth::user()->id;

            $appeal->save();


            return response()->json([
                'success' => true,
                'message' => 'Hiring assigned successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign hiring: ' . $e->getMessage(),
            ], 500);
        }
    }
}
