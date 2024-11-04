<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classe; // Assuming your Class model is named ClassModel
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Selection;

class AssignController extends Controller
{
    public function getStudentsClassesCourses(Request $request)
    {
        // Fetch all students who are NOT in the selections table
        $students = Student::whereNotIn('name', Selection::pluck('student_name'))->get();

        // Fetch all classes
        $classes = Classe::all();

        // Fetch all courses
        $courses = Course::all();
        $selections = Selection::paginate(10);
        // Return the data to a view
        return view('assign.index', [
            'students' => $students,
            'classes' => $classes,
            'courses' => $courses,
            'selections' => $selections,
        ]);
    }

    public function storeSelectedItems(Request $request)
    {
        // Validate input
        $request->validate([
            'selected_student' => 'nullable|string',
            'selected_class' => 'nullable|string',
            'selected_courses' => 'nullable|string',
        ]);
    
        // Save the selection to the database
        Selection::create([
            'student_name' => $request->selected_student,
            'class_name' => $request->selected_class,
            'course_names' => $request->selected_courses, // Assuming you store this as a comma-separated string
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Courses Assigned Successfully.');
    }
    // public function getAllSelections()
    // {
    //     // Fetch all data from the selections table
    //     $selections = Selection::all();

    //     // Return the data as a view or JSON, depending on your requirement
    //     return view('selections.index', compact('selections'));

    //     // OR return as JSON for an API
    //     // return response()->json($selections);
    // }
    
}
