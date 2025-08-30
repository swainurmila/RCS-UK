<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Block;
use App\Models\SocietyType;
use App\Models\Inspector;
use App\Models\SocietyRegistration;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class InquiryController extends Controller
{
    public function show_inquiry_form()
    {
        $districts = District::all();
        $blocks = Block::all();
        $society_types = ['Primary', 'Central', 'Apex'];
        $inspectors = Inspector::all();
        $societys = SocietyRegistration::all();
    
        return view('inspection.inquiry_form', compact('districts', 'blocks', 'society_types', 'inspectors', 'societys'));
    }

    public function getBlocksByDistrict($district_id)
    {
        $blocks = Block::where('district_id', $district_id)->get();
        return response()->json($blocks);
    }

    public function getSocietyByDistrictBlockCategory(Request $request)
    {
        $request->validate([
            'district_id' => 'required|integer',
            'block_id' => 'required|integer',
            'society_category' => 'required|integer'
        ]);
    
        return SocietyRegistration::where('district', $request->district_id)
            ->where('developement_area', $request->block_id)
            ->where('society_category', $request->society_category)
            ->select('id', 'society_name')
            ->get();
    }


    public function storeSection35(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_id' => 'required|exists:districts,id|not_in:0',
            'block_id' => 'required|exists:blocks,id|not_in:0',
            'society_type' => 'required|in:Primary,Central,Apex',
            'society_id' => 'required|exists:society_details,id|not_in:0',
            'inspector_id' => 'required|exists:inspectors,id|not_in:0',
            'remarks' => 'required|string',
            'inquiry_file' => 'required|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }
    
        // Map society type to category ID
        $categoryMap = [
            'Primary' => 1,
            'Central' => 2,
            'Apex' => 3
        ];
        $categoryId = $categoryMap[$request->society_type];
    
        // Store the file
        $filePath = null;
        if ($request->hasFile('inquiry_file')) {
            $filePath = $request->file('inquiry_file')->store('inquiries', 'public');
        }
    
        // Save data to inquiries table
        Inquiry::create([
            'district_id' => $request->district_id,
            'block_id' => $request->block_id,
            'society_type' => $categoryId, // Store the ID instead of string
            'society_id' => $request->society_id,
            'inspector_id' => $request->inspector_id,
            'remarks' => $request->remarks,
            'inquiry_file' => $filePath,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Inquiry submitted successfully.',
        ]);
    }

    
public function getSocietyNameById($id)
{
    // Get all societies with the given society_category ID
    $societies = SocietyRegistration::where('society_category', $id)->get();

  

    if ($societies->isEmpty()) {
        return response()->json([
            'message' => 'No societies found for this category.'
        ], 404);
    }

    // Map to only return the relevant fields (e.g., name and id)
    $result = $societies->map(function ($society) {
        return [
            'id' => $society->id,
            'society_name' => $society->society_name // or $society->society_name
        ];
    });

    // dd($result);

    return response()->json($result);
}

public function section35Index(){
    return view('inspection.inquiry_form_list');
}


public function showInquiriesList(Request $request)
{
    if ($request->ajax()) {
        $inquiries = Inquiry::with(['district', 'block', 'society', 'inspector'])
            ->select([
                'id',
                'district_id',
                'block_id',
                'society_type',
                'society_id',
                'inspector_id',
                'inquiry_file',
                'remarks',
                'created_at'
            ]);
        
        return DataTables::of($inquiries)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex', function ($row) {
                return $row->id;
            })
            ->addColumn('district_name', function ($row) {
                return $row->district ? $row->district->name : 'NA';
            })
            ->addColumn('block_name', function ($row) {
                return $row->block ? $row->block->name : 'NA';
            })
            ->addColumn('society_type', function ($row) {
                return $row->society_type ?: 'NA';
            })
            ->addColumn('society_name', function ($row) {
                return $row->society ? $row->society->society_name : 'NA';
            })
            ->addColumn('inspector_name', function ($row) {
                return $row->inspector ? $row->inspector->name : 'NA';
            })
            ->addColumn('inquiry_file', function ($row) {
               /*  if ($row->inquiry_file) {
                    return '<a href="javascript:void(0)" class="view-file" 
                            data-file="'.asset('storage/'.$row->inquiry_file).'">
                            <i class="fa fa-eye"></i> View
                        </a>';
                }
                return 'NA'; */
                if (!empty($row->inquiry_file)) {
                    $fileUrl = asset('storage/' . $row->inquiry_file);
                    return '<a href="' . $fileUrl . '" target="_blank" title="View File">
                                <i class="fa fa-eye"></i>
                            </a>';
                }
                return '-';
            })
            ->addColumn('remarks', function ($row) {
                return $row->remarks ? Str::limit($row->remarks, 50) : 'NA';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" class="btn btn-outline-info btn-sm view-inquiry" 
                        title="View" 
                        data-district="'.($row->district ? $row->district->name : 'NA').'" 
                        data-block="'.($row->block ? $row->block->name : 'NA').'" 
                        data-society_type="'.($row->society_type ?: 'NA').'" 
                        data-society_name="'.($row->society ? $row->society->society_name : 'NA').'" 
                        data-inspector="'.($row->inspector ? $row->inspector->name : 'NA').'"
                        data-inquiry_file="'.($row->inquiry_file ?: '').'" 
                        data-remarks="'.($row->remarks ?: 'NA').'">
                        <span class="fa fa-eye"></span>
                    </a>';
                
                    $btn .= '<a href="'.route('edit-inquiry', ['id' => Crypt::encryptString($row->id)]).'" 
                    class="btn btn-outline-primary btn-sm ms-1">
                    <span class="fa fa-edit"></span>
                </a>';
                
                return $btn;
            })
            ->rawColumns(['inquiry_file', 'action'])
            ->make(true);
    }
    
}

