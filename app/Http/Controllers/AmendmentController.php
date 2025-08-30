<?php

namespace App\Http\Controllers;

use App\Models\AamSabhaMeeting;
use App\Models\AmendmentSociety;
use App\Models\ManagingCommitte;
use App\Models\SocietyAppDetail;
use App\Models\SocietyRegistration;
use App\Models\VotingOnAmendments;
use App\Models\District;
use App\Models\Block;
use App\Models\SocietySectorType;
use App\Services\AmendmentWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AmendmentController extends Controller
{
    protected $flowService;

    public function __construct(AmendmentWorkflowService $flowService)
    {
        $this->flowService = $flowService;
    }
    public function show_ablm_dashboard(Request $request)
    {
        $query = AmendmentSociety::query();
        $districts = District::orderBy('name', 'ASC')->get();
        // $sectors = SocietySectorType::orderBy('cooperative_sector_name', 'ASC')->get();

        // Filters
        if ($request->filled('start')) {
            $query->whereDate('created_at', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('created_at', '<=', $request->end);
        }
        if ($request->filled('month')) {
            $month = date('m', strtotime($request->month));
            $query->whereMonth('created_at', $month);
        }
        if ($request->filled('year')) {
            $year = date('Y', strtotime($request->year));
            $query->whereYear('created_at', $year);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('block')) {
            $query->where('block', $request->block);
        }
        if ($request->filled('society_type')) {
            $query->whereHas('society_details', function ($q) use ($request) {
                $q->where('society_category', $request->society_type);
            });
        }
        if ($request->filled('sector_type')) {
            $query->where('sector_type', $request->sector_type);
        }
        $districtQuery = District::query();

        if (
            $request->filled('start') || $request->filled('end') || $request->filled('month') || $request->filled('year') ||
            $request->filled('district') || $request->filled('block') || $request->filled('society_type')
        ) {

            $districtWiseCounts = District::withCount([
                'amendmentSocieties as primary_count' => function ($q) use ($request) {
                    $q->whereHas('society_details', function ($q2) {
                        $q2->where('society_category', 1);
                    });
                    $this->applyFiltersToQuery($q, $request);
                },
                'amendmentSocieties as central_count' => function ($q) use ($request) {
                    $q->whereHas('society_details', function ($q2) {
                        $q2->where('society_category', 2);
                    });
                    $this->applyFiltersToQuery($q, $request);
                },
                'amendmentSocieties as apex_count' => function ($q) use ($request) {
                    $q->whereHas('society_details', function ($q2) {
                        $q2->where('society_category', 3);
                    });
                    $this->applyFiltersToQuery($q, $request);
                }
            ])->get();
        } else {
            $districtWiseCounts = District::withCount([
                'amendmentSocieties as primary_count' => function ($q) {
                    $q->whereHas('society_details', function ($q2) {
                        $q2->where('society_category', 1);
                    });
                },
                'amendmentSocieties as central_count' => function ($q) {
                    $q->whereHas('society_details', function ($q2) {
                        $q2->where('society_category', 2);
                    });
                },
                'amendmentSocieties as apex_count' => function ($q) {
                    $q->whereHas('society_details', function ($q2) {
                        $q2->where('society_category', 3);
                    });
                }
            ])->get();
        }
        // Status mapping for the dashboard
        $stats = [
            'submitted'     => (clone $query)->where('status', '>', 0)->count(),
            'under_review'  => (clone $query)->where('status', AmendmentSociety::STATUS_UNDER_PROCESS)->count(),
            'reverted'      => (clone $query)->where('status', AmendmentSociety::STATUS_REVERTED)->count(),
            'rejected'      => (clone $query)->where('status', AmendmentSociety::STATUS_REJECTED)->count(),
            'approved'      => (clone $query)->where('status', AmendmentSociety::STATUS_APPROVED)->count(),
        ];

        // Bar Chart: status counts
        $statusCounts = [
            'Submitted'         => $stats['submitted'],
            'Under Review'      => $stats['under_review'],
            'Reverted Status'   => $stats['reverted'],
            'Rejected'          => $stats['rejected'],
            'By-laws Amended'   => $stats['approved'],
        ];

        // Pie Chart: society type distribution
        // $societyTypes = AmendmentSociety::selectRaw('society_category, COUNT(*) as total')
        //     ->groupBy('society_category')
        //     ->pluck('total', 'society_category');
        $societyTypes = [
            1 => AmendmentSociety::whereHas('society_details', function ($q) {
                $q->where('society_category', 1);
            })->count(),
            2 => AmendmentSociety::whereHas('society_details', function ($q) {
                $q->where('society_category', 2);
            })->count(),
            3 => AmendmentSociety::whereHas('society_details', function ($q) {
                $q->where('society_category', 3);
            })->count(),
        ];

        // For monthly breakdown (for bar chart if needed)
        $months = range(1, 5);
        $columnChartData = [
            'submitted' => [],
            'under_review' => [],
            'reverted' => [],
            'rejected' => [],
            'approved' => [],
        ];
        foreach ($months as $m) {
            $columnChartData['submitted'][]    = AmendmentSociety::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->where('status', AmendmentSociety::STATUS_DRAFT)->count();
            $columnChartData['under_review'][] = AmendmentSociety::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->where('status', AmendmentSociety::STATUS_UNDER_PROCESS)->count();
            $columnChartData['reverted'][]     = AmendmentSociety::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->where('status', AmendmentSociety::STATUS_REVERTED)->count();
            $columnChartData['rejected'][]     = AmendmentSociety::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->where('status', AmendmentSociety::STATUS_REJECTED)->count();
            $columnChartData['approved'][]     = AmendmentSociety::whereMonth('created_at', $m)->whereYear('created_at', date('Y'))->where('status', AmendmentSociety::STATUS_APPROVED)->count();
        }

        return view('amendment.dashboard', compact(
            'stats',
            'statusCounts',
            'societyTypes',
            'districts',
            'columnChartData',
            'districtWiseCounts'
        ));
    }

    public function filterDashboard(Request $request)
    {
        $query = AmendmentSociety::query();


        if ($request->filled('start')) {
            $query->whereDate('created_at', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('created_at', '<=', $request->end);
        }
        if ($request->filled('month')) {
            $month = date('m', strtotime($request->month));
            $query->whereMonth('created_at', $month);
        }
        if ($request->filled('year')) {
            $year = date('Y', strtotime($request->year));
            $query->whereYear('created_at', $year);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('block')) {
            $query->where('block', $request->block);
        }
        if ($request->filled('society_type')) {
            $query->whereHas('society_details', function ($q) use ($request) {
                $q->where('society_category', $request->society_type);
            });
        }


        // Get filtered stats
        $stats = [
            'submitted'     => (clone $query)->where('status', '>', 0)->count(),
            'under_review'  => (clone $query)->where('status', AmendmentSociety::STATUS_UNDER_PROCESS)->count(),
            'reverted'      => (clone $query)->where('status', AmendmentSociety::STATUS_REVERTED)->count(),
            'rejected'      => (clone $query)->where('status', AmendmentSociety::STATUS_REJECTED)->count(),
            'approved'      => (clone $query)->where('status', AmendmentSociety::STATUS_APPROVED)->count(),
        ];
        // Pie chart data
        $pieChartData = [
            'series' => [
                (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 1))->count(),
                (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 2))->count(),
                (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 3))->count()
            ],
            'labels' => ["Primary", "Central", "Apex"]
        ];
        // Column chart data
        $columnChartData = [
            'series' => array_values($stats),
            'categories' => ["Submitted", "Under Review", "Reverted Status", "Rejected", "By-laws Amended"]
        ];

        // District-wise counts
        $districtWiseCounts = District::withCount([
            'amendmentSocieties as primary_count' => function ($q) use ($request) {
                $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 1));
                if ($request->filled('district')) $q->where('district', $request->district);
                if ($request->filled('block')) $q->where('block', $request->block);
            },
            'amendmentSocieties as central_count' => function ($q) use ($request) {
                $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 2));
                if ($request->filled('district')) $q->where('district', $request->district);
                if ($request->filled('block')) $q->where('block', $request->block);
            },
            'amendmentSocieties as apex_count' => function ($q) use ($request) {
                $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 3));
                if ($request->filled('district')) $q->where('district', $request->district);
                if ($request->filled('block')) $q->where('block', $request->block);
            },
        ])->get();

        $societyCounts = [
            'apex_total' => $districtWiseCounts->sum('apex_count'),
            'central_total' => $districtWiseCounts->sum('central_count'),
            'primary_total' => $districtWiseCounts->sum('primary_count'),
        ];

        return response()->json([
            'stats' => $stats,
            'pieChartData' => $pieChartData,
            'columnChartData' => $columnChartData,
            'districtWiseCounts' => $societyCounts
        ]);
    }

    private function applyFiltersToQuery($query, $request, $includeMonth = true)
    {
        if ($request->filled('start')) {
            $query->whereDate('created_at', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('created_at', '<=', $request->end);
        }
        if ($includeMonth && $request->filled('month')) {
            $month = date('m', strtotime($request->month));
            $query->whereMonth('created_at', $month);
        }
        if ($request->filled('year')) {
            $year = date('Y', strtotime($request->year));
            $query->whereYear('created_at', $year);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('block')) {
            $query->where('block', $request->block);
        }
        if ($request->filled('society_type')) {
            $query->whereHas('society_details', function ($q) use ($request) {
                $q->where('society_category', $request->society_type);
            });
        }
        if ($request->filled('sector_type')) {
            $query->where('sector_type', $request->sector_type);
        }
    }
    public function show()
    {
        $id = auth()->id();
        $districts = District::orderBy('name', 'ASC')->get();
        $socity_details = SocietyRegistration::where('auth_id', $id)->get(['id', 'society_name']);

        // $socity_details = SocietyRegistration::where('status', 1)->get();
        return view('amendment.social_amendment', [
            'socity_details' => $socity_details,
            'amendment' => null,
            'societyDetails' => null,
            'managingCommittee' => null,
            'aamSabhaMeeting' => null,
            'votingOnAmendments' => null,
            'districts' => $districts
        ]);
    }
    // public function getSocietiesByCategory(Request $request)
    // {
    //     // dd($request);
    //     $societies = SocietyRegistration::where('society_category', $request->category)->get(['id', 'society_name']);
    //     return response()->json($societies);
    // }
    public function getSocietiesByCategory(Request $request)
    {
        // dd($request);
        $societies = SocietyRegistration::where('society_category', $request->category)
            ->whereHas('appDetail', function ($query) {
                $query->where('status', 2); 
            })
            ->get(['id', 'society_name']);

        return response()->json($societies);
    }


    public function getSocietyDetails(Request $request)
    {
        $society = SocietyRegistration::with(['block', 'districtName'])->find($request->id);

        if (!$society) {
            return response()->json(['error' => 'Society not found'], 404);
        }

        return response()->json([
            'district_id' => $society->district,
            'district_name' => $society->districtName->name ?? '',
            'block_id' => $society->developement_area,
            'block_name' => $society->block->name ?? ''
        ]);
    }



    public function ammendmentRegister(Request $request)
    {
        try {
            $input_data = $request->all();

            $step = $input_data['step'];
            session()->put('currentStep', $step);


            $society_id = $request->input('edit_id') ?? session()->get('societyDetailsId');

            if (!$society_id && $step != 1) {
                return response()->json(['errors' => ['message' => 'Missing society ID.']], 422);
            }

            if ($step == 1) {
                // Step 1: Society Details
                $validatorSociety = Validator::make($request->all(), [
                    'society_name' => 'required',
                    'total_members' => 'required|integer',
                    'district' => 'required',
                    'block' => 'required',
                    'address' => 'required',
                    'e18_certificate' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg,jpg',
                    'board_members' => 'required|integer',
                    'quorum' => 'required|integer',
                ]);

                if ($validatorSociety->fails()) {
                    return response()->json(['errors' => $validatorSociety->errors()], 422);
                }

                $society = AmendmentSociety::updateOrCreate(
                    ['id' => $society_id],
                    [
                        'name' => $request->society_name,
                        'total_members' => $request->total_members,
                        'district' => (int) $request->district,
                        'block' => (int) $request->block,
                        'address' => $request->address,
                        'total_board_members' => $request->board_members,
                        'quorum_members' => $request->quorum,
                        'status' => 0,
                        'submitted_to_role' => 'arcs',
                        'current_role' => 'arcs',
                        'user_id' => Auth::id(),
                        'society_category' => $request->society_category,
                    ]
                );


                if (!$society_id) {
                    $society->amendment_ref_no = 'ABLM#' . (AmendmentSociety::max('id') + 1);
                }

                if ($request->hasFile('e18_certificate')) {
                    $society->e18_certificate = $request->file('e18_certificate')->store('e18_certificates', 'public');
                }

                $society->save();
                session()->put('societyDetailsId', $society->id);
                // return (int) $request->district;
                return response()->json([
                    'message' => 'Society details saved successfully!',
                    'nextStep' => 2,
                    'societyDetailsId' => $society->id,
                ]);
            }

            if ($step == 2) {
                // Step 2: Managing Committee
                $validatorCommittee = Validator::make($request->all(), [
                    'existing_bylaw' => 'nullable|file|mimes:pdf,doc,docx',
                    'bylaw_section' => 'nullable|file|mimes:pdf,doc,docx',
                    'proposed_amendment' => 'required',
                    'purpose_of_amendment' => 'required',
                    'approval' => 'required|in:yes,no',
                    'committee_approval_doc' => 'nullable|file|mimes:pdf,doc,docxrequired_if:approval,yes',
                ]);

                if ($validatorCommittee->fails()) {
                    return response()->json(['errors' => $validatorCommittee->errors()], 422);
                }

                $committee = ManagingCommitte::updateOrCreate(
                    ['society_id' => $society_id],
                    [
                        'proposed_amendment' => $request->proposed_amendment,
                        'purpose_of_amendment' => $request->purpose_of_amendment,
                        'approval' => $request->approval,
                    ]
                );

                if ($request->hasFile('existing_bylaw')) {
                    $committee->existing_bylaw = $request->file('existing_bylaw')->store('existing_bylaws', 'public');
                }

                if ($request->hasFile('bylaw_section')) {
                    $committee->bylaw_section = $request->file('bylaw_section')->store('bylaw_sections', 'public');
                }
                if ($request->hasFile('registration_certificate')) {
                    $committee->registration_certificate = $request->file('registration_certificate')->store('registration_certificate', 'public');
                }

                if ($request->approval === 'yes' && $request->hasFile('committee_approval_doc')) {
                    $committee->committee_approval_doc = $request->file('committee_approval_doc')->store('committee_approvals', 'public');
                }

                $committee->save();

                return response()->json([
                    'message' => 'Managing Committee details saved successfully!',
                    'nextStep' => 3,
                ]);
            }

            if ($step == 3) {
                // Step 3: Aam Sabha Meeting
                $validatorAamSabha = Validator::make($request->all(), [
                    'noticeOfAamSabha' => 'required|in:0,1',
                    'communication_method' => 'nullable|required_if:noticeOfAamSabha,1',
                    'other_communication' => 'nullable|string',
                    'ag_meeting_date' => 'nullable|date|required_if:noticeOfAamSabha,1',
                    'meeting_notice' => 'nullable|file|mimes:pdf|required_if:noticeOfAamSabha,1',
                ]);

                if ($validatorAamSabha->fails()) {
                    return response()->json(['errors' => $validatorAamSabha->errors()], 422);
                }

                $aamSabha = AamSabhaMeeting::updateOrCreate(
                    ['society_id' => $society_id],
                    [
                        'noticeOfAamSabha' => $request->noticeOfAamSabha,
                        'communication_method' => $request->communication_method,
                        'other_communication' => $request->other_communication,
                        'ag_meeting_date' => $request->ag_meeting_date,
                    ]
                );

                if ($request->hasFile('meeting_notice')) {
                    $aamSabha->meeting_notice = $request->file('meeting_notice')->store('meeting_notices', 'public');
                }

                $aamSabha->save();

                return response()->json([
                    'message' => 'Aam Sabha Meeting details saved successfully!',
                    'nextStep' => 4,
                ]);
            }

            if ($step == 4) {
                // Step 4: Voting on Amendments
                $validatorVoting = Validator::make($request->all(), [
                    'total_members' => 'required|integer',
                    'members_present' => 'required|integer',
                    'quorum_completed' => 'required|in:0,1',
                    'votes_favor' => 'nullable|required_if:quorum_completed,1|integer',
                    'votes_against' => 'nullable|required_if:quorum_completed,1|integer',
                    'total_voted' => 'nullable|integer',
                    'abstain_members' => 'nullable|integer',
                    'resolution_amendment' => 'nullable|string',
                    'resolution_file' => 'nullable|file|mimes:pdf',
                ]);

                if ($validatorVoting->fails()) {
                    return response()->json(['errors' => $validatorVoting->errors()], 422);
                }

                $voting = VotingOnAmendments::updateOrCreate(
                    ['society_id' => $society_id],
                    [
                        'total_members' => $request->total_members,
                        'members_present' => $request->members_present,
                        'quorum_completed' => $request->quorum_completed,
                        'votes_favor' => $request->votes_favor,
                        'votes_against' => $request->votes_against,
                        'total_voted' => $request->total_voted,
                        'abstain_members' => $request->abstain_members,
                        'resolution_amendment' => $request->resolution_amendment,
                    ]
                );

                if ($request->hasFile('resolution_file')) {
                    $voting->resolution_file = $request->file('resolution_file')->store('voting_resolutions', 'public');
                }

                $voting->save();
                AmendmentSociety::where('id', $society_id)->update(['status' => 1]);

                session()->forget('societyDetailsId');
                session()->forget('currentStep');

                return response()->json([
                    'message' => 'Voting on Amendments details saved successfully! Process Completed.',
                    'completed' => true,
                ]);
            }

            return response()->json(['errors' => 'Invalid step provided.'], 400);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['message' => $e->getMessage()]], 500);
        }
    }


    public function amendment_listing()
    {
        return view('amendment.list');
    }
    public function amendment_details($id)
    {
        // return $id;
        $amendment = AmendmentSociety::with([
            'managing_committee',
            'aam_sabha_meeting',
            'voting_on_amendments',
            'society_detail'
        ])->find($id);
        // return $amendment;
        if (!$amendment) {
            return response()->json(['message' => 'Amendment not found!'], 404);
        }
        return view('amendment.partials.view', compact('amendment'));
        // return view('amendment.view_amendment', compact('amendment'));
    }


    public function getAmendmentList(Request $request)
    {

        if ($request->ajax()) {

            $getAmendmentData = AmendmentSociety::with(['managing_committee', 'aam_sabha_meeting', 'voting_on_amendments', 'flows']);

            return Datatables::of($getAmendmentData)
                ->addIndexColumn()

                ->addColumn('society_name', function ($row) {
                    return $row->society_detail->society_name ?? '';
                })

                ->addColumn('amendment_ref_no', function ($row) {
                    return 'AMND-' . str_pad($row->id, 5, '0', STR_PAD_LEFT);
                })

                ->addColumn('original_bylaw', function ($row) {
                    if (!empty($row->managing_committee->existing_bylaw)) {
                        $url = asset('storage/' . $row->managing_committee->existing_bylaw);
                        return '<a href="' . $url . '" target="_blank">View Bylaw</a>';
                    }
                    return 'N/A';
                })
                ->addColumn('society_category', function ($row) {
                    return $row->society_detail->society_category ?? '';
                })

                ->addColumn('amended_clause', function ($row) {
                    return $row->managing_committee->proposed_amendment ?? 'N/A';
                })

                ->addColumn('address', function ($row) {
                    return $row->address ?? '';
                })

                ->addColumn('amendment_date', function ($row) {
                    return !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : '';
                })

                ->addColumn('status', function ($row) {
                    return '<span class="badge bg-' . $row->status_label['class'] . '">' . $row->status_label['text'] . '</span>';
                })

                ->addColumn('history', function ($row) {
                    return '<button class="btn btn-outline-info btn-sm view-history-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#historyModal"
                                    data-id="' . $row->id . '">
                                <i class="fas fa-history"></i>
                            </button>';
                })

                ->addColumn('action', function ($row) {

                    // $viewUrl = route('show.ablm_details', $row->id);
                    // $buttons = '<a href="' . $viewUrl . '" class="btn btn-outline-success btn-sm" title="View">
                    //                 <i class="fa fa-eye"></i>
                    //             </a>';
                    $buttons = '<div class="d-flex justify-content-center gap-1">';
                    $buttons .= '<button class="btn btn-sm btn-info view-application"
                    data-id="' . $row->id . '"
                    data-bs-toggle="modal"
                    data-bs-target="#viewSocietyModal"
                    title="View">
                <i class="fas fa-eye"></i>
            </button>';
                    if (($row->status == 0 || $row->status == 3) && auth()->user()->role_id == 7) {
                        $editUrl = route('amendment.edit', $row->id);
                        $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                             </a>';
                    }
                    if (auth()->check() && auth()->user()->can('amendment_action', $row)) {
                        $buttons .= '<button class="btn btn-outline-primary btn-sm take-action-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#amendmentActionModal"
                                            data-id="' . $row->id . '"
                                            data-status="' . $row->status . '"
                                            data-current-role="' . $row->current_role . '" style="white-space: nowrap;">
                                            Take Action
                                    </button>';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })


                ->rawColumns(['original_bylaw', 'status', 'history', 'action'])
                ->make(true);
        }
    }

    public function takeAction(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'amendment_id' => 'required|exists:amendment_societies,id',
            'action' => 'required|in:approve,reject,revert,resend_for_recheck',
            'remarks' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:10240',
        ]);

        $amendment = AmendmentSociety::findOrFail($request->amendment_id);

        try {
            match ($request->action) {
                'approve' => $this->flowService->approve($amendment, $request),
                'reject' => $this->flowService->reject($amendment, $request),
                'revert' => $this->flowService->revert($amendment, $request),
                'resend_for_recheck' => $this->flowService->resendToLower($amendment, $request),
            };

            $message = match ($request->action) {
                'approve' => 'Amendment approved successfully.',
                'reject' => 'Amendment rejected.',
                'revert' => 'Amendment reverted to previous level.',
                'resend_for_recheck' => 'Application sent back for recheck.',
            };

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()], 500);
        }
    }
    public function history($amendmentId)
    {

        $amendment = AmendmentSociety::findOrFail($amendmentId);
        // return $amendment;

        $history = $amendment->flows()->with(['fromUser', 'toUser'])->get();

        $app = AmendmentSociety::with('society_details:id,society_name')
            // ->select('id', 'created_at')
            ->find($amendmentId);

        return view('amendment.partials.history', compact('history', 'app'));
    }

    public function edit($id)
    {
        $amendment = AmendmentSociety::findOrFail($id);

        $societyId = $amendment->name;

        $societyDetails = SocietyRegistration::findOrFail($societyId);

        $socity_details = SocietyRegistration::all();

        $managingCommittee = ManagingCommitte::where('society_id', $amendment->id)->first();
        $aamSabhaMeeting = AamSabhaMeeting::where('society_id', $amendment->id)->first();
        $votingOnAmendments = VotingOnAmendments::where('society_id', $amendment->id)->first();
        $districts = District::orderBy('name', 'ASC')->get();
        $blocks = Block::where('district_id', $amendment->district)->orderBy('name', 'ASC')->get();
        return view('amendment.social_amendment', compact(
            'amendment',
            'societyDetails',
            'socity_details',
            'managingCommittee',
            'aamSabhaMeeting',
            'votingOnAmendments',
            'districts',
            'blocks'
        ));
    }
}
