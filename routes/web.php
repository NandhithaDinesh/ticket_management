<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\Course;
use App\Http\Controllers\Staff;
use App\Http\Controllers\Task;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [Authentication::class, 'login'])->name('login');
Route::post('/login', [Authentication::class, 'loginPost'])->name('login.post');

Route::middleware('auth')->group(function () {

   Route::get('/admin/dashboard', [Authentication::class, 'adminDashboard'])->name('admin.dashboard');
   Route::get('/staff/dashboard', [Authentication::class, 'staffDashboard'])->name('staff.dashboard');
   Route::resource('/staffs', Staff::class);
   Route::resource('/tasks', Task::class);
   Route::get('/staff/tasks/{id}', [Task::class, 'showTaskDetails'])->name('staff.tasks.show');
   Route::post('/staff/tasks/{id}/update-status', [Task::class, 'updateTaskStatus'])->name('staff.tasks.updateStatus');
});


Route::get('/logout', [Authentication::class, 'logout'])->name('logout');
