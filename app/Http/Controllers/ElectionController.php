<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\District;
use App\Models\Nomination;
use App\Models\NominationDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    public function show()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        $blocks = Block::all();

        return view('election.electionregister', compact('districts', 'blocks'));
    }
    public function showDashboard()
    {
        return view('election.dashboard');
    }
    public function electionregister(Request $request)
    {
        try {
            $input_data = $request->all();
            $step = $input_data['step'];
            session()->put('currentStep', $step);
            // Validation rules for each step
            $validationRules = $this->getValidationRules($step);
            $validatedData = $request->validate($validationRules);

            if ($step == 1) {
                // Step 1: Basic society details
                $nomination_data = [
                    'society_name' => $input_data['society_name'],
                    'society_category' => $input_data['society_category'],
                    'district_id' => $input_data['district'] ?? null,
                    'block_id' => $input_data['block'] ?? null,
                    'registration_number' => $input_data['registration_number'],
                    'total_members' => $input_data['total_members'],
                    'user_id' => auth()->id(),
                    'status' => 0
                ];

                if (isset($input_data['nomination_id']) && !empty($input_data['nomination_id'])) {
                    // Update existing nomination
                    $nomination = Nomination::findOrFail($input_data['nomination_id']);
                    $nomination->update($nomination_data);
                } else {
                    // Create new nomination
                    $nomination = Nomination::create($nomination_data);
                }
                session()->put('nominationId', $nomination->id);

                return response()->json([
                    'success' => true,
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'nomination_id' => $nomination->id
                ]);
            } else if ($step == 2) {
                // Step 2: Documents and additional details
                $nominationId = $input_data['nomination_id'] ?? session('nominationId');


                if (empty($nominationId)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Nomination ID is required for step 2.'
                    ], 422);
                }

                $nomination = Nomination::findOrFail($nominationId);

                // Check authorization
                if ($nomination->user_id != auth()->id()) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }

                $document_data = [
                    'is_new_society' => $input_data['is_new_society'],
                    'formation_date' => $input_data['formation_date'] ?? null,
                    'last_election_date' => $input_data['last_election_date'] ?? null,
                    'secretary_name' => $input_data['secretary_name'],
                    'chairman_name' => $input_data['chairman_name'],
                    'nomination_id' => $nomination->id
                ];

                // Handle file uploads
                $fileFields = [
                    'election_certificate',
                    'balance_sheet',
                    'audit_report',
                    'proposal',
                    'members_list',
                    'ward_allocation',
                    'challan_receipt',
                    'secretary_signature',
                    'chairman_signature'
                ];

                foreach ($fileFields as $field) {
                    if ($request->hasFile($field)) {
                        $document_data[$field] = $request->file($field)->store('nominations', 'public');
                    }
                }

                if (isset($input_data['document_id']) && !empty($input_data['document_id'])) {
                    // Update existing documents
                    $documents = NominationDocument::findOrFail($input_data['document_id']);
                    $documents->update($document_data);
                } else {
                    // Create new documents
                    $documents = NominationDocument::create($document_data);
                }

                // Final submission - update nomination status
                if ($step == 2) {
                    $nomination->update(['status' => 1]);
                }

                return response()->json([
                    'success' => true,
                    'message' => "Nomination submitted successfully!",
                    'nextStep' => $step + 1,
                    'document_id' => $documents->id
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        $nomination = Nomination::with('documents')->findOrFail($id);

        // Check if user is authorized to edit this nomination


        $districts = District::orderBy('name', 'ASC')->get();
        $blocks = Block::where('district_id', $nomination->district_id)->get();

        return view('election.electionregister', compact('nomination', 'districts', 'blocks'));
    }

    private function getValidationRules($step)
    {
        $rules = [];

        if ($step == 1) {
            $rules = [
                'society_name' => 'required|string|max:255',
                'society_category' => 'required|in:1,2,3',
                'registration_number' => 'required|string|max:50',
                'total_members' => 'required|integer|min:1',
            ];

            // Conditional rules based on society category
            $category = request()->input('society_category');
            if ($category == 1) { // Primary
                $rules['district'] = 'required|exists:districts,id';
                $rules['block'] = 'required|exists:blocks,id';
            } elseif ($category == 2) { // Central
                $rules['district'] = 'required|exists:districts,id';
            }
            // No district/block required for Apex (3)

        } elseif ($step == 2) {
            $rules = [
                'is_new_society' => 'required|boolean',
                'secretary_name' => 'required|string|max:255',
                'chairman_name' => 'required|string|max:255',
                'proposal' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'members_list' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'ward_allocation' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'challan_receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'secretary_signature' => 'required|file|mimes:jpg,jpeg,png|max:1024',
                'chairman_signature' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            ];

            // Conditional rules based on new society status
            if (request()->input('is_new_society') == 1) {
                $rules['formation_date'] = 'required|date|before_or_equal:today';
            } else {
                $rules['last_election_date'] = 'required|date|before_or_equal:today';
                $rules['election_certificate'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
                $rules['balance_sheet'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
                $rules['audit_report'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
            }
        }

        return $rules;
    }
    public function index()
    {
        // dd(auth()->id());
        $nominations = Nomination::with(['district', 'block', 'documents'])
            ->latest()
            ->get();
        // dd($nominations);
        return view('election.nomination-list', compact('nominations'));
    }

    public function view($id)
    {
        $nomination = Nomination::with(['district', 'block', 'documents'])
            ->findOrFail($id);

        // Authorization check
        if ($nomination->user_id != auth()->id()) {
            abort(403);
        }

        return view('election.view-nomination', compact('nomination'));
    }
    public function electionList()
    {
        $user = Auth::user();

        // Role-based filtering
        if ($user->role === 'Registrar') {
            $nominations = Nomination::with(['district', 'block', 'documents'])->get();
        } elseif ($user->role === 'DRCS') {
            $nominations = Nomination::with(['district', 'block', 'documents'])
                ->whereIn('society_category', [1, 2])->get();
        } elseif ($user->role === 'ARCS') {
            $nominations = Nomination::with(['district', 'block', 'documents'])
                ->where('society_category', 1)->get();
        }

        return view('election.nomination-list', compact('nominations', 'user'));
    }

    public function assignAdministrator(Request $request, $id)
    {
        $nomination = Nomination::findOrFail($id);
      
        $request->validate([
            'administrator_name' => 'required|string|max:255',
            'administrator_designation' => 'required|string|max:255',
            'administrator_area' => 'required|string|max:255',
        ]);
        $nomination->administrator_name = $request->administrator_name;
        $nomination->administrator_designation = $request->administrator_designation;
        $nomination->administrator_area = $request->administrator_area;
        $nomination->administrator_join_date = Carbon::now();
        $nomination->administrator_days_of_working = 0;
        $nomination->save();

        return response()->json(['success' => true]);
    }

    private function canTakeAction($nomination, $user)
    {
        if ($user->role === 'Registrar' && $nomination->society_category == 3) return true;
        if ($user->role === 'DRCS' && $nomination->society_category == 2) return true;
        if ($user->role === 'ARCS' && $nomination->society_category == 1) return true;
        return false;
    }
    public function viewDocuments($id)
    {
        $doc = NominationDocument::with('nomination.district', 'nomination.block')->findOrFail($id);
        return view('election.documents', compact('doc'))->render();
    }
    public function updateDocumentStatus(Request $request, $id)
    {
        // return $request;
        $doc = NominationDocument::findOrFail($id);
        //  dd($doc);
        $nomination = $doc->nomination;
        // dd($nomination);
        $request->validate([
            'approved' => 'required|boolean',
            'remarks' => 'nullable|string',
            'remark_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $doc->remark = $request->remarks;
        if ($request->hasFile('remark_file')) {
            $doc->remark_file = $request->file('remark_file')->store('remarks', 'public');
        }
        $doc->approved = $request->approved;
        $doc->save();

        // Status transitions
        if ($request->approved) {
            $nomination->status = 2; // Proposal Accepted
            $nomination->election_status = 'Proposal Accepted';
            $nomination->save();
        } elseif ($request->remarks) {
            $nomination->status = 1; // Proposal In Progress
            $nomination->election_status = 'Proposal In Progress';
            $nomination->save();
        }

        return response()->json(['success' => true]);
    }
    public function assignElectionDate(Request $request, $id)
    {
        $nomination = Nomination::findOrFail($id);
        $allowed = $this->canTakeAction($nomination, Auth::user());
        if (!$allowed) abort(403);

        $request->validate([
            'new_election_date' => 'required|date|after:today'
        ]);
        $nomination->new_election_date = $request->new_election_date;
        $nomination->status = 3; // New Election Date Assigned
        $nomination->election_status = 'New Election Date Assigned';
        $nomination->save();

        return response()->json(['success' => true]);
    }
    public function uploadCompletionCertificate(Request $request, $id)
    {
        $nomination = Nomination::findOrFail($id);

        $request->validate([
            'election_completion_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        $path = $request->file('election_completion_certificate')->store('election_certificates', 'public');
        $nomination->election_completion_certificate = $path;
        $nomination->election_status = 'Election Completed';
        $nomination->status = 5; // Election Completed
        $nomination->election_completed = true;
        $nomination->save();

        return response()->json(['success' => true]);
    }
    protected function updateStatuses()
    {
        $nominations = Nomination::all();
        foreach ($nominations as $nomination) {
            if ($nomination->status == 3 && $nomination->new_election_date && now()->isSameDay($nomination->new_election_date)) {
                $nomination->status = 4; // Election in Progress
                $nomination->election_status = 'Election in Progress';
                $nomination->save();
            }
        }
    }
}
