@extends('layouts.app')

@section('content')
<div class="max-w-3xl h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Edit Class</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classes.update', $class->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="className" class="block text-gray-700">Class Name</label>
            <input type="text" name="className" id="className" value="{{ $class->className }}" class="border rounded px-4 py-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="teacherID" class="block text-gray-700">Teacher ID (optional)</label>
            <input type="text" name="teacherID" id="teacherID" value="{{ $class->teacherID }}" class="border rounded px-4 py-2 w-full">
        </div>

        <div class="mb-4">
            <label for="schedule" class="block text-gray-700">Schedule</label>
            <input type="text" name="schedule" id="schedule" value="{{ $class->schedule }}" class="border rounded px-4 py-2 w-full" required>
        </div>

        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">Update Class</button>
    </form>
</div>
@endsection
