<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Task extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::with(['assignedStaff'])->get();
        $staffs = User::where('role', 2)->where('status', 1)->get();
        return view('backend.pages.tasks.index', compact('tasks', 'staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:2000',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:0,1',
        ]);

        $data = $request->all();
        Tasks::create($data);
        session()->flash('success', 'Task created successfully.');
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Tasks::findOrFail($id);

        return response()->json([
            'title' => $task->title,
            'description' => $task->description,
            'assigned_to' => $task->assignedStaff ? $task->assignedStaff->name : 'Unassigned',
            'status' => $task->status == 1 ? 'Completed' : 'Opened',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:2000',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'nullable|in:0,1',
        ]);

        $data = $request->all();
        dd($data);
        $staff = Tasks::findOrFail($id);
        $staff->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    public function showTaskDetails($id)
    {
        $task = Tasks::where('assigned_to', Auth::id())->findOrFail($id);

        return response()->json([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'created_at' => $task->created_at->format('d M Y'),
        ]);
    }

    public function updateTaskStatus(Request $request, $id)
    {
        $task = Tasks::where('assigned_to', Auth::id())->findOrFail($id);

        $request->validate(['status' => 'required|in:0,1']);

        $task->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Task status updated successfully!']);
    }
}
