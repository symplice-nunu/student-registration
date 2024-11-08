<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher; // Make sure you create a Teacher model
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use PDF; 

class TeacherController extends Controller
{ 
    // function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         // Check if the user has 'Admin' role, then bypass specific permission checks
    //         if (auth()->user() && auth()->user()->hasRole('Admin')) {
    //             return $next($request);
    //         }
    //         $this->middleware('permission:teacher-list|teacher-create|teacher-edit|teacher-delete', ['only' => ['index','show']]);
    //         $this->middleware('permission:teacher-create', ['only' => ['create','store']]);
    //         $this->middleware('permission:teacher-edit', ['only' => ['edit','update']]);
    //         $this->middleware('permission:teacher-delete', ['only' => ['destroy']]);
    //     });
    // }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $teachers = Teacher::where(function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            }
        })->paginate(10);
    
        return view('teachers.index', compact('teachers'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        return view('teachers.create');
    }

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
            'DOB' => 'required|date|before:today', // Date of Birth validation
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w+$/',
                'unique:teachers,email', // Ensure email is unique in teachers table
            ],
            'phoneNumber' => [
                'required',
                'numeric',
                'regex:/^(\+?\d{1,3}[- ]?)?\d{10}$/', // Valid phone number format
            ],
        ]);

        // Get all teacher data from the request
        $teacherData = $request->all();

        // Generate teacherid
        $teacherid = $this->generateTeacherId($teacherData['name']);

        // Create the teacher record
        $teacher = Teacher::create([
            'name' => $teacherData['name'],
            'DOB' => $teacherData['DOB'],
            'email' => $teacherData['email'],
            'phoneNumber' => $teacherData['phoneNumber'],
            'teacherid' => $teacherid,
        ]);

        // Check if user account should be created
        if ($request->has('createUser')) {
            // Create the user account with the default password
            User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('1234567890'), // Hash the default password
            ]);
        }

        return redirect()->route('teachers.index')
                         ->with('success', 'Teacher created successfully.');
    }

    private function generateTeacherId($name)
    {
        // Get the first two letters of the name (uppercase)
        $initials = strtoupper(substr($name, 0, 2));

        // Generate five random digits
        $randomNumbers = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        // Combine initials and random numbers
        return $initials . $randomNumbers;
    }


    public function update(Request $request, $id): RedirectResponse
    {
        // Find the teacher by ID
        $teacher = Teacher::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/', // Allows only letters and spaces
            ],
            'DOB' => 'required|date|before:today',
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[\w\.-]+@[\w\.-]+\.\w+$/',
                'unique:teachers,email,' . $teacher->id, // Ensure email is unique in teachers table
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

        // Update the teacher record
        $teacher->update($request->only(['name', 'DOB', 'email', 'address', 'phoneNumber']));

        return redirect()->route('teachers.index')
                        ->with('success', 'Teacher updated successfully.');
    }

    public function show(Teacher $teacher): View
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher): View
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
                        ->with('success','Teacher deleted successfully');
    }

    public function generatePdfReport()
    {
        $teachers = Teacher::all(); // Fetch all teachers or apply any specific filtering
    
        $pdf = PDF::loadView('teachers.pdf', compact('teachers'));
        
        return $pdf->download('teachers_report.pdf');
    }
}
