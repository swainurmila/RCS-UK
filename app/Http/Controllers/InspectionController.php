<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\District;
use App\Models\FinancialYear;
use App\Models\Inspection;
use App\Models\SocietyRegistration;
use App\Models\SocietyType;
use App\Models\User;
use App\Models\Role;
use App\Models\SocietyAppDetail;
use App\Models\InspectionTarget;
use App\Models\InspectionTargetFlow;
use App\Models\InspectionTargetSociety;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Auth;

class InspectionController extends Controller
{
    public function show_dashboard()
    {
        $dashboard_data = [];
        // $amendments = AmendmentSociety::all()->groupBy('status');
        // $dashboard_data['total_app'] = $amendments->flatten();
        // $dashboard_data['total_pending'] = $amendments->get(1, collect());
        // $dashboard_data['total_approved'] = $amendments->get(2, collect());
        // $dashboard_data['total_rejected'] = $amendments->get(3, collect());

        return view('inspection.dashboard', compact('dashboard_data'));
    }

    public function createInspection(Request $request)
    {
        $data['financial_year'] = FinancialYear::all();
        $data['society_type'] = SocietyType::all();
        $data['district'] = District::all();
        $data['block'] = Block::all();
        $data['society'] = SocietyRegistration::all();
        $data['inspector'] = User::where('role_id', 10)->get();
        $data['authority'] = User::whereIn('role_id', ['3', '4', '5'])->get();

        // $existingInspections = Inspection::select('society_id', 'financial_year', 'inspection_month')->get();

        /* $allSocieties = SocietyRegistration::all();
        if ($request->has('financial_year') && $request->has('inspection_month')) {
            return $filteredSocieties = $allSocieties->reject(function ($society) use ($existingInspections, $request) {
                return $existingInspections->contains(function ($inspection) use ($society, $request) {
                    return $inspection->society_id == $society->id &&
                        $inspection->financial_year == $request->financial_year &&
                        $inspection->inspection_month == $request->inspection_month;
                });
            });
        } else {
            $filteredSocieties = $allSocieties;
        }
        $data['society'] = $filteredSocieties; */

        return view('inspection.inspection34.create', $data);
    }

    public function indexInspection()
    {
        return view('inspection.inspection34.index');
    }


