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
            'email' => 'nullable|string',
        ]);
        $students = Student::get();
        foreach($students as $student){
           if($student->name == $request->selected_student){
        $email = $student->email;
           }
        }
        // Save the selection to the database
        Selection::create([
            'student_name' => $request->selected_student,
            'class_name' => $request->selected_class,
            'email' => $email,
            'course_names' => $request->selected_courses, // Assuming you store this as a comma-separated string
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Courses Assigned Successfully.');
    }

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
        // Fetch distinct student names and related data from selections table
        $studentNames = Selection::select('student_name', 'course_names', 'id', 'quiz_marks', 'exam_marks')
                                ->distinct()
                                ->get();
    
        // Calculate the sum of quiz marks and exam marks for each course for each student
        foreach ($studentNames as $student) {
            $quizMarksArray = json_decode($student->quiz_marks, true) ?: [];
            $examMarksArray = json_decode($student->exam_marks, true) ?: [];
    
            $totalQuizMarksByCourse = [];
            $totalExamMarksByCourse = [];
    
            // Sum quiz marks for each course
            foreach ($quizMarksArray as $course => $marks) {
                if (is_array($marks)) {
                    $totalQuizMarksByCourse[$course] = array_sum(array_filter($marks, fn($mark) => $mark !== null));
                }
            }
    
            // Sum exam marks for each course
            foreach ($examMarksArray as $course => $marks) {
                if (is_array($marks)) {
                    $totalExamMarksByCourse[$course] = array_sum(array_filter($marks, fn($mark) => $mark !== null));
                }
            }
    
            // Assign the calculated totals to the student object for view use
            $student->total_quiz_marks_by_course = $totalQuizMarksByCourse;
            $student->total_exam_marks_by_course = $totalExamMarksByCourse;
        }
    
        // Pass the student names and their total marks by course to the view
        return view('assign.marks', [
            'studentNames' => $studentNames,
        ]);
    }


    public function updateMarks(Request $request)
    {
        // Validate the input data
        $request->validate([
            'students.*.quiz_marks' => 'array',  // Array of quiz marks by course
            'students.*.exam_marks' => 'array',  // Array of exam marks by course
            'students.*.quiz_marks.*' => 'nullable|integer|min:0|max:100',  // Individual quiz mark
            'students.*.exam_marks.*' => 'nullable|integer|min:0|max:100',  // Individual exam mark
        ]);

        // Get the students' data from the form
        $studentsData = $request->input('students');

        // Update the selection marks for all students
        foreach ($studentsData as $studentId => $studentMarks) {
            $selection = Selection::find($studentId); // Find the selection by student ID

            if ($selection) {
                // Decode existing marks; if null, set to empty array
                $existingQuizMarks = json_decode($selection->quiz_marks, true);
                $existingQuizMarks = is_array($existingQuizMarks) ? $existingQuizMarks : [];

                $existingExamMarks = json_decode($selection->exam_marks, true);
                $existingExamMarks = is_array($existingExamMarks) ? $existingExamMarks : [];

                // Add or append quiz marks for each course, filtering out null values
                if (isset($studentMarks['quiz_marks'])) {
                    foreach ($studentMarks['quiz_marks'] as $course => $quizMark) {
                        // Ensure each course has an array to hold multiple marks
                        if (!isset($existingQuizMarks[$course]) || !is_array($existingQuizMarks[$course])) {
                            $existingQuizMarks[$course] = [];
                        }
                        // Append the new quiz mark to the array only if it is not null
                        if (!is_null($quizMark)) {
                            $existingQuizMarks[$course][] = $quizMark;
                        }
                    }
                }

                // Add or append exam marks for each course, filtering out null values
                if (isset($studentMarks['exam_marks'])) {
                    foreach ($studentMarks['exam_marks'] as $course => $examMark) {
                        // Ensure each course has an array to hold multiple marks
                        if (!isset($existingExamMarks[$course]) || !is_array($existingExamMarks[$course])) {
                            $existingExamMarks[$course] = [];
                        }
                        // Append the new exam mark to the array only if it is not null
                        if (!is_null($examMark)) {
                            $existingExamMarks[$course][] = $examMark;
                        }
                    }
                }

                // Store the updated marks as JSON
                $selection->quiz_marks = json_encode($existingQuizMarks);
                $selection->exam_marks = json_encode($existingExamMarks);

                // Save the updated record
                $selection->save();
            }
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Marks updated successfully.');
    }



    
}
