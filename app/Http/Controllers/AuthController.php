<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;

class AuthController extends Controller
{
    // --- SHOW LOGIN PAGE ---
    public function showLogin()
    {
        return view('auth.login');
    }

    // --- PROCESS LOGIN ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect('/students'); // Admin goes to master list
            }
            return redirect('/student/portal'); // Student goes to their portal
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    // --- SHOW SIGNUP PAGE ---
    public function showSignup()
    {
        return view('auth.signup');
    }

    // --- PROCESS SIGNUP ---
    public function signup(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'password'   => 'required|min:6'
        ]);

        // 1. Check if the Student ID actually exists in the database (Instructor Requirement)
        $studentRecord = Student::where('student_id', $request->student_id)->first();
        if (!$studentRecord) {
            return back()->withErrors(['student_id' => 'Signup Rejected: This Student ID does not exist in the system.']);
        }

        // 2. Check if an account has already been created for this ID
        $accountExists = User::where('username', $request->student_id)->exists();
        if ($accountExists) {
            return back()->withErrors(['student_id' => 'An account is already registered with this Student ID.']);
        }

        // 3. Create the user account! 
        // We use their real name from the student record, and their student_id as the username
        $user = User::create([
            'name'     => $studentRecord->first_name . ' ' . $studentRecord->last_name,
            'username' => $request->student_id,
            'password' => Hash::make($request->password),
            'role'     => 'student'
        ]);

        // 4. Log them in and send them to their portal
        Auth::login($user);
        return redirect('/student/portal');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}