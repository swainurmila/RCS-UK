<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\SocietyRegistration;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AjaxController extends Controller
{


    public function sendOtp(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:35',
            'mob_no' => 'required|string|digits:10',
            'email' => 'nullable|string|email|max:50|unique:users,email',
            'password' => 'required|string|max:20',
            'confirm_password' => 'required|string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate a 4-digit OTP
        $otp_value = 1234;
        $otp_ex_time = Carbon::now()->addMinutes(5);

        $otp = Otp::create([
            'mob_no' => $request->mob_no,
            'email' => $request->email,
            'otp' => $otp_value,
            'otp_ex_time' => $otp_ex_time,
        ]);

        Session::put('registration_data', [
            'full_name' => $request->full_name,
            'mob_no' => $request->mob_no,
            'email' => $request->email,
            'password' => $request->password,
            'confirm_password' => $request->confirm_password,
        ]);

        // Store OTP id
        Session::put('latest_otp_id', encrypt($otp->id));

        // (Optional) Send OTP via email
        if (!empty($request->email)) {
            // Mail::raw("Your OTP is: $otp_value", function ($message) use ($request) {
            //     $message->to($request->email)->subject("Your OTP Code");
            // });
        }

        return response()->json(['message' => 'OTP sent successfully!']);
    }

    public function resetOtp(Request $request)
    {
        // Get registration data from session
        $registrationData = Session::get('registration_data');
        // dd($registrationData);
        if (!$registrationData) {
            return response()->json(['message' => 'Session expired or registration data not found.'], 400);
        }

        // Get previous OTP ID from session
        $encryptedOtpId = Session::get('latest_otp_id');
        if (!$encryptedOtpId) {
            return response()->json(['message' => 'Previous OTP not found.'], 400);
        }

        $otpId = decrypt($encryptedOtpId);

        // Find the existing OTP record
        $otp = Otp::find($otpId);
        if (!$otp) {
            return response()->json(['message' => 'OTP record not found.'], 404);
        }

        // Generate a new OTP value
        $otp_value = 1234; // In production, use rand(1000, 9999)
        $otp_ex_time = Carbon::now()->addMinutes(5);

        // Update the OTP record
        $otp->create([
            'mob_no' => $registrationData['mob_no'],
            'email' => $registrationData['email'],
            'otp' => $otp_value,
            'otp_ex_time' => $otp_ex_time,
            'status' => 2,
        ]);

        // (Optional) Resend OTP via email
        $email = $registrationData['email'] ?? null;
        if (!empty($email)) {
            // Mail::raw("Your OTP is: $otp_value", function ($message) use ($email) {
            //     $message->to($email)->subject("Your OTP Code (Resent)");
            // });
        }

        return response()->json(['message' => 'OTP resent successfully!']);
    }

    // public function resetOtp(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'email' => 'required|string|email|max:50',
    //         'mob_no' => 'required|string|digits:10', // Assuming mobile number is 10 digits
    //     ]);

    //     // Fetch email and mobile number from the request
    //     $email = $request->email;
    //     $mob_no = $request->mob_no;

    //     // Check if the user exists
    //     $user = User::where('email', $email)->where('mob_no', $mob_no)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     // Generate a 4-digit OTP
    //     $otp_value = rand(1000, 9999);
    //     $otp_ex_time = Carbon::now()->addMinutes(5); // OTP expiry time (10 minutes)

    //     // Insert new OTP into the OTPs table
    //     $otp = Otp::create([
    //         'email' => $email,
    //         'mob_no' => $mob_no,
    //         'otp' => $otp_value,
    //         'otp_ex_time' => $otp_ex_time,
    //         'status' => '0' // Set status to 0 (unused)
    //     ]);

    //     // Store the latest OTP ID in the session (encrypted)
    //     Session::put('latest_otp_id', encrypt($otp->id));
    //     Session::put('otp_user_id', encrypt($user->id));
    //     // Send OTP via Email
    //     // if (!empty($email)) {
    //     //     Mail::raw("Your OTP is: $otp_value", function ($message) use ($email) {
    //     //         $message->to($email)->subject("Your OTP Code");
    //     //     });
    //     // }

    //     return response()->json(['message' => 'OTP sent successfully!'], 200);
    // }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:4'
        ]);

        // Retrieve latest OTP ID from session
        $latestOtpId = Session::get('latest_otp_id');
        if (!$latestOtpId) {
            return response()->json(['success' => false, 'message' => 'Session expired. Request a new OTP.'], 400);
        }

        try {
            $otpId = decrypt($latestOtpId);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid session data.'], 400);
        }

        // Fetch OTP record
        $otpRecord = Otp::where('id', $otpId)
            ->where('otp', $request->otp)

            ->where('otp_ex_time', '>=', now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 400);
        }

        // Retrieve registration data from session
        $data = Session::get('registration_data');
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'No registration data found in session.'], 400);
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $data['full_name'],
                'mob_no' => $data['mob_no'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => 7,
                'is_active' => 1,
            ]);

            // Assign role
            $role = Role::find(7);
            if ($role) {
                $user->assignRole($role);
            }

            // Mark OTP as used
            $otpRecord->update(['status' => '1']);

            // Clear session
            Session::forget('latest_otp_id');
            Session::forget('registration_data');

            return response()->json(['success' => true, 'message' => 'User Registered Successfully', 'redirect_url' => route('login.view')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User registration failed.'], 500);
        }
    }

    // public function verifyOtp(Request $request)
    // {
    //     dd($request);
    //     $request->validate([
    //         'otp' => 'required|numeric|digits:4' // Ensure it's a 4-digit numeric OTP
    //     ]);

    //     // Retrieve the latest OTP ID from session
    //     $latestOtpId = Session::get('latest_otp_id');

    //     if (!$latestOtpId) {
    //         return response()->json(['success' => false, 'message' => 'Session expired. Request a new OTP.'], 400);
    //     }

    //     // Decrypt OTP ID
    //     try {
    //         $otpId = decrypt($latestOtpId);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Invalid session data.'], 400);
    //     }

    //     // Fetch the latest OTP entry
    //     $otpRecord = Otp::where('id', $otpId)->where('otp', $request->otp)->first();
    //     if ($otpRecord) {
    //         Log::info("Stored OTP: {$otpRecord->otp}, User entered: {$request->otp}");
    //     }


    //     if (!$otpRecord) {
    //         return response()->json(['success' => false, 'message' => 'Invalid OTP. Please try again.'], 400);
    //     }

    //     // Check if OTP is expired
    //     if (Carbon::now()->greaterThan($otpRecord->otp_ex_time)) {
    //         return response()->json(['success' => false, 'message' => 'OTP expired. Request a new OTP.'], 400);
    //     }

    //     // OTP is valid, so mark it as used (optional)
    //     $otpRecord->update(['status' => '1']);

    //     // Return success response
    //     return response()->json(['success' => true, 'message' => 'OTP verified successfully!'], 200);
    // }

    public function resetPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed', // Ensure password confirmation
        ]);

        // Retrieve user ID from session
        $userId = Session::get('otp_user_id');

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please request OTP again.'], 400);
        }

        // Decrypt user ID
        try {
            $userId = decrypt($userId);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid session data.'], 400);
        }

        // Find the user
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Clear session after successful reset
        Session::forget(['latest_otp_id', 'otp_user_id']);

        return redirect()->route('login.view')->with([
            'success' => true,
            'message' => 'Password reset successfully!'
        ]);
    }

    public function getDistrict(Request $request)
    {
        $options = '<option value="">Please Select District</option>';
        if ($request->method() == "POST") {
            if (!empty($request->division_id)) {
                $districts = District::where('division_id', $request->division_id)->select('id', 'name')->orderBy('name', 'ASC')->get();
                if ($districts->count() > 0) {
                    foreach ($districts as $value) {
                        $options .= '<option value="' . $value->id . '">' . $value->name . '</option>';
                    }
                }
            }
        }
        return response()->json(['status' => 200, 'options' => $options]);
    }

    public function getBlock(Request $request)
    {
        $options = '<option value="">Select Block</option>';
        if ($request->method() == "POST") {
            if (!empty($request->district_id)) {

                $blocks = Block::where('district_id', $request->district_id)->select('id', 'name')->orderBy('name', 'ASC')->get();
                if ($blocks->count() > 0) {
                    foreach ($blocks as $block) {
                        $options .= '<option value="' . $block->id . '">' . $block->name . '</option>';
                    }
                }
            }
        }
        return response()->json(['status' => 200, 'options' => $options]);
    }

    public function getSocietyName(Request $request)
    {
        $societytypeId = $request->society_type;
        $districtId = $request->district_id;
        $blockId = $request->block_id;
        $registrations = SocietyRegistration::select('id', 'society_name')
            ->where('society_category', $societytypeId)
            ->where('district', $districtId)
            ->where('developement_area', $blockId)
            ->get();
        return response()->json($registrations);
    }
}
