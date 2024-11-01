<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classe;
use App\Models\Document;
use App\Models\Course;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $userCount = User::count();         
        $teacherCount = Teacher::count();  
        $studentCount = Student::count();
        $classCount = Classe::count();
        $documentCount = Document::count();
        $courseCount = Course::count();
        
        return view('home', compact('userCount', 'teacherCount', 'studentCount', 'classCount', 'documentCount', 'courseCount'));
    }
}
