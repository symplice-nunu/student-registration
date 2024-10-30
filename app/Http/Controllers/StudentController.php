<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use PDF; 

class StudentController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
        // Check if the user has 'Admin' role, then bypass specific permission checks
        if (auth()->user() && auth()->user()->hasRole('Admin')) {
            return $next($request);
        }
        $this->middleware('permission:student-list|student-create|student-edit|student-delete', ['only' => ['index','show']]);
        $this->middleware('permission:student-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
    
        $students = Student::where(function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->paginate(10);
    
        return view('students.index', compact('students'))->with('i', ($request->input('page', 1) - 1) * 10);
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Allows only letters and spaces
            ],
            'dateOfBirth' => 'required|date|before:today',
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w+$/',
                'unique:students,email', // Ensure email is unique in students table
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'phoneNumber' => [
                'required',
                'numeric',
                'regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/',
            ],
        ]);
    
        // Get all student data from the request
        $studentData = $request->all();
    
        // Create the student record
        $student = Student::create([
            'name' => $studentData['name'],
            'dateOfBirth' => $studentData['dateOfBirth'],
            'email' => $studentData['email'],
            'address' => $studentData['address'],
            'phoneNumber' => $studentData['phoneNumber'],
        ]);
    
        // Check if user account should be created
        if ($request->has('createUser')) {
            // Create the user account with the default password
            User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => bcrypt('1234567890'), // Hash the default password
            ]);
        }
    
        return redirect()->route('students.index')
                         ->with('success', 'Student created successfully.');
    }
    

    public function update(Request $request, $id): RedirectResponse
    {
        // Find the student by ID
        $student = Student::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Allows only letters and spaces
            ],
            'dateOfBirth' => 'required|date|before:today',
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w+$/',
                'unique:students,email,' . $student->id, // Ensure email is unique in students table
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'phoneNumber' => [
                'required',
                'numeric',
                'regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/',
            ],
        ]);

        // Update the student record
        $student->update($request->only(['name', 'dateOfBirth', 'email', 'address', 'phoneNumber']));

        return redirect()->route('students.index')
                        ->with('success', 'Student updated successfully.');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student): View
    {
        return view('students.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student): View
    {
        return view('students.edit',compact('student'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
                        ->with('success','Student deleted successfully');
    }
    public function generatePdfReport()
    {
        
        $students = Student::all(); // Fetch all students or apply any specific filtering
    
        $pdf = PDF::loadView('students.pdf', compact('students'));
        
        return $pdf->download('students_report.pdf');
    }


}
