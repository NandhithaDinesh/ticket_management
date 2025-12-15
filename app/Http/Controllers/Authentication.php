<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authentication extends Controller
{
    public function login(){
        return view('backend.pages.login');
    }

    public function loginPost(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
       $credentials = $request->only('email', 'password');
       if(Auth::attempt($credentials)){
        $user = Auth::user();
        if ($user->role == 1) {
            return redirect()->route('admin.dashboard')->with('success', 'Login successful.');
        } elseif ($user->role == 2) {
            return redirect()->route('student.dashboard')->with('success', 'Login successful.');
        }
        
       }
    }
    public function adminDashboard(){
    
        return view('backend.pages.admin-dashboard');
    }
    public function studentDashboard(){
    
        $courses = Course::all();
        return view('backend.pages.student-dashboard',compact('courses'));
    }
     public function register(){
    return view('backend.pages.register');
    }
    public function registerPost(Request $request){
    
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'role'=>'required|in:1,2',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);
       
        $data= $request->all();
         $data['password'] = Hash::make($request->password);
        User::create($data);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }   
public function logout(Request $request){
    Auth::logout();
    return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
