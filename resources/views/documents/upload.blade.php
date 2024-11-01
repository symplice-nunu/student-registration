@extends('layouts.app')

@section('content')
<div class=" max-w-2xl h-screen mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Upload Document</h1>

    <!-- Success Message -->
    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Document Upload Form -->
    <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="document" class="block text-gray-700">Select Document</label>
            <input type="file" name="document" id="document" class="border rounded px-4 py-2 w-full" required>
        </div>
        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">Upload</button>
    </form>

    <div class="mt-4">
        <a href="{{ route('documents.list') }}" class="text-blue-600 hover:underline">View Uploaded Documents</a>
    </div>
</div>
@endsection
