<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authentication extends Controller
{
    public function login()
    {
        return view('backend.pages.auth.login');
    }

    public function loginPost(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
            } elseif ($user->role == 2) {
                return redirect()->route('staff.dashboard')->with('success', 'Login successful.');
            }
        }
    }
    public function adminDashboard()
    {

        $totalStaff   = User::where('role', 2)->count();
        $totalTasks   = Tasks::count();
        $openTasks    = Tasks::where('status', 0)->count();
        $closedTasks  = Tasks::where('status', 1)->count();

        return view('backend.pages.admin-dashboard', compact(
            'totalStaff',
            'totalTasks',
            'openTasks',
            'closedTasks'
        ));
    }
    public function staffDashboard()
    {

        $user = Auth::user();

        $tasks = Tasks::where('assigned_to', $user->id)->get();
        return view('backend.pages.staff-dashboard', compact('tasks'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
