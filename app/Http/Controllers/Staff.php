<?php

namespace App\Http\Controllers;

use App\Models\Staff as ModelsStaff;
use App\Models\User;
use Illuminate\Http\Request;

class Staff extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::where('role', 2)->get();
        return view('backend.pages.staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'status' => 'nullable|in:0,1',

        ]);

        $data = $request->all();
        User::create($data);
        session()->flash('success', 'Staff created successfully.');
        return redirect()->route('staffs.index')->with('success', 'Staff created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff = User::findOrFail($id);

        return response()->json([
            'name' => $staff->name,
            'email' => $staff->email,
            'password' => $staff->password ?? '(hidden)',
            'status' => $staff->status == 1 ? 'Active' : 'Inactive',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'status' => 'nullable|in:0,1',
        ]);

        $data = $request->all();
        $staff = User::findOrFail($id);
        $staff->update($data);

        return redirect()->route('staffs.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();

        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully.');
    }
}
