<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class API extends Controller
{
    public function course(Request $request){
        
        $courses = Courses::select('courses.course_title','courses.price');
    }
}
