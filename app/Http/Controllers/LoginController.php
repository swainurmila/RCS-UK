<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    // public function login(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     // Fetch the user by email
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         // User not found
    //         return back()->withErrors(['email' => 'User not found'])->withInput();
    //     }

    //     $expectedRoleId = $request->is_society_form;
    //     if ($user->role_id != $expectedRoleId) {
    //         return back()->withErrors(['email' => 'You are not authorized to access this login.'])->withInput();
    //     }

    //     // Attempt login
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Authentication passed
    //         if ($user->role_id == 2) {
    //             // Official user
    //             return redirect()->intended('/official-dashboard')->with('success', 'Login successful');
    //         } elseif ($user->role_id == 1) {
    //             // Society user
    //             return redirect()->intended('/dashboard')->with('success', 'Login successful');
    //         }
    //     }

    //     // Authentication failed
    //     return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    // }


    public function login(Request $request)
    {
        $formType = $request->is_society_form;
        // Determine which form is being submitted
        if ($formType == 1) {
            $emailInput = 'society_email'; // Input field name in the form
            $passwordInput = 'society_password';
        } else {
            $emailInput = 'official_email';
            $passwordInput = 'official_password';
        }

        // Validate input fields
        $validator = Validator::make($request->all(), [
            $emailInput => 'required|email',
            $passwordInput => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('form_type', $formType);
        }

        // Retrieve user using the actual 'email' column
        $user = User::where('email', $request->$emailInput)->first();

        /*   if (!$user) {
            return back()
                ->withErrors([$emailInput => 'User not found'])
                ->withInput()
                ->with('form_type', $formType);
        }

        // Ensure user role matches the form type
        if ($user->role_id != $formType) {
            return back()
                ->withErrors([$emailInput => 'You are not authorized to access this login.'])
                ->withInput()
                ->with('form_type', $formType);
        } */

        // Attempt login (mapping form input to actual DB columns)
        if (!Auth::attempt(['email' => $request->$emailInput, 'password' => $request->$passwordInput])) {
            return back()
                ->withErrors([$emailInput => 'Invalid credentials'])
                ->withInput()
                ->with('form_type', $formType);
        }

        // Redirect based on role
        // return redirect()->intended($user->role_id == 2 ? '/official-dashboard' : '/dashboard')
        //     ->with('success', 'Login successful');
        return redirect()->intended('/all-dashboard')
            ->with('success', 'Login successful');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login.view')->with('success', 'You have been logged out.');
    }
}
