<?php

namespace App\Http\Controllers;

use App\Models\AuditAlotment;
use App\Models\DepartmentAuditor;
use App\Models\District;
use App\Models\FinancialYear;
use App\Models\SocietyType;
use Illuminate\Http\Request;
use App\Models\SocietyAppDetail;
use App\Models\SocietySectorType;
use App\Models\User;
use App\Models\Audit;
use App\Models\AuditBankDetail;
use App\Models\AuditBankDetails;
use App\Models\AuditSocietyDetails;
use App\Models\AuditCaReport;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Models\Block;

use Illuminate\Support\Facades\DB;

class AuditController extends Controller
{

    public function show()
    {
        return view('audit/dashboard');
    }
    /*
    public function auditshow()
    {
        $dept_auditor = User::Where('role_id', 8)->get();
        $society_type = SocietyType::all();
        $district = District::all();
        $financialYear = FinancialYear::all();
        return view('audit/auditalotment', compact('dept_auditor', 'society_type', 'district', 'financialYear'));
    }

    public function fetchSocieties(Request $request)
    {
        $district = $request->district;
        $block = $request->block;
        $type = $request->type;

        $data = SocietyAppDetail::with(['society_details'])
            ->where('district_id', $district)
            ->where('block_id', $block)
            ->where('status', '2')
            ->whereHas('society_details', function ($query) use ($type) {
                $query->where('society_category', $type);
            })
            ->get();

        return response()->json($data);
    }
    public function saveAllotment(Request $request)
    {
        $request->validate([
            'fy_id' => 'required',
            'dept_auditor_id' => 'required',
            'society_type_id' => 'required',
            'district_id' => 'required',
            'societies' => 'required|array'
        ]);
        $uid = auth()->id();
        try {
            foreach ($request->societies as $society_id) {

                AuditAlotment::Create(
                    [
                        'society_id' => $society_id,
                        'fy_id' => $request->fy_id,
                        'dept_auditor_id' => $request->dept_auditor_id,
                        'society_type_id' => $request->society_type_id,
                        'district_id' => $request->district_id,
                        'block_id' => $request->block_id,
                        'user_id' => $uid,
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Societies allotted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving data: ' . $e->getMessage()
            ]);
        }
    }
    public function getAllottedData(Request $request)
    {
        if ($request->ajax()) {
            $allotments = AuditAlotment::with(['society.society_details', 'district', 'block', 'societyType', 'auditor', 'financialYear']);

            return DataTables::of($allotments)
                ->addIndexColumn()
                ->addColumn('society_name', function ($row) {
                    return $row->society->society_details->society_name ?? 'Unknown Society';
                })
                ->addColumn('district_name', function ($row) {
                    return $row->district->name ?? 'Unknown District';
                })
                ->addColumn('society_type', function ($row) {
                    return $row->societyType->type ?? 'Unknown Type';
                })
                ->addColumn('block_name', function ($row) {
                    return $row->block->name ?? 'Unknown Block';
                })
                ->addColumn('financial_year', function ($row) {
                    return $row->financialYear->financial_year ?? 'Unknown Year';
                })
                ->addColumn('auditor_name', function ($row) {
                    return $row->auditor->name ?? 'Unknown Auditor';
                })
                // Add action buttons if needed
                // ->addColumn('action', function($row){ ... })
                ->make(true);
        }
    }

    public function auditData()
    {
        return view('audit.auditalotmentlist');
    }

    public function getAuditAllotmentList(Request $request)
    {
        if ($request->ajax()) {
            $id = auth()->id();
            $data = AuditAlotment::with(['district', 'block', 'societyType', 'financialYear', 'society'])
                ->where('dept_auditor_id', $id)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('district', fn($row) => $row->district->name ?? 'NA')
                ->addColumn('block', fn($row) => $row->block->name ?? 'NA')
                ->addColumn('society_type', fn($row) => $row->societyType->type ?? 'NA')
                ->addColumn('financial_year', fn($row) => $row->financialYear->financial_year ?? 'NA')
                ->addColumn('audit_start_auditor', fn($row) => $row->audit_start_date_auditor ? date('d-m-Y', strtotime($row->audit_start_date_auditor)) : 'NA')
                ->addColumn('audit_end_auditor', fn($row) => $row->audit_end_date_auditor ? date('d-m-Y', strtotime($row->audit_end_date_auditor)) : 'NA')
                ->addColumn('audit_start_society', fn($row) => $row->audit_start_date_society ? date('d-m-Y', strtotime($row->audit_start_date_society)) : 'NA')
                ->addColumn('audit_end_society', fn($row) => $row->audit_end_date_society ? date('d-m-Y', strtotime($row->audit_end_date_society)) : 'NA')
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-outline-primary allotment-btn"
                    data-id="' . $row->id . '"
                     data-society_name="' . ($row->society && $row->society->society_details ? $row->society->society_details->society_name : 'NA') . '"
                    data-society_type="' . ($row->societyType->type ?? 'NA') . '"
                    data-audit_start_auditor="' . ($row->audit_start_date_auditor ?? '') . '"
                    data-audit_end_auditor="' . ($row->audit_end_date_auditor ?? '') . '"
                    ><i class="fa fa-edit"></i> Audit Allotment</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function updateAuditDates(Request $request)
    {
        // dd($request);
        $request->validate([
            'allotment_id' => 'required|exists:audit_alotments,id',
            'audit_start_date_auditor' => 'nullable|date',
            'audit_end_date_auditor' => 'nullable|date',
        ]);

        $alotment = AuditAlotment::find($request->allotment_id);
        $alotment->audit_start_date_auditor = $request->audit_start_date_auditor;
        $alotment->audit_end_date_auditor = $request->audit_end_date_auditor;
        $alotment->status = 1;
        $alotment->save();

        return response()->json(['success' => true, 'message' => 'Audit dates updated successfully.']);
    }
    public function auditAprvalBysociety()
    {
        return view('audit/auditApprovalBySociety');
    }
    public function getAuditorPlanning(Request $request)
    {
        if ($request->ajax()) {
            $id = auth()->id();

            $data = AuditAlotment::with(['district', 'block', 'societyType', 'financialYear', 'society', 'auditor'])
                ->where('status', 1)
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('district', fn($row) => $row->district->name ?? 'NA')
                ->addColumn('block', fn($row) => $row->block->name ?? 'NA')
                ->addColumn('society_type', fn($row) => $row->societyType->type ?? 'NA')
                ->addColumn('financial_year', fn($row) => $row->financialYear->financial_year ?? 'NA')
                ->addColumn('audit_start_date', fn($row) => $row->audit_start_date_auditor ? date('d-m-Y', strtotime($row->audit_start_date_auditor)) : 'NA')
                ->addColumn('audit_end_date', fn($row) => $row->audit_end_date_auditor ? date('d-m-Y', strtotime($row->audit_end_date_auditor)) : 'NA')
                ->addColumn('society_name', fn($row) => $row->auditor->name ?? 'NA')
                ->make(true);
        }
    }
    public function storeSocietyApproval(Request $request)
    {
        dd($request);
        $request->validate([
            'audit_alotment_id' => 'required|exists:audit_alotments,id',
            'consent' => 'required|in:Yes,No',
            'current_role' => 'required|string',
        ]);

        try {
            $alotment = AuditAlotment::findOrFail($request->audit_alotment_id);
            $alotment->current_role = $request->current_role;

            if ($request->consent === 'No') {
                // $alotment->reason = $request->reason ?? null;

                if ($request->reason === 'Update Audit Date') {
                    $request->validate([
                        'audit_start_date_society' => 'required|date',
                        'audit_end_date_society' => 'required|date'
                    ]);

                    $alotment->audit_start_date_society = $request->audit_start_date_society;
                    $alotment->audit_end_date_society = $request->audit_end_date_society;
                } elseif ($request->reason === 'Audit By CA') {
                    $request->validate([
                        'ca_id' => 'required|exists:users,id'
                    ]);
                    $alotment->ca_id = $request->ca_id;
                }
            }

            // $alotment->society_consent = $request->consent;
            $alotment->save();

            return response()->json(['success' => true, 'message' => 'Society response submitted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed: ' . $e->getMessage()]);
        }
    }*/
    public function auditFormShow()
    {
        $societySectors = SocietySectorType::all();
        $bank = Bank::all();
        $district = District::all();
        $societydetails = DB::table('society_details')
            ->join('districts', 'society_details.district', '=', 'districts.id')
            ->select('society_details.*', 'districts.name as name')
            ->get();
        $blocks = Block::all();
        $financial_year = self::generateAuditPeriods();
        // return $financial_year;
        return view('audit.auditForm', compact('societySectors', 'bank', 'district', 'societydetails', 'blocks','financial_year'));
    }

