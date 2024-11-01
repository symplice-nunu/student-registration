<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CourseController extends Controller
{
    // Display a list of courses
    public function index(Request $request)
    {
        // Initialize a query for the Course model
        $courses = Course::query();
    
        // Search functionality (if search term is provided)
        if ($request->filled('search')) {
            $courses->where('courseName', 'like', '%' . $request->search . '%');
        }
    
        // Paginate results, showing 10 courses per page
        $courses = $courses->paginate(10);
    
        // Return the view with paginated courses
        return view('courses.index', compact('courses'));
    }
    

    // Show the form for creating a new course
    public function create()
    {
        return view('courses.create');
    }

    // Store a newly created course in the database
    public function store(Request $request)
    {
        $request->validate([
            'courseName' => 'required|string',
            'maxPoints' => 'required|integer',
        ]);

        // Create the course, relying on the model's boot method to generate courseID
        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    // Show the form for editing an existing course
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update an existing course in the database
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'courseID' => 'required|string|unique:courses,courseID,' . $course->id,
            'courseName' => 'required|string',
            'maxPoints' => 'required|integer',
        ]);

        $course->update($request->all());
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    // Delete a course from the database
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
    public function generatePdf()
    {
        // Fetch all course records
        $courses = Course::all();

        // Generate PDF from the courses view
        $pdf = Pdf::loadView('courses.pdf', compact('courses'));

        // Return the generated PDF for download
        return $pdf->download('course_list.pdf');
    }
}

