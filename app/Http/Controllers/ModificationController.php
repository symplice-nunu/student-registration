<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Selection;
use App\Models\Course;

class ModificationController extends Controller
{
    /**
     * Retrieve all data from the selections table.
     */
    public function getAllSelections()
    {
        // Retrieve all records from the selections table
        $allSelections = Selection::all();

        // Return the data to a view
        return view('assign.allSelections', [
            'selections' => $allSelections,
        ]);
    }
    public function updateCourseNames(Request $request, $id)
    {
        $selection = Selection::findOrFail($id);
        $selection->course_names = $request->course_names;
        $selection->save();

        return response()->json(['success' => true]);
    }
    public function showSelections()
{
    $selections = Selection::all();
    $allCourses = Course::select('courseName')->get();

    return view('assign.selections', [
        'selections' => $selections,
        'allCourses' => $allCourses,
    ]);
}
}
