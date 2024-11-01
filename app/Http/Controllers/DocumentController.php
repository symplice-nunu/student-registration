<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document; // Ensure you have a Document model
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function showUploadForm()
    {
        return view('documents.upload');
    }

    public function listUploadedDocuments()
    {
        $documents = Document::paginate(10);
        return view('documents.uploaded_list', compact('documents'));
    }
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Adjust as needed
        ]);

        // Store the file in the 'documents' directory within the storage folder
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('documents', 'public'); // Store in 'storage/app/public/documents'

            // Save the document details to the database
            Document::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);

            return redirect()->route('documents.upload')->with('success', 'Document uploaded successfully.');
        }

        return redirect()->back()->withErrors(['document' => 'Failed to upload document.']);
    }

    public function destroy($id)
    {
        // Find the document
        $document = Document::findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete($document->path);

        // Delete the document record from the database
        $document->delete();

        return redirect()->route('documents.list')->with('success', 'Document deleted successfully.');
    }

}

