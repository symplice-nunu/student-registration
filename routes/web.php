<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

Route::get('/', function () {

    return view('welcome');

});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/students/pdf', [StudentController::class, 'generatePdfReport'])->name('students.pdf');
Route::get('teachers/pdf', [TeacherController::class, 'generatePdfReport'])->name('teachers.pdf');
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);


    
});