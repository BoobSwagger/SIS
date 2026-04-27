<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\User;
use App\Models\SystemNotification;

class AdminController extends Controller
{
    // 1. Handle Profile & Photo Updates
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048' // Max 2MB Image
        ]);

        $user = auth()->user();
        $user->name = $request->name;

        // Handle File Upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            // Save new photo to storage/app/public/profiles
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }

        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // 2. Handle Database Wipe
    public function wipeDatabase(Request $request)
    {
        $request->validate([
            'admin_password' => 'required'
        ]);

        // Check if they typed the correct admin password
        if (!Hash::check($request->admin_password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Incorrect Admin Password!');
        }

        // Wipe all students and their matching user accounts (except the admin)
        Student::truncate();
        User::where('role', 'student')->delete();

        return redirect()->back()->with('success', 'Database completely wiped.');
    }

    // 3. Handle Clearing Notifications
    public function clearNotifications()
    {
        // Wipes all notifications from the database
        SystemNotification::truncate();
        
        return redirect()->back();
    }
}