<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Block;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Complaint_type;
use App\Models\District;
use App\Models\Divisions;
use App\Models\Sub_divisions;
use App\Models\Panchayat;
use App\Models\SocietyRegistration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ComplaintRequest;
use App\Models\AssignCommittee;
use App\Models\ComplaintApplicationFlow;
use App\Models\ComplaintApplicationFlowLog;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Matrix\Operators\Division;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    public function showDashboard()
    {
        $complaint_type = Complaint_type::orderBy('id', 'ASC')->get();
        $district = District::orderBy('name', 'ASC')->get();

        /* Card */
        $userId = auth()->user()->id;
        $com_count = [
            'total_comp' => Complaint::where('user_id', $userId)->count(), // Total Complaints
            'assign_comm' => Complaint::where('user_id', $userId)->where('is_member_add', 1)->count(), // Assigned Committees
            'under_review' => Complaint::where('user_id', $userId)->where('status', '!=', 2)->count(), // Under Review
            'resolved' => Complaint::where('user_id', $userId)->where('status', 2)->count(), // Resolved
        ];

        /* Pie Chart */
        $resolved = Complaint::where('user_id', $userId)->where('status', 2)->count();
        $inProgress = Complaint::where('user_id', $userId)->where('status', '!=', 2)->count();
        $pending = Complaint::where('user_id', $userId)->whereNull('submitted_to_user_id')->where('status', 1)->count();
        $assign_comm = Complaint::where('user_id', $userId)->where('is_member_add', 1)->count();
        $not_assign_comm = Complaint::where('user_id', $userId)->where('is_member_add', 0)->count();

        /* $chartData = [
            'labels' => ['Resolved', 'In Progress', 'Pending', 'Assigned Committee', 'Not Assigned Committee'],
            'data' => [$resolved, $inProgress, $pending, $assign_comm, $not_assign_comm],
        ]; */
        $total = $resolved + $inProgress + $pending + $assign_comm + $not_assign_comm;

        $chartData = [
            'labels' => ['Resolved', 'In Progress', 'Pending', 'Assigned Committee', 'Not Assigned Committee'],
            'data' => $total > 0 ? [
                round(($resolved / $total) * 100, 2),
                round(($inProgress / $total) * 100, 2),
                round(($pending / $total) * 100, 2),
                round(($assign_comm / $total) * 100, 2),
                round(($not_assign_comm / $total) * 100, 2),
            ] : [0, 0, 0, 0, 0],
        ];

        /* line Chart */
        $monthlyCounts = Complaint::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->where('user_id', auth()->id())
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('count', 'month');

        $monthlyData = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $monthlyCounts[$i] ?? 0;
        }

        $lineChartData = [
            'labels' => $months,
            'data' => $monthlyData,
        ];

        /* Bar Chart */
        $complaintTypeCounts = DB::table('complaints')
            ->join('complaint_types', 'complaints.complaint_type', '=', 'complaint_types.id')
            ->select('complaint_types.name', DB::raw('count(*) as total'))
            ->where('complaints.user_id', auth()->id())
            ->groupBy('complaint_types.name')
            ->orderBy('complaint_types.name')
            ->get();

        /* $labels = $complaintTypeCounts->pluck('name')->toArray();
        $data = $complaintTypeCounts->pluck('total')->toArray(); */
        $labels = $complaintTypeCounts->pluck('name')->toArray();
        $data = $complaintTypeCounts->pluck('total')->map(fn($val) => (int) $val)->toArray();

        $barChartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        /* Map */
        $districtComplaints = DB::table('complaints')
            ->join('districts', 'complaints.district', '=', 'districts.id')
            ->select(
                'districts.name as district_name',
                DB::raw('COUNT(complaints.id) as total_complaints'),
                DB::raw('SUM(CASE WHEN complaints.status = 2 THEN 1 ELSE 0 END) as resolved_complaints')
            )
            ->where('complaints.user_id', auth()->id())
            ->groupBy('districts.name')
            // ->orderBy('districts.name')
            ->get();

        return view('complaint.dashboard', compact('complaint_type', 'district', 'com_count', 'chartData', 'lineChartData', 'barChartData', 'districtComplaints'));
    }
    public function show_complaint()
    {
        $complaint_type = Complaint_type::orderBy('id', 'ASC')->get();
        $divisions = Divisions::orderBy('name', 'ASC')->get();
        // $sub_divisions = Sub_divisions::orderBy('name', 'ASC')->get();
        // $panchayat = Panchayat::orderBy('name', 'ASC')->get();
        $society_name = SocietyRegistration::where('auth_id', auth()->id())->get(['society_name', 'id']);
        $district = District::orderBy('name', 'ASC')->get();

        return view('complaint/addcomplaint', compact('complaint_type', 'divisions', 'society_name', 'district'));
    }
    public function listing()
    {
        return view('complaint/complaintlisting');
    }

    public function storeComplaint(ComplaintRequest $request)
    {
        // return $request;
        DB::beginTransaction();

        try {

            $pathTo = 'complaints/attachment/';
            $pathAadharTo = 'complaints/aadhar/';

            $oldDoc = null;
            $oldAadharDoc = null;

            $getFile = Helpers::fileUpload($request, 'attachment', $pathTo, 'complaint-attachment', $oldDoc);
            $getAadharFile = Helpers::fileUpload($request, 'aadhar_upload', $pathAadharTo, 'aadhar', $oldAadharDoc);

            $complaint_count = Complaint::count();
            $complaint_count++;

            $current_role = Role::where('name', $request->forward_complaint_to)->first();

            $data = [
                'com_no' => "COM#$complaint_count",
                'user_id' => auth()->id(),
                'complaint_by' => $request->complaint_by,
                'complaint_title' => $request->complaint_title,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'complaint_type' => $request->complaint_type,
                'priority' => $request->priority,
                'attachment' => $getFile,
                'district' => $request->district,
                'aadhar_upload' => $getAadharFile,
                'description' => $request->description,
                'submitted_to_role' => "jrcs",
                'forward_complaint_to' => $request->forward_complaint_to,
                'current_role' => "jrcs",
                // 'current_role' => $current_role->name,
            ];
            // return $data;
            if (Complaint::create($data)) {

                DB::commit();
                return redirect()->route('listing.complaint')->with('success', 'Complaint registered successfully.');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Unable to register Complaint.');
            }
        } catch (\Exception $e) {
            return $e;
            DB::rollBack();
            return redirect()->back()->with('error', "Something went wrong.", $e->getMessage());
        }
    }

    public function getDistrictsByDivision(Request $request)
    {
        $opts = "<option value=''>Select District</option>";
        if ($id = $request->division) {
            $districts = District::where('division_id', $id)->get();
            foreach ($districts as $d) {
                $opts .= "<option value=\"{$d->id}\">{$d->name}</option>";
            }
        }
        return response()->json(['options' => $opts]);
    }

    public function getSubdivisionsByDistrict(Request $request)
    {
        $opts = "<option value=''>Select Sub-Division</option>";
        if ($id = $request->district) {
            $subdivisions = Sub_divisions::where('district_id', $id)->get();

            foreach ($subdivisions as $s) {
                $opts .= "<option value=\"{$s->id}\">{$s->name}</option>";
            }
        }
        return response()->json(['options' => $opts]);
    }

    public function getBlocksByDistrict(Request $request)
    {
        $opts = "<option value=''>Select Block</option>";
        if ($id = $request->district) {
            $blocks = Block::where('district_id', $id)->get();
            foreach ($blocks as $b) {
                $opts .= "<option value=\"{$b->id}\">{$b->name}</option>";
            }
        }
        return response()->json(['options' => $opts]);
    }

    /* public function getSocietyByBlock(Request $request)
    {
        $opts = "<option value=''>Select Society</option>";
        if ($id = $request->block) {
            $societies = SocietyRegistration::where('developement_area', $id)
                ->whereNot('auth_id', auth()->id())
                ->whereHas('appDetail', function ($q) {
                    $q->where('status', 1);
                })
                ->get();
            foreach ($societies as $sy) {
                $opts .= "<option value=\"{$sy->id}\">{$sy->society_name}</option>";
            }
        }
        return response()->json(['options' => $opts]);
    } */

    public function getSocietyByBlock(Request $request)
    {
        $opts = "<option value=''>Select Society</option>";

        $query = SocietyRegistration::query()
            ->whereNot('auth_id', auth()->id())
            ->whereHas('appDetail', function ($q) {
                $q->where('status', 1);
            });

        // If block is provided, filter societies by block
        if ($request->filled('block')) {
            $query->where('developement_area', $request->block);
        }

        // Get societies
        $societies = $query->get();

        // Append societies to options
        foreach ($societies as $sy) {
            $opts .= "<option value=\"{$sy->id}\">{$sy->society_name}</option>";
        }

        return response()->json(['options' => $opts]);
    }

    public function getComplaintList(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $role_id = $user->role_id;
            $roleName = $user->getRoleNames()->first();

            // Base query with relationships
            $query = Complaint::with([
                'division_details',
                'district_details',
                'sub_division_details',
                'block_details',
                'society_details',
                'complaint_by_society',
                // 'getUserBlock',
                'getCommittee'
            ]);

            if ($role_id == 7) {
                $query = $query->where('user_id', auth()->id());
            } elseif (in_array($roleName, ['admin', 'superadmin'])) {
                $query = $query;
                /*  } elseif (in_array($roleName, ['registrar'])) {
                $query = $query->where('status', '>', 0); */
            } else {
                // $query = Complaint::where('id', 5)->with([
                $query = Complaint::with([
                    'division_details',
                    'district_details',
                    'sub_division_details',
                    'block_details',
                    'society_details',
                    'complaint_by_society',
                    'complaint_type_details',
                    // 'getUserBlock',
                    'getCommittee'
                ]);

                // return $query->get();

                $query = $query->where(function ($query) {
                    $query->where('submitted_to_role', auth()->user()->getRoleNames()->first())
                        ->where(function ($q) {
                            $q->whereNull('submitted_to_user_id')
                                ->orWhere('submitted_to_user_id', auth()->id());
                        })
                        ->where(function ($q) {
                            $user = auth()->user();
                            // dd($user);
                            // $society = $q->society_details;
                            $roleName = $user->getRoleNames()->first();
                            // dd($roleName);
                            if ($roleName === 'arcs') {
                                $q->where('district', $user->district_id);

                                /*  $q->whereHas('getUserBlock', function ($q2) use ($user) {
                                    $q2->where('district_id', $user->district_id);
                                    // $q2->where('developement_area', $user->block_id);
                                }); */
                                /* } elseif (in_array($roleName, ['ado', 'adco'])) {
                                // For both ado and adco
                                $q->whereHas('getCommitteeMember', function ($q2) use ($user) {
                                    // dd($q2->get());

                                    $q2->where('district', $user->district_id);
                                }); */
                            } elseif ($roleName === 'drcs') {
                                // $q->where('district', $user->district_id);
                                /* $q->whereHas('getUserBlock', function ($q2) use ($user) {
                                    $q2->where('district_id', $user->district_id);
                                }); */
                            }
                        });
                })
                    ->orWhereHas('flows', function ($q) {
                        $q->where('from_user_id', auth()->id()); // Applications the user has acted on before
                    })
                    ->with(['flows', 'society_details']);
            }


            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('complaint_date', function ($row) {
                    return $row->created_at ? date('d-m-Y', strtotime($row->created_at)) : '';
                })
                ->addColumn('complaint_type', function ($row) {
                    return optional($row->complaint_type_details)->name ?? 'NA';
                })

                ->addColumn('priority', function ($row) {
                    $priority = '';
                    if ($row->priority == '1') {
                        $priority = 'High';
                    } elseif ($row->priority == '2') {
                        $priority = 'Medium';
                    } elseif ($row->priority == '3') {
                        $priority = 'Low';
                    }
                    return @$priority;
                })

                ->addColumn('district_name', function ($row) {
                    return optional($row->district_details)->name ?? 'NA';
                })
                ->addColumn('status', function ($row) {
                    return '<span class="badge bg-' . $row->status_label["class"] . '">' . $row->status_label["text"] . ' </span>';
                })
                ->addColumn('action', function ($row) use ($roleName) {
                    $Complaint_type = Complaint_type::where('id', $row->complaint_type)->first();
                    $district = District::where('id', $row->district)->first();

                    $priority = '';
                    if ($row->priority == '1') {
                        $priority = 'High';
                    } else if ($row->priority == '2') {
                        $priority = 'Medium';
                    } else if ($row->priority == '3') {
                        $priority = 'Low';
                    }

                    $btn = '<a href="javascript:void(0)" class="btn btn-outline-info btn-sm ViewComplaintDetails me-1" title="view" data-com_no="' . ($row->com_no ? $row->com_no : 'NA') . '" data-complaint_by_society_id="' . ($row->complaint_by ? $row->complaint_by : 'NA') . '"  data-complaint_title="' . ($row->complaint_title ? $row->complaint_title : 'NA') . '" data-contact_number="' . ($row->contact_number ? $row->contact_number : 'NA') . '" data-email="' . ($row->email ? $row->email : 'NA') . '" data-description="' . ($row->description ? $row->description : 'NA') . '" data-complaint_type="' . ($Complaint_type ? $Complaint_type->name : 'NA') . '" data-priority="' . ($priority ? $priority : 'NA') . '" data-attachment="' . ($row->attachment ? $row->attachment : 'NA') . '"  data-district="' . ($district ? $district->name : 'NA') . '" data-submitted_to_role="' . ($row->submitted_to_role ? $row->submitted_to_role : 'NA') . '" data-aadhar_doc="' . ($row->aadhar_upload ? $row->aadhar_upload : 'NA') . '" ><span class="fa fa-eye"></span></a>';

                    if (complaint_app_role()) {
                        /*  $showAction = ($row->submitted_to_user_id === null && $row->current_role === $roleName) ||
                            ($row->submitted_to_user_id == Auth::id()); */
                        // $showAction = ($isUnassigned && $row->current_role === $roleName) || $isAssignedToUser;

                        $isAssignedToUser = $row->submitted_to_user_id == Auth::id();
                        $isUnassigned = $row->submitted_to_user_id === null;



                        // Show "Assign Committee" only for arcs role
                        $complaintId = $row->id;
                        $currentRole = addslashes($row->current_role);
                        $district = $row->district;
                        // $blockId = Block::where('district_id', $district)->pluck('id', 'name');
                        $blocks = Block::select('id', 'name')->where('district_id', $district)->get();
                        $blocksJson = htmlspecialchars(json_encode($blocks), ENT_QUOTES, 'UTF-8');
                        // $blockId = User::whereIn('block_id', $blockIds)->get();

                        // $district = addslashes($row->district);
                        // $blockId = null;
                        /* if ($row->getUserBlock && $row->getUserBlock->district_id == $district) {
                            $blockId = $row->getUserBlock->block_id;
                        } */

                        // $firstCommittee = $row->getCommittee->first();
                        // $user = User::where('id', $firstCommittee?->member_id)->first();

                        // if ($row->current_role === 'arcs') {
                        // dd($row->getCommittee)->status;

                        // dd(Auth::id());

                        if (auth()->user()->hasRole('arcs')) {
                            if ($row->submitted_to_user_id === null && $row->is_member_add == 1) {
                                // return 15;
                                /* $btn .= '<button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                onclick="AssignCommitteeModal(' . $complaintId . ', \'' . $currentRole . '\', \'' . $district . '\', \'' . $blockId . '\')">
                                Assign Committee</button>'; */
                                $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="RemarkModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                                Take Action</button>';
                            } else {

                                if ($row->submitted_to_user_id == Auth::id() && optional($row->getCommittee)->pluck('member_id')->contains(Auth::id())) {
                                    // return 45;
                                    if ($row->current_role === 'arcs' && $row->status == 5  && $row->submitted_to_user_id == Auth::id()) {
                                        // return 48;
                                        $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                            onclick="FRModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                            Forward/Resolve</button>';
                                    }
                                    // Only show "Take Action" if user is in committee
                                    if (optional($row->getCommittee)->pluck('member_id')->contains(Auth::id())) {
                                        // return 79;
                                        if ($row->status != 5 && $row->status != 2) {
                                            $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="RemarkModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                                Take Action</button>';
                                        }
                                    } else {
                                        // return 89;
                                        /* $btn .= '<button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                            onclick="AssignCommitteeModal(' . $complaintId . ', \'' . $currentRole . '\', \'' . $district . '\', \'' . $blockId . '\')">
                                            Assign Committee</button>'; */
                                        $btn .= '<button type="button" class="btn btn-sm btn-outline-primary me-1" 
            onclick="AssignCommitteeModal(' . $complaintId . ', \'' . $currentRole . '\', \'' . $district . '\', JSON.parse(\'' . $blocksJson . '\'))">
            Assign Committee</button>';
                                    }
                                } else {
                                    // dd($row->getCommittee);
                                    $status = optional($row->getCommittee)->pluck('status');
                                    // dd($status);
                                    if ($status->contains(2)) {
                                        // return 95;
                                        $btn = "";
                                    } elseif ($row->is_member_add == 1) {
                                        $btn = "";
                                    } else {
                                        // return 47;
                                        /* $btn .= '<button type="button" class="btn btn-sm btn-outline-primary me-1" 
                                        onclick="AssignCommitteeModal(' . $complaintId . ', \'' . $currentRole . '\', \'' . $district . '\', \'' . $blockId . '\')">
                                        Assign Committee</button>'; */
                                        $btn .= '<button type="button" class="btn btn-sm btn-outline-primary me-1" 
            onclick="AssignCommitteeModal(' . $complaintId . ', \'' . $currentRole . '\', \'' . $district . '\', JSON.parse(\'' . $blocksJson . '\'))">
            Assign Committee</button>';
                                    }
                                }
                            }
                        } else {
                            // dd($row);
                            if ($row->current_role !== 'arcs') {
                                $flow = $row->getCommittee->firstWhere('current_role', 'jrcs');

                                $validRoles = [
                                    'jrcs'         => 1, // special case handled below
                                    'arcs'         => 5,
                                    'drcs'         => 6,
                                    'additionalrcs' => 7,
                                    'registrar'    => 8,
                                ];

                                if (
                                    isset($validRoles[$row->current_role]) &&
                                    $flow &&
                                    $row->status == $validRoles[$row->current_role] &&
                                    $row->submitted_to_user_id == Auth::id()
                                ) {
                                    $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                            onclick="FRModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                            Forward/Resolve</button>';
                                } elseif (
                                    $row->current_role === 'jrcs' &&
                                    $flow &&
                                    $row->submitted_to_user_id == Auth::id() &&
                                    $row->status != 2
                                ) {
                                    $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                            onclick="FRModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                            Forward/Resolve</button>';
                                    /*  } elseif ($row->current_role === 'jrcs' && $row->submitted_to_user_id === null) {
                                    $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="ForwardModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                                Take Forword</button>'; */
                                } else {

                                    $showAction = ($isUnassigned && $row->current_role === $roleName) || $isAssignedToUser;
                                    // return 125;
                                    if ($showAction) {
                                        if ($row->status != 2) {
                                            $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="RemarkModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                                Take Action</button>';
                                        }
                                    }
                                }
                            }
                        }
                    }



                    $btn .= '<button class="btn btn-outline-info btn-sm view-history-btn me-1" 
                        data-bs-toggle="modal" data-bs-target="#historyModal"
                        data-id="' . $row->id . '"><i class="fas fa-history"></i></button>';

                    $status = $row->status;
                    if ($status == 10) {
                        $btn .= '<a href="' . route('edit-complaint', ['id' => Crypt::encryptString($row->id)]) . '"><button class="btn btn-outline-info btn-sm me-1"><span class="fa fa-edit"></span></button></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function editComplaint($id)
    {
        $encryptId = Crypt::decryptString($id);
        $data['complaint_data'] = Complaint::where('id', $encryptId)->first();
        $data['society_by'] = SocietyRegistration::select('id', 'society_name')->where('auth_id', auth()->id())->get();
        $data['complaint_type'] = Complaint_type::orderBy('name', 'ASC')->get();
        $data['divisions'] = Divisions::orderBy('name', 'ASC')->get();
        return view('complaint.edit', $data);
    }


    public function updateComplaint(Request $request, $id)
    {
        $complaintId = Crypt::decryptString($id);
        $complaint = Complaint::findOrFail($complaintId);

        $validated = $request->validate([
            'complaint_by_society' => 'required|exists:society_details,id',
            'complaint_name' => 'required|string',
            'complaint_title' => 'required|string',
            'contact_number' => 'required|numeric|min:10',
            'email' => 'nullable|email',
            'complaint_type' => 'required',
            'priority' => 'required',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:500',
            'division' => 'nullable',
            'district' => 'nullable',
            'sub_division' => 'nullable',
            'block' => 'nullable',
            'society' => 'required',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $pathTo = 'complaints/attachment/';

            $oldDoc = $complaint->attachment ?? null;

            if ($request->hasFile('attachment')) {
                $getFile = Helpers::fileUpload($request, 'attachment', $pathTo, 'complaint-attachment', $oldDoc);
            } else {
                $getFile = $oldDoc;
            }

            $complaint->update([
                'user_id' => auth()->id(),
                'complaint_by_society_id' => $request->complaint_by_society,
                'complaint_name' => $request->complaint_name,
                'complaint_title' => $request->complaint_title,
                'contact_number' => $request->contact_number,
                'email' => $request->email,
                'complaint_type' => $request->complaint_type,
                'priority' => $request->priority,
                'attachment' => $getFile,
                'division' => $request->division,
                'district' => $request->district,
                'sub_division' => $request->sub_division,
                'block' => $request->block,
                'society' => $request->society,
                'description' => $request->description,
                'status' => 1,
                'submitted_to_role' => "arcs",
                'current_role' => "arcs",
            ]);

            DB::commit();
            return redirect()->route('listing.complaint')->with('success', 'Complaint updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function getUsersByRole(Request $request)
    {
        $roleName = $request->role;
        $district = $request->district;
        // $block = $request->block;

        $blockJson = $request->block;

        // Decode the JSON string into PHP array of objects
        $blockArray = json_decode($blockJson);

        if (is_array($blockArray)) {
            // Extract block IDs from the objects
            $blockIds = array_map(fn($b) => $b->id, $blockArray);
        } else {
            // If decoding fails, fallback to empty array to avoid errors
            $blockIds = [];
        }

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            return response()->json([]);
        }
        if ($roleName === 'arcs') {
            $users = User::where('role_id', $role->id)->where('district_id', $district)->select('id', 'name')->get();
        } elseif (in_array($roleName, ['ado', 'adco'])) {
            // $blockIds = is_array($block) ? $block : explode(',', $block);
            $users = User::where('role_id', $role->id)->whereIn('block_id', $blockIds)->select('id', 'name', 'block_id')->get();
        } else {
            $users = collect();
        }

        return response()->json($users);
    }

    public function assignCommitteeMember(Request $request)
    {
        // return $request;
        try {
            $request->validate([
                'complaintid'    => 'required|integer|exists:complaints,id',
                'currentrole'    => 'required',
                'district_id'    => 'required|integer',
                // 'block_id'       => 'required|integer',
                'designation'    => 'required|array|min:1',
                'designation.*'  => 'required|string',
                'member_name'    => 'required|array|min:1',
                'member_name.*'  => 'required|exists:users,id',
            ]);


            DB::transaction(function () use ($request) {
                foreach ($request->designation as $index => $roleName) {
                    $memberId = $request->member_name[$index];

                    $blockUser = User::find($memberId);

                    if (!$blockUser) {
                        throw new \Exception("User with id {$memberId} not found.");
                    }

                    AssignCommittee::create([
                        'complaint_id' => $request->complaintid,
                        'current_role' => strtolower($request->currentrole),
                        'district_id'  => $request->district_id,
                        'block_id'     =>  (int)$blockUser->block_id,
                        // 'block_id'     => $request->block_id,
                        'designation'  => $roleName,
                        'member_id'    => $memberId,
                    ]);
                }

                $com = Complaint::findOrFail($request->complaintid);
                $com->status = 3;
                $com->is_member_add = 1;
                $com->save();

                ComplaintApplicationFlow::create([
                    'complaint_id' => $request->complaintid,
                    'from_role'    => $request->currentrole,
                    'to_role'      => 'committeemember',
                    'from_user_id' => auth()->id(),
                    'direction'    => 'forward',
                    'action'       => 'verification',
                    'acted_by'     => auth()->id(),
                    'is_action_taken' => true,
                ]);

                ComplaintApplicationFlowLog::create([
                    'complaint_id'        => $request->complaintid,
                    'action_type'         => 'approve',
                    'old_value'           => 0,
                    'new_value'           => 1,
                    'performed_by_role'   => strtolower($request->currentrole),
                    'performed_by_user'   => auth()->id(),
                ]);
            });



            return back()->with('success', 'All committee members assigned successfully.');
        } catch (\Exception $e) {
            return $e;
            \Log::error('Error assigning committee members', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function committeeList(Request $request)
    {
        if ($request->ajax()) {
            $data = AssignCommittee::with('getCommitteeMember.complaint_type_details', 'getUserMember')
                ->where('member_id', auth()->user()->id)
                ->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('complaint_date', function ($row) {
                    return $row->getCommitteeMember->created_at ? date('d-m-Y', strtotime($row->getCommitteeMember->created_at)) : '';
                })
                ->addColumn('complaint_type', function ($row) {
                    return optional($row->getCommitteeMember->complaint_type_details)->name ?? '';
                })
                ->addColumn('complaint_title', function ($row) {
                    return $row->getCommitteeMember->complaint_title ??  '';
                })
                ->addColumn('submitted_to_role', function ($row) {
                    return $row->getCommitteeMember->submitted_to_role ??  '';
                })
                ->addColumn('priority', function ($row) {
                    $priority = '';
                    if ($row->getCommitteeMember->priority == '1') {
                        $priority = 'High';
                    } elseif ($row->getCommitteeMember->priority == '2') {
                        $priority = 'Medium';
                    } elseif ($row->getCommitteeMember->priority == '3') {
                        $priority = 'Low';
                    }
                    return @$priority;
                })
                ->addColumn('status', function ($row) {
                    $status = '';
                    if ($row->status == '1') {
                        $status = '<span class="badge rounded-pill badge-danger text-white p-2 bg-danger">Pending</span>';
                    } elseif ($row->status == '2') {
                        $status = '<span class="badge rounded-pill badge-info text-white p-2 bg-info">Approved</span>';
                    }
                    return @$status;
                })
                ->addColumn('action', function ($row) {

                    $btn = '';

                    if ($row->status != 2) {
                        $btn .= '<button class="btn btn-sm btn-outline-primary me-1" 
                                onclick="AssignRemarkModal(' . $row->id . ', \'' . $row->current_role . '\',\'' . $row->designation . '\')">
                                Take Action</button>';
                    }

                    $btn .= '<button class="btn btn-outline-info btn-sm view-history-btn me-1" 
                        data-bs-toggle="modal" data-bs-target="#historyModal"
                        data-id="' . $row->getCommitteeMember->id . '"><i class="fas fa-history"></i></button>';

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getAuthorizedPersonName(Request $request)
    {
        $designation = $request->input('forward_to_designation');

        // Find the role where name matches the designation
        $role = Role::whereRaw('LOWER(name) = ?', [strtolower($designation)])->first();

        if ($role) {
            // Get the first user with that role_id
            $user = User::where('role_id', $role->id)->first();

            if ($user) {
                return response()->json([
                    'success' => true,
                    'authorized_person_name' => $user->name,
                    'id' => $user->id
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'authorized_person_name' => null,
            'message' => 'No user found for this designation.',
        ]);
    }

    public function filter(Request $request)
    {
        // dd($request->all());
        $query = Complaint::query();

        if ($request->filled('date_from_to')) {
            $dates = explode(' - ', $request->date_from_to);
            if (count($dates) === 2) {
                $start = Carbon::createFromFormat('d M, Y', trim($dates[0]))->startOfDay();
                $end = Carbon::createFromFormat('d M, Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            }
        }

        if ($request->filled('complaint_type')) {
            $query->where('complaint_type', $request->complaint_type);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('priority_type')) {
            $query->where('priority', $request->priority_type);
        }

        if ($request->filled('forward_to')) {
            $query->where('submitted_to_role', $request->forward_to);
        }

        $filteredComplaints = $query->get();

        /* Card */
        $com_count = [
            'total_comp' => $filteredComplaints->count(), // Total Complaints
            'assign_comm' => $filteredComplaints->where('is_member_add', 1)->count(), // Assigned Committees
            'under_review' => $filteredComplaints->where('status', '!=', 2)->count(), // Under Review
            'resolved' => $filteredComplaints->where('status', 2)->count(), // Resolved
        ];

        /* Pie Chart */
        $resolved = $filteredComplaints->where('status', 2)->count();
        $inProgress = $filteredComplaints->where('status', '!=', 2)->count();
        $pending = $filteredComplaints->whereNull('submitted_to_user_id')->where('status', 1)->count();
        $assign_comm = $filteredComplaints->where('is_member_add', 1)->count();
        $not_assign_comm = $filteredComplaints->where('is_member_add', 0)->count();

        $total = $resolved + $inProgress + $pending + $assign_comm + $not_assign_comm;

        $chartDataPie = [
            'labels' => ['Resolved', 'In Progress', 'Pending', 'Assigned Committee', 'Not Assigned Committee'],
            'data' => $total > 0 ? [
                round(($resolved / $total) * 100, 2),
                round(($inProgress / $total) * 100, 2),
                round(($pending / $total) * 100, 2),
                round(($assign_comm / $total) * 100, 2),
                round(($not_assign_comm / $total) * 100, 2),
            ] : [0, 0, 0, 0, 0],
        ];

        /* line Chart */
        $monthlyCounts = $filteredComplaints->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->format('n');
        })->map(function ($group) {
            return $group->count();
        });

        $monthlyData = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $monthlyCounts[$i] ?? 0;
        }

        $chartDataLine = [
            'labels' => $months,
            'data' => $monthlyData,
        ];

        /* Bar Chart */
        $complaintTypeCounts = $filteredComplaints->groupBy('complaint_type')->map(function ($group) {
            return $group->count();
        });

        $complaintTypeNames = Complaint_type::whereIn('id', $complaintTypeCounts->keys())->pluck('name', 'id');
        $labels = [];
        $data = [];

        foreach ($complaintTypeCounts as $typeId => $count) {
            $labels[] = $complaintTypeNames[$typeId] ?? 'Unknown';
            $data[] = (int) $count;
        }

        $chartDataBar = [
            'labels' => $labels,
            'data' => $data,
        ];

        /* Map */
        $districtGrouped = $filteredComplaints->groupBy('district')->map(function ($group) {
            return [
                'total_complaints' => $group->count(),
                'resolved_complaints' => $group->where('status', 2)->count(),
            ];
        });

        $districtNames = District::whereIn('id', $districtGrouped->keys())->pluck('name', 'id');
        $mapData = [];
        foreach ($districtGrouped as $districtId => $counts) {
            $mapData[] = [
                'district_name' => $districtNames[$districtId] ?? 'Unknown',
                'total_complaints' => $counts['total_complaints'],
                'resolved_complaints' => $counts['resolved_complaints'],
            ];
        }

        // return $mapData;

        return response()->json([
            'stats' => $com_count,
            'chartData' => [
                'pie' => $chartDataPie,
                'line' => $chartDataLine,
                'bar' => $chartDataBar,
            ],
            'mapData' => $mapData,
        ]);
    }

    public function forwardAction(Request $request)
    {
        // return $request;
        try {
            $request->validate([
                'frcomplaint_id'    => 'required|integer|exists:complaints,id',
                'frcurrent_role'    => 'required',
                'forwartdSelect'    => 'required',
            ]);

            DB::transaction(function () use ($request) {
                $com = Complaint::findOrFail($request->frcomplaint_id);
                $com->status = 9;
                $com->submitted_to_role = $request->forwartdSelect;
                $com->current_role = $request->forwartdSelect;
                $com->save();

                ComplaintApplicationFlow::create([
                    'complaint_id' => $request->frcomplaint_id,
                    'from_role'    => $request->frcurrent_role,
                    'to_role'      => $request->forwartdSelect,
                    'from_user_id' => auth()->id(),
                    'direction'    => 'forward',
                    'action'       => 'verification',
                    'acted_by'     => auth()->id(),
                    'is_action_taken' => true,
                ]);

                ComplaintApplicationFlowLog::create([
                    'complaint_id'        => $request->frcomplaint_id,
                    'action_type'         => 'approve',
                    'old_value'           => 0,
                    'new_value'           => 1,
                    'performed_by_role'   => strtolower($request->frcurrent_role),
                    'performed_by_user'   => auth()->id(),
                ]);
            });

            return back()->with('success', 'Forward successfully.');
        } catch (\Exception $e) {
            return $e;
            \Log::error('Error Forward', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'An error occurred. Please try again.');
        }
    }
}