    public function generateAuditPeriods()
    {
        $currentYear = date('Y');
        $auditYears = [];

        for ($i = 0; $i <= 20; $i++) {
            $year = $currentYear - $i;
            $nextYear = $year + 1;
            $auditYears[] = "{$year}-{$nextYear}";
        }
        return $auditYears;
    }

    public function storeAuditData(Request $request)
    {
        try {
            $step = $request->input('step');
            $auditId = $request->input('audit_id');

            if ($step == 1) {
                // Step 1: Create or update the main audit record
                $auditData = [
                    'audit_ref_no' => 1,
                    'ca_firm_name' => $request->input('firm_name'),
                    'ca_firm_reg_no' => $request->input('firm_registration_number'),
                    'ca_name' => $request->input('ca_name'),
                    'ca_membership_no' => $request->input('membership_number'),
                    'audit_period' => $request->input('audit_period'),
                    'ca_email' => $request->input('email'),
                    'ca_address' => $request->input('address'),
                    'ca_mobile_no' => $request->input('mobile'),
                    'ca_website' => $request->input('website'),
                    'audit_for' => null,
                    'status' => 1,
                ];

                if ($auditId) {
                    $audit = Audit::findOrFail($auditId);
                    $auditData['audit_for'] = $audit->audit_for;
                    $audit->update($auditData);
                } else {
                    $audit = Audit::create($auditData);
                    $auditId = $audit->id;
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Step 1 data saved successfully',
                    'audit_id' => $auditId,
                    'audit_ref_no' => $audit->audit_ref_no,
                ]);
            }

            // Step 2: Bank or Society Details
            elseif ($step == 2) {
                $request->validate([
                    'audit_for' => 'required|in:bank,society',
                ]);

                $audit = Audit::findOrFail($auditId);
                $auditFor = $request->input('audit_for') === '1' ? Audit::AUDIT_FOR_BANK : Audit::AUDIT_FOR_SOCIETY;
                $audit->audit_for = $auditFor;
                $audit->save();

                if ($auditFor === Audit::AUDIT_FOR_BANK) {
                    // Upload only bank-related files
                    $paths = [
                        'bank_letter_to_rbi' => $request->hasFile('bank_letter_to_rbi') ? $request->file('bank_letter_to_rbi')->store('audit/bank_docs', 'public') : null,
                        'balance_sheet' => $request->hasFile('bank_balance_sheet') ? $request->file('bank_balance_sheet')->store('audit/bank_docs', 'public') : null,
                        'statement' => $request->hasFile('statement') ? $request->file('statement')->store('audit/bank_docs', 'public') : null,
                        'annexure' => $request->hasFile('annexure') ? $request->file('annexure')->store('audit/bank_docs', 'public') : null,
                        'otherfile' => $request->hasFile('other_file') ? $request->file('other_file')->store('audit/bank_docs', 'public') : null,
                    ];
                    // return $paths;
                    $existing = AuditBankDetails::where('audit_id', $auditId)->first();

                    AuditBankDetails::updateOrCreate(
                        ['audit_id' => $auditId],
                        [
                            'bank_id' => $request->input('bank_name'),
                            'district_id' => $request->input('bank_branch_district'),
                            'bank_address' => $request->input('bank_branch_address'),
                            'bank_head_office_address' => $request->input('bank_head_office'),
                            'bank_letter_to_sbi' => $paths['bank_letter_to_rbi'] ?? optional($existing)->bank_letter_to_sbi,
                            'balance_sheet' => $paths['balance_sheet'] ?? optional($existing)->balance_sheet,
                            'profit_loss_statement' => $paths['statement'] ?? optional($existing)->profit_loss_statement,
                            'lfar_annexture' => $paths['annexure'] ?? optional($existing)->lfar_annexture,
                            'other_docs' => $paths['otherfile'] ?? optional($existing)->other_docs,
                        ]
                    );
                } else {
                    // Upload only society-related files
                    $paths = [
                        'balance_sheet'          => $request->hasFile('society_balance_sheet') ? $request->file('society_balance_sheet')->store('audit/society_docs', 'public') : null,
                        'profit_loss_statement'  => $request->hasFile('profit_loss_statement') ? $request->file('profit_loss_statement')->store('audit/society_docs', 'public') : null,
                        'society_other_file'  => $request->hasFile('society_other_file') ? $request->file('society_other_file')->store('audit/society_docs', 'public') : null,

                    ];

                    $existing = AuditSocietyDetails::where('audit_id', $auditId)->first();

                    AuditSocietyDetails::updateOrCreate(
                        ['audit_id' => $auditId],
                        [
                            'society_id' => $request->input('society_name'),
                            'district' => $request->input('society_district'),
                            'block' => $request->input('society_block'),
                            'society_type' => $request->input('society_type'),
                            'society_sector' => $request->input('society_sector'),
                            'society_chairman_name' => $request->input('society_chairman_name'),
                            'society_secretary_name' => $request->input('society_secretary_name'),
                            'balance_sheet'          => $paths['balance_sheet'] ?? optional($existing)->balance_sheet,
                            'profit_loss_statement'  => $paths['profit_loss_statement'] ?? optional($existing)->profit_loss_statement,
                            'other_docs'  => $paths['society_other_file'] ?? optional($existing)->society_other_file,

                        ]
                    );
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Step 2 data saved successfully',
                    'audit_id' => $auditId
                ]);
            }