    public function storeInspection(Request $request)
    {
        try {
            $request->validate([
                'financial_year_id' => 'required|exists:financial_years,id',
                'inspection_month'  => 'required',
                'district_id'       => 'required|exists:districts,id',
                'block_id'          => 'required|exists:blocks,id',
                'society_type'      => 'required|exists:society_type,id',
                'society_id'        => 'required',
                'officer_id'        => 'required',
                'upload_inspection' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // max 2MB
                'remark'            => 'required'
            ]);

            $inspection = new Inspection();
            $inspection->financial_year = $request->financial_year_id;
            $inspection->inspection_month = $request->inspection_month;
            $inspection->district_id = $request->district_id;
            $inspection->block_id = $request->block_id;
            $inspection->society_type = $request->society_type;
            $inspection->society_id = $request->society_id;
            $inspection->assign_officer_id = $request->officer_id;
            $inspection->remarks = $request->remark;
            // $inspection->submitted_to_role = 'arcs';
            // $inspection->current_role = 'arcs';

            if ($request->hasFile('upload_inspection')) {
                $inspection_file_path = $request->file('upload_inspection')->store('inspections', 'public');
                $inspection->upload_inspection = $inspection_file_path;
            }
            return $inspection;
            $inspection->save();

            return redirect()->route('inspection-index')->with('success', 'Section 34 Inspection Created Successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function getInspectionList(Request $request)
    {
        if ($request->ajax()) {
            $inspection = Inspection::all();
            return Datatables::of($inspection)
                ->addIndexColumn()
                ->addColumn('financial_year', function ($row) {
                    $financial_year = FinancialYear::select('financial_year')->where('id', $row->financial_year)->first();
                    if (!empty($financial_year->financial_year)) {
                        return @$financial_year->financial_year;
                    }
                })

                ->addColumn('inspection_month', function ($row) {
                    if (!empty($row->inspection_month)) {
                        return \Carbon\Carbon::create()->month($row->inspection_month)->format('F');
                    }
                    return 'NA';
                })

                ->addColumn('district_name', function ($row) {
                    $district = District::select('name')->where('id', $row->district_id)->first();
                    if (!empty($district->name)) {
                        return @$district->name;
                    }
                })

                ->addColumn('block_name', function ($row) {
                    $block = Block::select('name')->where('id', $row->block_id)->first();
                    if (!empty($block->name)) {
                        return @$block->name;
                    }
                })

                ->addColumn('society_type', function ($row) {
                    $societyType = SocietyType::select('type')->where('id', $row->society_type)->first();
                    if (!empty($societyType->type)) {
                        return @$societyType->type;
                    }
                })

                ->addColumn('society_name', function ($row) {
                    $society_name = SocietyRegistration::select('society_name')->where('id', $row->society_id)->first();
                    if (!empty($society_name->society_name)) {
                        return @$society_name->society_name;
                    }
                })

                ->addColumn('officer_name', function ($row) {
                    $society_name = User::select('name')->where('id', $row->assign_officer_id)->first();
                    if (!empty($society_name->name)) {
                        return @strtoupper($society_name->name);
                    }
                })

                ->addColumn('upload_inspection', function ($row) {
                    if (!empty($row->upload_inspection)) {
                        // $fileUrl = asset('storage/' . $row->upload_inspection);
                        return '<a href="javascript:void(0);" onclick="viewAttachment(\'' . asset('storage/' . $row->upload_inspection) . '\')"><i class="fa fa-eye"></i> View</a>';

                        /*  return '<a href="' . $fileUrl . '" target="_blank" title="View File">
                                    <i class="fa fa-eye"></i>View
                                </a>'; */
                    }
                    return '-';
                })

                ->addColumn('action', function ($row) {
                    $financial_year = FinancialYear::where('id', $row->financial_year)->first();
                    $society = SocietyRegistration::where('id', $row->society_id)->first();
                    $district = District::where('id', $row->district_id)->first();
                    $block = Block::where('id', $row->block_id)->first();
                    $user = User::where('id', $row->submitted_to_user_id)->first();
                    $officer = User::where('id', $row->assign_officer_id)->first();
                    $societyType = SocietyType::where('id', $row->society_type)->first();
                    $month = \Carbon\Carbon::create()->month($row->inspection_month)->format('F');


                    $btn = '<a href="javascript:void(0)" class="btn btn-outline-info btn-sm ViewInspectionDetails" title="view" data-financial_year="' . ($financial_year ? $financial_year->financial_year : 'NA') . '" data-inspection_month="' . ($month ? $month : 'NA') . '"  data-society_type="' . ($societyType ? $societyType->type : 'NA') . '" data-upload_inspection="' . ($row->upload_inspection ? $row->upload_inspection : 'NA') . '" data-district="' . ($district ? $district->name : 'NA') . '" data-block="' . ($block ? $block->name : 'NA') . '" data-society="' . ($society ? $society->society_name : 'NA') . '" data-submitted_to_role="' . ($row->submitted_to_role ? $row->submitted_to_role : 'NA') . '" data-submitted_to_user_id="' . ($user ? $user->name : 'NA') . '" data-current_role="' . ($row->current_role ? $row->current_role : 'NA') . '" data-remark="' . ($row->remarks ? $row->remarks : 'NA') . '" data-officer="' . ($officer ? strtoupper($officer->name) : 'NA') . '"><span class="fa fa-eye"></span></a>';

                    if (complaint_app_role()) {
                        // $showAction = ($row->submitted_to_user_id === null && $row->current_role === $row) ||
                        //     ($row->submitted_to_user_id == Auth::id());

                        // if ($showAction) {
                        $btn .= '<button class="btn btn-sm btn-outline-primary" 
                                onclick="RemarkModal(' . $row->id . ', \'' . $row->current_role . '\')">
                                Take Action</button>';
                        // }
                    }

                    $btn .= '<button class="btn btn-outline-info btn-sm view-history-btn" 
                        data-bs-toggle="modal" data-bs-target="#inspectionModal"
                        data-id="' . $row->id . '"><i class="fas fa-history"></i></button>';

                    // $status = $row->status;
                    // if ($status == 3) {
                    // $btn .= '<a href="' . route('edit-inspection', ['id' => Crypt::encryptString($row->id)]) . '"><button class="btn btn-outline-info btn-sm"><span class="fa fa-edit"></span></button></a>';
                    // }
                    return $btn;
                })

                ->rawColumns(['action', 'upload_inspection'])
                ->make(true);
        }
    }

    public function editInspection($id)
    {
        $encryptId = Crypt::decryptString($id);
        $data['inspection'] = Inspection::where('id', $encryptId)->first();
        $data['financial_year'] = FinancialYear::all();
        $data['society_type'] = SocietyType::all();
        $data['district'] = District::all();
        $data['block'] = Block::all();
        $data['societies'] = SocietyRegistration::all();
        return view('inspection.inspection34.edit', $data);
    }

    public function updateInspection(Request $request, $id)
    {
        try {
            $inspectionId = Crypt::decryptString($id);
            $inspection = Inspection::findOrFail($inspectionId);

            $request->validate([
                'financial_year_id' => 'required|exists:financial_years,id',
                'inspection_month'  => 'required',
                'district_id'       => 'required|exists:districts,id',
                'block_id'          => 'required|exists:blocks,id',
                'society_type'      => 'required|exists:society_type,id',
                'society_id'        => 'required',
                'upload_inspection' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // max 2MB
            ]);

            $inspection->financial_year = $request->financial_year_id;
            $inspection->inspection_month = $request->inspection_month;
            $inspection->district_id = $request->district_id;
            $inspection->block_id = $request->block_id;
            $inspection->society_type = $request->society_type;
            $inspection->society_id = $request->society_id;

            // Update file if new one is provided
            if ($request->hasFile('upload_inspection')) {
                // Optional: delete the old file
                if ($inspection->upload_inspection && Storage::disk('public')->exists($inspection->upload_inspection)) {
                    Storage::disk('public')->delete($inspection->upload_inspection);
                }

                $inspection_file_path = $request->file('upload_inspection')->store('inspections', 'public');
                $inspection->upload_inspection = $inspection_file_path;
            }
            $inspection->save();

            return redirect()->route('inspection-index')->with('success', 'Section 34 Inspection Updated Successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function history(Inspection $inspection)
    {
        $history = $inspection->flows()->with(['fromUser', 'toUser'])->get();
        $app = $inspection->load('society_details:id,society_name,applied_on');
        return view('inspection.inspection34.history', compact('history', 'app'));
    }

   public function inspectionRecords()
    {
        $data['district'] = District::all();
        $data['roleId'] = Auth::user()->role_id;

        $query = InspectionTarget::with('districtName', 'AssignedOfficer', 'designation', 'CreatedBy');

        if ($data['roleId'] == 5) {
            $query->whereIn('status', [1, 2, 3, 4]);
        } elseif ($data['roleId'] == 3) {
            $query->where('status', 2);
        }

        $data['target_details'] = $query->orderBy('id', 'desc')->get();

        return view('inspection.inspection_records.index', $data);
    }


    public function getOfficers(Request $request){
        // return $request;
        $role_id = Role::where('name', $request->designation)->first();
         return User::where('district_id', $request->district_id)
               ->where('role_id', $role_id->id)
               ->select('id', 'name')
               ->get();
    }
    public function getSocietyCount(Request $request)
    {
        $count = SocietyAppDetail::where('district_id', $request->district_id)
                    ->where('status', 2)
                    ->count();

        return response()->json(['count' => $count]);
    }
    public function storeTarget(Request $request)
    {
        // Validate the form data
        $request->validate([
            'dist_id' => 'required|exists:districts,id',
            'designation_id' => 'required|in:drcs,arcs',
            'assigned_officer_id' => 'required|exists:users,id',
            'society_count' => 'required|integer|min:1',
        ]);
        // return $request;
        $designation_id = Role::where('name', $request->designation_id)->first();
        try {
            $target = new InspectionTarget();
            $target->dist_id = $request->dist_id;
            $target->designation_id = $designation_id->id;
            $target->assigned_officer_id = $request->assigned_officer_id;
            $target->society_count = $request->society_count;
            $target->created_by = Auth::user()->id;

            if ($designation_id->id == 5) {
                $target->status = 1; // DRCS
            } elseif ($designation_id->id == 3) {
                $target->status = 2; // ARCS
            } else {
                $target->status = 0; // fallback or default
            }

            $target->save();

            $flow = new InspectionTargetFlow();
            $flow->inspection_target_id = $target->id;
            $flow->from_role = Auth::user()->role_id; // or 'drcs' if the logged-in user is DRCS
            $flow->from_user_id = Auth::user()->id;
            $flow->to_role = $designation_id->id;
            $flow->to_user_id = $request->assigned_officer_id;
            $flow->direction = 'forward';
            $flow->action = 'send';
            $flow->remarks = 'Target Assigned';
            $flow->is_action_taken = true;
            $flow->acted_by = Auth::id();
            $flow->save();

            return redirect()->back()->with('success', 'Inspection Target Created Successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }
    }
    public function targetHistory($targetId)
    {
        $target = InspectionTarget::with('flows.actedBy', 'districtName', 'designation', 'AssignedOfficer', 'CreatedBy')->findOrFail($targetId);
        $history = $target->flows()->latest()->get();

        return view('inspection.inspection_records.history_timeline', compact('target', 'history'));
    }
    public function getAssignedOfficer(Request $request)
    {
         //return $request;
        $districtId = $request->district_id;
        $blockId = $request->block_id;
        $designation = $request->designation;
        $role_id = Role::where('name', $designation)->first();

        // Adjust this logic based on how your officer data is stored
        $officer = User::where('district_id', $districtId)
                        ->where('block_id', $blockId)
                        ->where('role_id', $role_id->id)
                        // ->whereHas('roles', function ($query) use ($designation) {
                        //     $query->where('name', $designation);
                        // })
                        ->first();

        if ($officer) {
            return response()->json([
                'id' => $officer->id,
                'name' => $officer->name,
            ]);
        } else {
            return response()->json(['message' => 'Officer not found'], 404);
        }
    }
    public function getSocieties($district_id, $block_id)
    {
        $societies = SocietyRegistration::with('appDetail')
                    ->where('district', $district_id)
                    ->where('developement_area', $block_id)
                    ->whereHas('appDetail', function ($query) {
                        $query->where('status', 2);
                    })
                    ->select('id', 'society_name')
                    ->get();

        return response()->json($societies);
    }
    public function getSocietiesCheckbox(Request $request)
    {
        $district_id = $request->district_id;
        $block_id = $request->block_id;

       $societies = SocietyRegistration::where('district', $district_id)
            ->where('developement_area', $block_id)
            ->whereHas('appDetail', function ($query) {
                $query->where('status', 2);
            })
            ->with('inspectionStatus') // eager load full relation
            ->select('id', 'society_name')
            ->get()
            ->map(function ($society) {
                return [
                    'id' => $society->id,
                    'society_name' => $society->society_name,
                    'status' => $society->inspectionStatus->inspection_status ?? null, // ensure it works
                ];
            });


        return response()->json($societies);
    }

    public function assignInspectionSocieties(Request $request)
    {
        // return $request;
        $request->validate([
            'dist_id' => 'required|integer',
            'block_id' => 'required|integer',
            'designation_id' => 'required|string', // assuming 'arcs' or role slug
            'assigned_id' => 'required|integer',
            'society_ids' => 'required|array',
            'society_ids.*' => 'integer'
        ]);
        // return $request;
        $inspection_id = $request->parent_target_id;
        $from_designation = Auth::user()->role_id;
        $mainTarget = InspectionTarget::find($inspection_id);
        if ($mainTarget) {
            if ($from_designation == 5) {
                $mainTarget->status = 2; // DRCS
            } elseif ($from_designation == 3) {
                $mainTarget->status = 4; // ARCS
            }
            $mainTarget->save();
        }

        
        foreach ($request->society_ids as $society_id) {
            $targetSociety = new InspectionTargetSociety();
            $targetSociety->inspection_id = $inspection_id;
            $targetSociety->block_id = $request->block_id;
            $targetSociety->society_id = $society_id;
            $targetSociety->inspection_status = 1;
            $targetSociety->save();

            $flow = new InspectionTargetFlow();
            $flow->inspection_target_id = $targetSociety->id; 
            $flow->from_role = Auth::user()->role_id;
            $flow->from_user_id = Auth::user()->id;
            $flow->to_role = $request->designation_id;
            $flow->to_user_id = $request->assigned_id;
            $flow->direction = 'forward';
            $flow->action = 'send';
            $flow->remarks = 'Society Assigned';
            $flow->is_action_taken = true;
            $flow->acted_by = Auth::id();
            $flow->save();
        }

        return redirect()->back()->with('success', 'Inspection Target Updated Successfully!');
    }
    
}