public function editInquiry($id)
{
    try {
        $decryptedId = Crypt::decryptString($id);
        $inquiry = Inquiry::with(['district', 'block', 'society', 'inspector'])->findOrFail($decryptedId);
        
        $districts = District::all();
        $blocks = Block::where('district_id', $inquiry->district_id)->get();
        $society_types = ['Primary', 'Central', 'Apex'];
        $inspectors = Inspector::all();
        
        // Map society_type ID back to text
        $typeMap = [
            1 => 'Primary',
            2 => 'Central',
            3 => 'Apex'
        ];
        $current_society_type = $typeMap[$inquiry->society_type] ?? 'Primary';
        
        return view('inspection.edit_inquiry', compact(
            'inquiry',
            'districts',
            'blocks',
            'society_types',
            'inspectors',
            'current_society_type'
        ))->with('id', $id);
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid inquiry ID');
    }
}

public function updateInquiry(Request $request, $id)
{
    try {
        $decryptedId = Crypt::decryptString($id);
        $inquiry = Inquiry::findOrFail($decryptedId);
        
        $validator = Validator::make($request->all(), [
            'district_id' => 'required|exists:districts,id|not_in:0',
            'block_id' => 'required|exists:blocks,id|not_in:0',
            'society_type' => 'required|in:Primary,Central,Apex',
            'society_id' => 'required|exists:society_details,id|not_in:0',
            'inspector_id' => 'required|exists:inspectors,id|not_in:0',
            'remarks' => 'required|string',
            'inquiry_file' => 'sometimes|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }
        
        // Map society type to category ID
        $categoryMap = [
            'Primary' => 1,
            'Central' => 2,
            'Apex' => 3
        ];
        $categoryId = $categoryMap[$request->society_type];
        
        $data = [
            'district_id' => $request->district_id,
            'block_id' => $request->block_id,
            'society_type' => $categoryId,
            'society_id' => $request->society_id,
            'inspector_id' => $request->inspector_id,
            'remarks' => $request->remarks,
        ];
        
        // Update file if new one is uploaded
        if ($request->hasFile('inquiry_file')) {
            // Delete old file if exists
            if ($inquiry->inquiry_file) {
                Storage::disk('public')->delete($inquiry->inquiry_file);
            }
            $data['inquiry_file'] = $request->file('inquiry_file')->store('inquiries', 'public');
        }
        
        $inquiry->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Inquiry updated successfully.',
            'redirect_url' => route('get-inquiries-list')
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating inquiry: ' . $e->getMessage()
        ], 500);
    }
}
}