            // Step 3: Upload CA Certificate and finalize
            elseif ($step == 3) {
                $audit = Audit::findOrFail($auditId);

                $certificatePath = $request->hasFile('auditor_certificate') ? $request->file('auditor_certificate')->store('audit/ca_reports', 'public') : null;

                $signaturePath = $request->hasFile('signature') ? $request->file('signature')->store('audit/signatures', 'public') : null;

                $existing = AuditCaReport::where('audit_id', $auditId)->first();

                AuditCaReport::updateOrCreate(
                    ['audit_id' => $auditId],
                    [
                        'auditor_certificate_opinion' => $certificatePath ?? optional($existing)->auditor_certificate_opinion,
                        'audit_type' => $request->input('audit_type'),
                        'remark' => $request->input('remark'),
                        'signature' => $signaturePath ?? optional($existing)->signature,
                    ]
                );

                $audit->status = 'submitted';
                $audit->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Audit submitted successfully',
                    'redirect_url' => route('audit.submission.success')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid step provided.',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving data: ' . $e->getMessage(),
                'error_details' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }


    //  get society
    // public function getSocietyDetails(Request $request)
    // {
    //     $sectorId = $request->sector_id;
    //     $societyName = $request->society_name;

    //     $society = ::where('society_sector_type_id', $sectorId)
    //         ->where('society_name', 'LIKE', '%' . $societyName . '%')
    //         ->first();

