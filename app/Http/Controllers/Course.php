<?php

namespace App\Http\Controllers;

use App\Models\Course as ModelsCourse;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Course extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $courses = ModelsCourse::all();
            return view('backend.pages.course',compact('courses'));        
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.add-course');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);
       
        $data= $request->all();
        ModelsCourse::create($data);

        return redirect()->route('admin.course.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = ModelsCourse::findOrFail($id);
        return view('backend.pages.edit-course', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'course_title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);
       
        $data= $request->all();
        $course = ModelsCourse::findOrFail($id);
        $course->update($data);

        return redirect()->route('admin.course.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = ModelsCourse::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.course.index')->with('success', 'Course deleted successfully.');
    }
    public function enroll(Request $request, $id)
    {
        $user = Auth::user();
        // Check if already enrolled
        $exists = StudentCourse::where('user_id', $user->id)
            ->where('course_id', $id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        StudentCourse::create([
            'user_id' => $user->id,
            'course_id' => $id,
            'payment_status' => 1,
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Enrolled in course successfully.');
    }
    public function myCourses()
    {
        $user = Auth::user();
        $enrollments = StudentCourse::where('user_id', $user->id)->with('course')->get();

        return view('backend.pages.my-course', compact('enrollments'));
    }
}
