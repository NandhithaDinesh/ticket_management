<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Course;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/register',[Authentication::class,'register'])->name('register');
Route::post('/register',[Authentication::class,'registerPost'])->name('register.post');
Route::get('/',[Authentication::class,'login'])->name('login');
Route::post('/login',[Authentication::class,'loginPost'])->name('login.post');

Route::middleware('auth')->group(function () {
    
   Route::get('/admin/dashboard',[Authentication::class,'adminDashboard'])->name('admin.dashboard');
   Route::resource('/admin/course',Course::class)->names('admin.course');
   Route::get('/student/dashboard',[Authentication::class,'studentDashboard'])->name('student.dashboard');
   Route::post('/student/enroll/{id}',[Course::class,'enroll'])->name('student.enroll');
   Route::get('/student/courses',[Course::class,'myCourses'])->name('student.courses');
});


Route::get('/logout',[Authentication::class,'logout'])->name('logout');
require __DIR__.'/api.php';