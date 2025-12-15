<?php

use App\Http\Controllers\API;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Course;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    
   Route::get('/courses',[API::class,'adminDashboard'])->name('admin.dashboard');
 
});

require __DIR__.'/api.php';