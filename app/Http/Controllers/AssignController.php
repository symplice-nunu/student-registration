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
    // app/Http/Controllers/AssignController.php

    public function edit($id)
    {
        $selection = Selection::findOrFail($id);
        $students = Student::all();
        $classes = Classe::all();
        $courses = Course::all();

        return view('assign.edit', compact('selection', 'students', 'classes', 'courses'));
    }

    public function destroy($id)
    {
        $selection = Selection::findOrFail($id);
        $selection->delete();

        return redirect()->back()->with('success', 'Selection deleted successfully.');
    }
    // app/Http/Controllers/AssignController.php

    public function update(Request $request, $id)
    {
        $selection = Selection::findOrFail($id);

        $selection->update([
            'student_name' => $request->student_name,
            'class_name' => $request->class_name,
            'course_names' => $request->course_names,
        ]);

        return redirect()->route('assign.list')->with('success', 'Selection updated successfully.');
    }
    public function getStudentNames()
    {
        // Fetch distinct student names from selections table
        $studentNames = Selection::select('student_name', 'id', 'quiz_marks', 'exam_marks')
                                ->distinct()
                                ->get();

        // Calculate the sum of quiz marks and exam marks for each student
        foreach ($studentNames as $student) {
            // Decode the JSON arrays for quiz_marks and exam_marks
            $quizMarksArray = json_decode($student->quiz_marks, true) ?: [];
            $examMarksArray = json_decode($student->exam_marks, true) ?: [];

            // Calculate the sum of the marks
            $student->total_quiz_marks = array_sum($quizMarksArray);
            $student->total_exam_marks = array_sum($examMarksArray);
        }

        // Pass the student names and their total marks to the view
        return view('assign.marks', [
            'studentNames' => $studentNames,
        ]);
    }


    public function updateMarks(Request $request)
    {
        // Validate the input data
        $request->validate([
            'students.*.quiz_marks' => 'nullable|integer|min:0|max:100',  // single quiz mark value
            'students.*.exam_marks' => 'nullable|integer|min:0|max:100',  // single exam mark value
        ]);
    
        // Get the students' data from the form
        $studentsData = $request->input('students');
    
        // Update the selection marks for all students
        foreach ($studentsData as $studentId => $studentMarks) {
            $selection = Selection::find($studentId); // Find the selection by student ID
    
            if ($selection) {
                // Get existing marks (if any)
                $existingQuizMarks = $selection->quiz_marks ? json_decode($selection->quiz_marks, true) : [];
                $existingExamMarks = $selection->exam_marks ? json_decode($selection->exam_marks, true) : [];
    
                // Add new quiz marks to the existing array
                if (isset($studentMarks['quiz_marks'])) {
                    $existingQuizMarks[] = $studentMarks['quiz_marks'];  // Append new quiz mark
                }
    
                // Add new exam marks to the existing array
                if (isset($studentMarks['exam_marks'])) {
                    $existingExamMarks[] = $studentMarks['exam_marks'];  // Append new exam mark
                }
    
                // Store the updated quiz marks array as JSON
                $selection->quiz_marks = json_encode($existingQuizMarks);
    
                // Store the updated exam marks array as JSON
                $selection->exam_marks = json_encode($existingExamMarks);
    
                // Save the updated record
                $selection->save();
            }
        }
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Marks updated successfully.');
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
