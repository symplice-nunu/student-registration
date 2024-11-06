<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AssignController;

Route::get('/', function () {

    return view('welcome');

});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/students/pdf', [StudentController::class, 'generatePdfReport'])->name('students.pdf');
Route::get('teachers/pdf', [TeacherController::class, 'generatePdfReport'])->name('teachers.pdf');
Route::get('classes/pdf', [ClassController::class, 'generatePdf'])->name('classes.pdf'); 
Route::get('/courses/pdf', [CourseController::class, 'generatePdf'])->name('courses.pdf');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', ClassController::class); 
    Route::resource('courses', CourseController::class);
    Route::get('/documents/upload', [DocumentController::class, 'showUploadForm'])->name('documents.upload');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload'); // Add your upload logic
    Route::get('/documents', [DocumentController::class, 'listUploadedDocuments'])->name('documents.list');
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy'); // Add your delete logic
    Route::get('/students-classes-courses', [AssignController::class, 'getStudentsClassesCourses'])->name('assign.list');
    Route::post('/submit-selected-items', [AssignController::class, 'storeSelectedItems'])->name('submit.selected.items');
    Route::get('/selections/{id}/edit', [AssignController::class, 'edit'])->name('selections.edit');
    Route::delete('/selections/{id}', [AssignController::class, 'destroy'])->name('selections.destroy');
    Route::put('/selections/{id}', [AssignController::class, 'update'])->name('selections.update');
    Route::get('/selections/student-names', [AssignController::class, 'getStudentNames'])->name('selections.list');
    Route::post('/update-marks', [AssignController::class, 'updateMarks'])->name('update.marks');
    Route::post('/selections/{id}/update-marks', [AssignController::class, 'updateMarks'])->name('selections.updateMarks');


    
});