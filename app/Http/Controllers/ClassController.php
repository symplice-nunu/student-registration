<?php

namespace App\Http\Controllers;

use App\Models\Classe; // Import the Class model
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::query();

        // Search functionality (if required)
        if ($request->filled('search')) {
            $classes->where('className', 'like', '%' . $request->search . '%');
        }

        $classes = $classes->paginate(10);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::select('teacherID', 'name')->get(); // Retrieve teacher IDs and names
        return view('classes.create', compact('teachers'));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'className' => 'required|string|max:255',
            'teacherID' => 'required|string|max:255',
            'schedule' => 'required|string|max:500',
        ]);

        Classe::create($request->all());
        return redirect()->route('classes.index')
                         ->with('success', 'Class created successfully.');
    }

    public function edit(Classe $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, Classe $class): RedirectResponse
    {
        $request->validate([
            'className' => 'required|string|max:255',
            'teacherID' => 'nullable|string|max:255',
            'schedule' => 'required|string|max:500',
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')
                         ->with('success', 'Class updated successfully.');
    }

    public function destroy(Classe $class): RedirectResponse
    {
        $class->delete();

        return redirect()->route('classes.index')
                         ->with('success', 'Class deleted successfully.');
    }
    public function generatePdf()
    {
        $classes = Classe::all(); // Get all class records

        // Generate PDF from a view
        $pdf = Pdf::loadView('classes.pdf', compact('classes'));

        // Return the generated PDF for download
        return $pdf->download('class_list.pdf');
    }
}