    //     if ($society) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => [
    //                 'society_name' => $society->society_name,
    //                 'app_id' => $society->app_id,
    //                 'society_mail_id' => $society->society_email
    //             ]
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Society not found'
    //         ]);
    //     }
    // }

    public function bankListing()
    {
        $bankAudits = Audit::with([
            'bankDetails.districtRelation',
            'bankDetails.bank',
        ])
            ->where('audit_for', Audit::AUDIT_FOR_BANK)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $allDistricts = District::pluck('name', 'id')->toArray();

        return view('audit.bank_index', [
            'bankAudits' => $bankAudits,
            'allDistricts' => $allDistricts
        ]);
    }


    // SocietyAuditController.php
    public function societyListing()
    {
        $societyAudits = Audit::with(['society_details', 'appDetail', 'societyDetails']) // load both relationships
            ->where('audit_for', Audit::AUDIT_FOR_SOCIETY)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('audit.society_index', compact('societyAudits'));
    }

    public function editAudit($id)
    {
        // return $id;
        $societySectors = SocietySectorType::all();
        $bank = Bank::all();
        $district = District::all();
        $blocks = Block::all();
        $auditDetails = Audit::findOrFail($id);
        $auditId = $auditDetails->id;
        $stpeTwoDetails = ($auditDetails->audit_for == 1) ? AuditBankDetails::where("audit_id", $auditId)->first() : AuditSocietyDetails::where("audit_id", $auditId)->first();
        $financial_year = self::generateAuditPeriods();
        // return $auditDetails;
        return view(
            'audit.auditForm',
            compact('societySectors', 'bank', 'auditDetails', 'stpeTwoDetails', 'district', 'blocks','financial_year')
        );
    }
}
