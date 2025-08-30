<?php

namespace App\Http\Controllers;

use App\Models\AreaOfOperation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SocietyRegistration;
use App\Models\MembersObjective;
use App\Models\Feasibility_reports;
use App\Models\Signature_detail;
use App\Models\Member_declaration;
use App\Models\Members;
use App\Models\SocietyAppDetail;
use App\Models\Otp;
use App\Models\District;
use App\Models\Block;
use App\Models\SocietyRegisterDocuments;
use App\Models\InspectorReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\DocumentVerificationFlow;
use App\Models\SocietySectorType;
use App\Models\Tehsil;
use App\Services\SocietyWorkflowService;

class RegisterController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:society-registration-show', ['only' => ['showSocietyRegistration']]);
    // }



    public function showregister()
    {
        $roles = Role::all();
        return view('registration', compact('roles'));
    }
    public function register(Request $request)
    {
        // return $request;
        // dd($request);
        $otpInput = is_array($request->otp) ? implode('', $request->otp) : $request->otp;
        try {
            // Validation rules
            $validator = Validator::make(array_merge($request->all(), ['otp' => $otpInput]), [
                'name' => 'required|string|max:35',
                'mob_no' => 'required|string|digits:10',
                'email' => 'nullable|string|email|max:50|unique:users',
                'password' => 'required|string|min:6|max:20',
                'confpassword' => 'required|string|same:password',
                'otp' => 'required|string|digits:4'
            ]);
            // dd($validator);
            // return $validator;
            // If validation fails, return errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if (!Session::has('latest_otp_id')) {
                return back()->with('error', 'OTP session expired. Please generate OTP again.');
            }



            $latestOtpId = decrypt(Session::get('latest_otp_id'));
            // dd(Otp::find($latestOtpId));

            $otpRecord = Otp::where('id', $latestOtpId)
                ->where('otp', $otpInput)
                ->where('status', '0') // Unused OTP
                ->where('otp_ex_time', '>=', now()) // Check if OTP is not expired
                ->first();

            if (!$otpRecord) {
                return back()->with('error', 'Invalid or expired OTP.')->withInput();
            }

            // Creating the user
            $user = User::create([
                'name' => $request->name,
                'mob_no' => $request->mob_no,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 7,
                'is_active' => 1,
            ]);
            $role = Role::find(7); // Find the role by ID
            if ($role) {
                $user->assignRole($role); // Assign the role to the user
            } else {
                throw new \Exception('Role not found.');
            }
            // Mark the OTP as used
            $otpRecord->update(['status' => '1']);

            // Clear the latest OTP ID from the session
            Session::forget('latest_otp_id');

            return redirect()->route('login.view')->with('success', 'User registered successfully. Please log in.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    // public function checkMobileExists(Request $request)
    // {
    //     $exists = User::where('mob_no', $request->mob_no)->exists();
    //     return response()->json(['exists' => $exists]);
    // }

    // public function checkEmailExists(Request $request)
    // {
    //     $exists = User::where('email', $request->email)->exists();
    //     return response()->json(['exists' => $exists]);
    // }
    public function checkMobileEmail(Request $request)
    {
        $mobileExists = User::where('mob_no', $request->mob_no)->exists();
        $emailExists = User::where('email', $request->email)->exists();

        return response()->json([
            'mobile_exists' => $mobileExists,
            'email_exists' => $emailExists
        ]);
    }
    public function saveMember(Request $request)
    {
        // return $request;
        try {
            $input_data = $request->all();
            $member_declaration_data = [
                'is_declared' => $request['is_declared'] ?? 0,
                'society_id' => $request['society_id'] ?? session()->get('societyDetailsId')
            ];
            if ($member_declaration_data['society_id']) {
                $member_declaration_id_chk = Member_declaration::where('society_id', $member_declaration_data['society_id'])->first();
                if (!empty($member_declaration_id_chk)) {
                    $member_declarationId = $member_declaration_id_chk->id;
                } else {
                    $Member_declaration = Member_declaration::create($member_declaration_data);
                    $member_declarationId = $Member_declaration->id;
                }
            }
            // // Create or update member declaration
            // if (isset($input_data['member_declarationId']) && !empty($input_data['member_declarationId'])) {
            //     $member_declarationId = (int) $input_data['member_declarationId'];
            //     unset($member_declaration_data['_token']);
            //     unset($member_declaration_data['member_declarationId']);
            //     $member_declaration_data['updated_at'] = date("Y/m/d H:i:s");
            //     Member_declaration::where('id', $member_declarationId)->update($member_declaration_data);
            // } else {
            //     $Member_declaration = Member_declaration::create($member_declaration_data);
            //     $member_declarationId = $Member_declaration->id;
            // }

            $member_data = [
                'member_declaration_id' => $member_declarationId,
                'society_id' => $request['society_id'],
                'name' => $request['name'],
                'contact_no' => $request['contact_no'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'is_married' => $request['is_married'],
                'father_spouse_name' => $request['father_spouse_name'],
                'designation' => $request['designation'],
                'buisness_name' => $request['buisness_name'] ?? null,
            ];
            // return $member_data;

            // Handle file uploads
            if ($request->hasFile('aadhar_no')) {
                $member_data['aadhar_no'] = $request->file('aadhar_no')->store('uploads/aadhaar', 'public');
            }
            if ($request->hasFile('signature')) {
                $member_data['signature'] = $request->file('signature')->store('uploads', 'public');
            }
            if ($request->hasFile('membership_form')) {
                $member_data['membership_form'] = $request->file('membership_form')->store('uploads/membership_forms', 'public');
            }
            if ($request->hasFile('declaration1')) {
                $member_data['declaration1'] = $request->file('declaration1')->store('uploads/declarations', 'public');
            }
            if ($request->hasFile('declaration2')) {
                $member_data['declaration2'] = $request->file('declaration2')->store('uploads/declarations', 'public');
            }

            // Update or create member
            $member = Members::updateOrCreate(
                ['id' => $request['member_id'] ?? null],
                $member_data
            );

            return response()->json([
                'success' => true,
                'message' => 'Member saved successfully',
                'member_id' => $member->id,
                'member_declarationId' => $member_declarationId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving member: ' . $e->getMessage()
            ], 500);
        }
    }

    public function societyRegister(Request $request)
    {
        // return $request;
        try {
            $input_data = $request->all();
            $step = $input_data['step'];
            session()->put('currentStep', $step);
            // Validation rules for each step
            // $validationRules = $this->getValidationRules($step);
            // $validatedData = $request->validate($validationRules);

            $societyAppDetailsId = "";
            if ($step == 1) {
                $society_details_data = $input_data;
                unset($society_details_data['step']);
                if (isset($input_data['society_id']) && !empty($input_data['society_id'])) {
                    // var_dump($input_data['society_id']);exit;
                    unset($society_details_data['_token']);
                    unset($society_details_data['society_id']);
                    $society_details_data['updated_at'] = date("Y/m/d H:i:s");
                    $society_details = SocietyRegistration::where('id', (int) $input_data['society_id'])->update($society_details_data);
                    // return $society_details_data;
                } else {
                    // Registering the society
                    $society_details_data['auth_id'] = @auth()->id();
                    $society_details_data['scheme_id'] = 1;
                    $society_details_data['applied_on'] = date("Y/m/d");
                    $society_details = SocietyRegistration::create($society_details_data);
                    if ($society_details->id) {
                        session()->put('societyDetailsId', $society_details->id);
                        $society_count = SocietyAppDetail::count();
                        $society_count++;
                        $society_app_details = [];
                        $society_app_details['app_no'] = "APP#$society_count";
                        $society_app_details['app_count'] = $society_count;
                        $society_app_details['app_id'] = $society_details->id;
                        $society_app_details['app_phase'] = 1;
                        $society_app_details['scheme_id'] = 1;
                        $society_app_details['user_id'] = @auth()->id();
                        $society_app_details['district_id'] = $society_details_data['district'];
                        $society_app_details['block_id'] = $society_details_data['developement_area'];
                        $society_app_details['status'] = 0; //draft
                        $societyAppDetails = SocietyAppDetail::create($society_app_details);
                        $societyAppDetailsId = $societyAppDetails->id;
                        session()->put('societyAppDetailsId', $societyAppDetailsId);
                    }
                }
                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'societyDetailsId' => (isset($input_data['society_id']) && !empty($input_data['society_id'])) ? $input_data['society_id'] : $society_details->id
                ]);
            } else if ($step == 2) {
                // Step 2: Insert data into membersobjective using the societyDetailsId from session
                $member_objective_data = $input_data;
                $member_objective_data['society_id'] = (isset($member_objective_data['society_id']) && !empty($member_objective_data['society_id'])) ? $member_objective_data['society_id'] : session()->get('societyDetailsId');
                $member_objective_data['capital_valuation_type'] = @$input_data['capital_valuation_type'] ? $input_data['capital_valuation_type'] : 0;
                $member_objective_data['capital_amount'] = @$input_data['capital_amount'] ? $input_data['capital_amount'] : 0;

                $society_secretary_signature_path = NULL;
                $society_representative_signature_path = NULL;
                if ($request->hasFile('society_secretary_signature')) {
                    if ($request->hasFile('society_secretary_signature')) {
                        $society_secretary_signature_path = $request->file('society_secretary_signature')->store('uploads', 'public');
                        $member_objective_data['society_secretary_signature'] = $society_secretary_signature_path;
                    }
                }
                if ($request->hasFile('society_representative_signature')) {
                    if ($request->hasFile('society_representative_signature')) {
                        $society_representative_signature_path = $request->file('society_representative_signature')->store('uploads', 'public');
                        $member_objective_data['society_representative_signature'] = $society_representative_signature_path;
                    }
                }

                if (isset($input_data['mobject_detailsId']) && !empty($input_data['mobject_detailsId'])) {
                    unset($member_objective_data['_token']);
                    unset($member_objective_data['mobject_detailsId']);
                    unset($member_objective_data['step']);
                    $member_objective_data['updated_at'] = date("Y/m/d H:i:s");
                    $mobject_details = MembersObjective::where('id', (int) $input_data['mobject_detailsId'])->update($member_objective_data);
                } else {
                    $mobject_details = MembersObjective::create($member_objective_data);
                }
                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'mobject_detailsId' => (isset($input_data['mobject_detailsId']) && !empty($input_data['mobject_detailsId'])) ? $input_data['mobject_detailsId'] : $mobject_details->id
                ]);
            } else if ($step == 3) {
                // This is now only called when submitting the entire step
                // $member_declaration_data = [
                //     'is_declared' => $request['is_declared'] ? 1 : 0,
                //     'society_id' => $request['society_id'] ?? session()->get('societyDetailsId')
                // ];

                // if (isset($input_data['member_declarationId']) && !empty($input_data['member_declarationId'])) {
                //     $member_declarationId = (int) $input_data['member_declarationId'];
                //     unset($member_declaration_data['_token']);
                //     unset($member_declaration_data['member_declarationId']);
                //     unset($member_declaration_data['step']);
                //     $member_declaration_data['updated_at'] = date("Y/m/d H:i:s");
                //     Member_declaration::where('id', $member_declarationId)->update($member_declaration_data);
                // } else {
                //     $Member_declaration = Member_declaration::create($member_declaration_data);
                //     $member_declarationId = $Member_declaration->id;
                // }

                // Verify minimum 7 members exist
                $memberCount = Members::where('society_id', $request['society_id'])
                    ->count();

                if ($memberCount < 7) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Minimum 7 members are required',
                        'nextStep' => $step // Stay on current step
                    ], 400);
                }

                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'member_declarationId' => $request['member_declarationId']
                ]);
            } else if ($step == 4) {
                // Step 2: Insert data into membersobjective using the societyDetailsId from session
                $feasibility_data = $input_data;
                // dd($feasibility_data);
                $feasibility_data['society_id'] = (isset($feasibility_data['society_id']) && !empty($feasibility_data['society_id'])) ? $feasibility_data['society_id'] : session()->get('societyDetailsId');
                if ($request->hasFile('authority_signature')) {
                    if ($request->hasFile('authority_signature')) {
                        $feasibility_data['authority_signature'] = $request->file('authority_signature')->store('uploads', 'public');
                    }
                }
                if (isset($feasibility_data['feasibility_reportId']) && !empty($feasibility_data['feasibility_reportId'])) {
                    unset($feasibility_data['_token']);
                    unset($feasibility_data['feasibility_reportId']);
                    unset($feasibility_data['step']);
                    $feasibility_data['updated_at'] = date("Y/m/d H:i:s");
                    $feasibility_report = Feasibility_reports::where('id', $input_data['feasibility_reportId'])->update($feasibility_data);
                } else {
                    $feasibility_report = Feasibility_reports::create($feasibility_data);
                }
                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'feasibility_reportId' => (isset($input_data['feasibility_reportId']) && !empty($input_data['feasibility_reportId'])) ? $input_data['feasibility_reportId'] : $feasibility_report->id
                ]);
                /*} else if ($step == 5) {

                $signature_data = $input_data;
                $signature_data['society_id'] = (isset($signature_data['society_id']) && !empty($signature_data['society_id'])) ? $signature_data['society_id'] : session()->get('societyDetailsId');
                if ($request->hasFile('authority_signature')) {
                    if ($request->hasFile('authority_signature')) {
                        $signature_data['authority_signature'] = $request->file('authority_signature')->store('uploads', 'public');
                    }
                }

                if (isset($input_data['signature_detailsId']) && !empty($input_data['signature_detailsId'])) {
                    unset($signature_data['_token']);
                    unset($signature_data['step']);
                    unset($signature_data['signature_detailsId']);
                    $signature_data['updated_at'] = Carbon::now();
                    $signature_details = InspectorReport::where('id', (int) $input_data['signature_detailsId'])->update($signature_data);
                } else {
                    $signature_details = InspectorReport::create($signature_data);
                }
                $signature_detailsId = (isset($input_data['signature_detailsId']) && !empty($input_data['signature_detailsId'])) ? $input_data['signature_detailsId'] : $signature_details->id;
                // dd($signature_detailsId);
                if ($signature_detailsId) {
                    $societyAppDetailsId = $signature_data['society_id'];
                    $upd = [];
                    $upd['status'] = 1;
                    $upd['submitted_to_role'] = "arcs"; // first application goes to arcs
                    $upd['current_role'] = "arcs";
                    $cutofDays = config('society_workflow.application_life_period');
                    $cutofDay = Carbon::now()->addDays($cutofDays);
                    $cutofDay = $cutofDay->toDateString();
                    $upd['cutoff_date'] = $cutofDay;
                    SocietyAppDetail::where('id', $societyAppDetailsId)->update($upd);
                }

                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'inspector_reportId' => $signature_detailsId
                ]);*/
            } else if ($step == 5) {
                $doc_data = $input_data;
                $doc_data['society_id'] = (isset($doc_data['society_id']) && !empty($doc_data['society_id'])) ? $doc_data['society_id'] : session()->get('societyDetailsId');
                if ($request->hasFile('meeting1')) {
                    $doc_data['meeting1'] = $request->file('meeting1')->store('uploads', 'public');
                }
                if ($request->hasFile('meeting2')) {
                    $doc_data['meeting2'] = $request->file('meeting2')->store('uploads', 'public');
                }
                if ($request->hasFile('meeting3')) {
                    $doc_data['meeting3'] = $request->file('meeting3')->store('uploads', 'public');
                }
                if ($request->hasFile('all_id_proof')) {
                    $doc_data['all_id_proof'] = $request->file('all_id_proof')->store('uploads', 'public');
                }
                if ($request->hasFile('all_application_form')) {
                    $doc_data['all_application_form'] = $request->file('all_application_form')->store('uploads', 'public');
                }
                if ($request->hasFile('all_declaration_form')) {
                    $doc_data['all_declaration_form'] = $request->file('all_declaration_form')->store('uploads', 'public');
                }
                if ($request->hasFile('society_by_laws')) {
                    $doc_data['society_by_laws'] = $request->file('society_by_laws')->store('uploads', 'public');
                }
                if ($request->hasFile('challan_proof')) {
                    $doc_data['challan_proof'] = $request->file('challan_proof')->store('uploads', 'public');
                }
                if (isset($input_data['doc_detailsId']) && !empty($input_data['doc_detailsId'])) {
                    unset($doc_data['_token']);
                    unset($doc_data['step']);
                    unset($doc_data['doc_detailsId']);
                    $doc_data['updated_at'] = Carbon::now();
                    $doc_details = SocietyRegisterDocuments::where('id', (int) $input_data['doc_detailsId'])->update($doc_data);
                } else {
                    $doc_details = SocietyRegisterDocuments::create($doc_data);
                }
                $doc_detailsId = (isset($input_data['doc_detailsId']) && !empty($input_data['doc_detailsId'])) ? $input_data['doc_detailsId'] : $doc_details->id;
                // dd($doc_detailsId);
                if ($doc_detailsId) {
                    $societyAppDetailsId = $doc_data['society_id'];
                    $upd = [];
                    $upd['status'] = 1;
                    $upd['submitted_to_role'] = "arcs"; // first application goes to arcs
                    $upd['current_role'] = "arcs";
                    $cutofDays = config('society_workflow.application_life_period');
                    $cutofDay = Carbon::now()->addDays($cutofDays);
                    $cutofDay = $cutofDay->toDateString();
                    $upd['cutoff_date'] = $cutofDay;
                    SocietyAppDetail::where('app_id', $societyAppDetailsId)->update($upd);
                }
                session()->forget('societyDetailsId');
                session()->forget('societyAppDetailsId');
                return response()->json([
                    'message' => "Step $step completed successfully!",
                    'nextStep' => $step + 1,
                    'doc_detailsId' => $doc_detailsId
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], status: 500);
        }
    }
    // Define validation rules for each step
    private function getValidationRules($step)
    {
        switch ($step) {
            case 1:
                return [
                    'society_name' => 'required|string|max:35',
                    'locality' => 'required|string',
                    'post_office' => 'nullable|string',
                    'developement_area' => 'required|string',
                    'tehsil' => 'required|string',
                    'district' => 'required|string',
                    'nearest_station' => 'required|string',
                    "society_category" => 'required|digits',
                    "society_sector_type_id" => 'required|digits'
                ];
            case 2:
                return [
                    // 'society_id' => 'required|digits',
                    'member_responsibility_type' => 'required|digits',
                    'capital_valuation_type' => 'required|digits',
                    'capital_amount' => 'required|digits',
                    'society_operational_area' => 'required|string',
                    'society_objective' => 'required|string',
                    'society_share_value' => 'required|digits',
                    'subscription_rate' => 'required|digits',
                    'member_liability' => 'required|string',
                    'general_member_count' => 'required|digits',
                    'society_record_language' => 'required|digits',
                    'society_representative_name' => 'required|string',
                    'society_representative_address' => 'required|string',
                    'society_representative_signature' => 'required|string',
                    'society_secretary_name' => 'required|string',
                    'society_secretary_address' => 'required|string',
                    'society_secretary_signature' => 'required|string',
                ];
            case 3:
                return [
                    // 'society_id' => 'required|digits',
                    'member_responsibility_type' => 'required|digits',
                    'capital_valuation_type' => 'required|digits',
                    'capital_amount' => 'required|digits',
                    'society_operational_area' => 'required|string',
                    'society_objective' => 'required|string',
                    'society_share_value' => 'required|digits',
                    'subscription_rate' => 'required|digits',
                    'member_liability' => 'required|string',
                    'general_member_count' => 'required|digits',
                    'society_record_language' => 'required|digits',
                    'society_representative_name' => 'required|string',
                    'society_representative_address' => 'required|string',
                    'society_representative_signature' => 'required|string',
                    'society_secretary_name' => 'required|string',
                    'society_secretary_address' => 'required|string',
                    'society_secretary_signature' => 'required|string',
                ];
            default:
                return [];
        }
    }
    public function checkAadharExists(Request $request)
    {
        $aadharNo = $request->input('aadhar_no');
        $member_id = $request->input("member_id") ?? "";
        // Check if the Aadhaar number exists in the database
        if (isset($member_id)) {
            $exists = Members::where('aadhar_no', $aadharNo)->where("id", "!=", $member_id)->exists();
        } else {
            $exists = Members::where('aadhar_no', $aadharNo)->exists();
        }
        return response()->json(['exists' => $exists, "aadharNo" => $aadharNo]);
    }
    /* public function social_regd_app_list()
    {
        $user = Auth::user();
        $role_id = $user->role_id;
        $districts = District::orderBy('name', 'ASC')->get();
        $all_districts = [];
        foreach ($districts as $k => $v) {
            $all_districts[$v->id] = $v->name;
        }
        // print_r($all_districts);
        if ($role_id == 1) {
            $society_details = SocietyAppDetail::with('society_details', 'scheme')->where("status", 0)->get();
        } else if ($role_id == 2) {
            $society_details = SocietyAppDetail::with('society_details', 'scheme')->where("status", "!=", 0)->get();
        }
        // return $society_details;
        return view('social_regd_app_list', compact('society_details', 'all_districts'));
    }*/
    public function showSocietyRegistration()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        $blocks = Block::all();
        $area_operation = AreaOfOperation::all();
        $sectors = SocietySectorType::all();
        $tehsil=Tehsil::all();
        return view('social_registration', compact('districts', 'blocks', 'area_operation', 'sectors','tehsil'));
    }
    public function getBlocks($district_id)
    {
        $blocks = Block::where('district_id', $district_id)->orderBy('name', 'ASC')->get();
        return response()->json($blocks);
    }
    public function showSocietyMember()
    {
        $getSocietyDetail = SocietyAppDetail::whereNot('status', 0)
            ->with('society_details.members')
            ->get();

        return view('society_member', compact('getSocietyDetail'));
    }
    // public function show($id)
    // {
    //     $societyAppDetail = SocietyAppDetail::findOrFail($id);

    //     $societyDetails = SocietyRegistration::with([
    //         'feasibilityReport',
    //         'memberDeclaration.members',
    //         'membersObjectives',
    //         'signatureDetails',
    //         'districtName',
    //         'block',
    //         'getSocietySectorType'
    //     ])->findOrFail($societyAppDetail->app_id);
    //     $members = $societyDetails->memberDeclaration->members ?? [];
    //     $members_objective = optional($societyDetails->membersObjectives);
    //     // return $societyDetails;
    //     return view('society-registration.official.view', compact('societyAppDetail', 'societyDetails', 'members', 'members_objective'));

    // }
    public function show($id)
{
    $societyAppDetail = SocietyAppDetail::findOrFail($id);

    $societyDetails = SocietyRegistration::with([
        'feasibilityReport',
        'memberDeclaration.members',
        'membersObjectives',
        'signatureDetails',
        'districtName',
        'block',
        'getSocietySectorType',
        'registerDocuments' // Make sure to load registerDocuments relationship
    ])->findOrFail($societyAppDetail->app_id);
    
    $members = $societyDetails->memberDeclaration->members ?? [];
    $members_objective = optional($societyDetails->membersObjectives);
    
    // Initialize document verification counts
    $verifiedCount = 0;
    $totalDocuments = 8; // Total number of documents to verify
    $documents = $societyDetails->registerDocuments;

    if ($documents) {
        $documentFields = [
            'meeting1', 'meeting2', 'meeting3', 'society_by_laws',
            'all_id_proof', 'all_application_form', 'all_declaration_form', 'challan_proof'
        ];

        foreach ($documentFields as $field) {
            $status = $documents->{"{$field}_status"} ?? null;
            if ($status === 'approved' || $status === 'rejected') {
                $verifiedCount++;
            }
        }
    }

    return view('society-registration.official.view', compact(
        'societyAppDetail',
        'societyDetails',
        'members',
        'members_objective',
        'verifiedCount',
        'totalDocuments'
    ));
}
    public function edit($id)
    {
        $societyAppDetails = SocietyAppDetail::findOrFail($id);

        // Step 2: Get the related society_id
        $societyId = $societyAppDetails->app_id;

        // Step 3: Fetch all required data using society_id
        $societyDetails = SocietyRegistration::findOrFail($societyId);
        $membersObjectives = MembersObjective::where('society_id', $societyId)->first();
        // $membersDeclarative = Member_declaration::where('society_id', $societyId)->first();
        $members_data = Member_declaration::with('members')->where('society_id', $societyId)->get();
        // return $members_data[0]->id;
        // $members = Members::whereHas('member_declaration', function ($query) use ($societyId) {
        //     $query->where('society_id', $societyId);
        // })->get(); // returns a single model
        // dd($membersDeclarative);
        // return $members_data;

        $feasibilityReports = Feasibility_reports::where('society_id', $societyId)->first();
        $signatureDetails = InspectorReport::where('society_id', $societyId)->first();
        $finalSubmission = SocietyRegisterDocuments::where('society_id', $societyId)->first();

        // Step 4: Load dropdowns
        $districts = District::orderBy('name', 'ASC')->get();
        $blocks = Block::where('district_id', $societyDetails->district)->orderBy('name', 'ASC')->get();
        $tehsil = Tehsil::where('district_id', $societyDetails->district)->orderBy('name', 'ASC')->get();

        $sectors = SocietySectorType::all();

        // return $societyDetails;
        // Step 5: Pass data to view
        return view('social_registration', compact(
            'societyDetails',
            'membersObjectives',
            'members_data',
            'feasibilityReports',
            'signatureDetails',
            'finalSubmission',
            'districts',
            'blocks',
            'tehsil',
            'societyAppDetails',
            'sectors'
        ));
    }
    public function deleteSocietyMember(Request $request)
    {
        // return $request;
        $member_id = $request->input('memberId');
        $member = Members::find($member_id);
        if ($member) {
            Members::where('id', (int) $member_id)->delete();
            return response()->json(['success' => true, 'message' => 'Member deleted successfully.'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Member not found.'], 404);
    }

    public function memberDelete(Request $request)
    {
        // return $request->member_id;
        try {
            $member = Members::where('id', $request->member_id)->first();

            if (!$member) {
                return response()->json(['success' => false, 'message' => 'Member not found.']);
            }

            $member->delete(); // Deletes or soft deletes depending on your model setup

            return response()->json(['success' => true, 'message' => 'Member deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete member.']);
        }
    }
    // public function storeinspection(Request $request)
    // {
    //     // dd($request);
    //     try {
    //         $signaturePath = null;
    //         if ($request->hasFile('authority_signature')) {
    //             $signaturePath = $request->file('authority_signature')->store('inspector_signatures', 'public');
    //         }

    //         $report = new InspectorReport();
    //         $report->society_id = $request->society_id;
    //         $report->permanent_inspection_date = $request->permanent_inspection_date;
    //         $report->member_knowledge = $request->member_knowledge;
    //         $report->panchayat_suitability = $request->panchayat_suitability;
    //         $report->family_wilingness = $request->family_wilingness;
    //         $report->family_wilingness_reason = $request->family_wilingness_reason ?? null;
    //         $report->is_bank_capital_available = $request->is_bank_capital_available;
    //         $report->authority_name = $request->authority_name;
    //         $report->authority_designation = $request->authority_designation;
    //         $report->authority_signature = $signaturePath;
    //         $report->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Inspection report saved successfully',
    //             'data' => $report
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to save inspection report: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function verifyDocument(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:society_app_details,id',
            'document_field' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'remarks' => 'nullable|string'
        ]);

        $app = SocietyAppDetail::find($request->application_id);
        $documents = $app->society_details->registerDocuments;

        if (!$documents) {
            return response()->json(['message' => 'No documents found'], 404);
        }

        // Update document status
        $documents->update([
            $request->document_field . '_status' => $request->status,
            $request->document_field . '_remarks' => $request->remarks,
            $request->document_field . '_verified_by' => auth()->id(),
            $request->document_field . '_verified_at' => now(),
        ]);

        // Check if all documents are approved
        $allApproved = true;
        $documentFields = [
            'meeting1',
            'meeting2',
            'meeting3',
            'society_by_laws',
            'all_id_proof',
            'all_application_form',
            'all_declaration_form',
            'challan_proof'
        ];

        foreach ($documentFields as $field) {
            if ($documents->{$field . '_status'} !== 'approved') {
                $allApproved = false;
                break;
            }
        }

        if ($allApproved) {
            // All documents approved - ready for ARCS inspection
            $app->update(['documents_verified' => true]);
        }

        return response()->json(['message' => 'Document verification updated']);
    }

    public function history(Request $request)
    {
        $history = DocumentVerificationFlow::with('verifier')
            ->where('society_app_detail_id', $request->society_app_detail_id)
            ->where('document_field', $request->document_field)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partials.document-history', compact('history'));
    }


// public function storeinspection(Request $request)
// {
//     try {
//         $signaturePath = null;
//         if ($request->hasFile('authority_signature')) {
//             $signaturePath = $request->file('authority_signature')->store('inspector_signatures', 'public');
//         }

//         $report = new InspectorReport();
//         $report->society_id = $request->society_id;
//         $report->permanent_inspection_date = $request->permanent_inspection_date;
//         $report->member_knowledge = $request->member_knowledge;
//         $report->panchayat_suitability = $request->panchayat_suitability;
//         $report->family_wilingness = $request->family_wilingness;
//         $report->family_wilingness_reason = $request->family_wilingness_reason ?? null;
//         $report->is_bank_capital_available = $request->is_bank_capital_available;
//         $report->authority_name = $request->authority_name;
//         $report->authority_designation = $request->authority_designation;
//         $report->authority_signature = $signaturePath;
//         $report->save();

//         // Automatically approve and revert to ARCS
//         $app = SocietyAppDetail::where('id', $request->society_id)->firstOrFail();

//         // Inject service (or resolve it)
//         $workflowService = app(SocietyWorkflowService::class);

//         // Prepare a request-like object with remarks and optional files
//         $dummyRequest = new \Illuminate\Http\Request([
//             'remarks' => 'Inspection completed. Reverting to ARCS for next action.',
//         ]);

//         // Call revert
//         $workflowService->revert($app, $dummyRequest);

//         return response()->json([
//             'success' => true,
//             'message' => 'Inspection report saved and reverted to ARCS successfully.',
//             'data' => $report
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to save inspection report: ' . $e->getMessage()
//         ], 500);
//     }
// }


public function storeinspection(Request $request)
{
    try {
        $signaturePath = null;
        if ($request->hasFile('authority_signature')) {
            $signaturePath = $request->file('authority_signature')->store('inspector_signatures', 'public');
        }

        // Save inspector report
        $report = new InspectorReport();
        $report->society_id = $request->society_id;
        $report->permanent_inspection_date = $request->permanent_inspection_date;
        $report->member_knowledge = $request->member_knowledge;
        $report->panchayat_suitability = $request->panchayat_suitability;
        $report->family_wilingness = $request->family_wilingness;
        $report->family_wilingness_reason = $request->family_wilingness_reason ?? null;
        $report->is_bank_capital_available = $request->is_bank_capital_available;
        $report->authority_name = $request->authority_name;
        $report->authority_designation = $request->authority_designation;
        $report->authority_signature = $signaturePath;
        $report->save();

        // After saving inspection, forward the application to ARCS
$app = SocietyAppDetail::where('id', $request->society_id)->firstOrFail();
$app->update([
    'documents_verified' => true,
    'documents_verified_by' => auth()->id(),
    'documents_verified_at' => now(),
]);

        $workflowService = app(SocietyWorkflowService::class);

        // Pass a valid action and remarks
        $dummyRequest = new Request([
            'remarks' => 'Inspection completed. Forwarding to ARCS.',
            'to_role' => 'arcs', // Forcefully define next role as ARCS if needed
        ]);

        // Call approve method (it uses 'verification' action for intermediate steps)
        $workflowService->approve($app, $dummyRequest);

        return response()->json([
            'success' => true,
            'message' => 'Inspection report saved and forwarded to ARCS successfully.',
            'data' => $report
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to save inspection report: ' . $e->getMessage()
        ], 500);
    }
}



}
