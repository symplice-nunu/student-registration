@extends('layouts.app')

@section('content')
<div class="max-w-2xl h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Create New Class</h1>

    <!-- Display success message if class is created successfully -->
    @if (session('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Class creation form -->
    <form action="{{ route('classes.store') }}" method="POST">
        @csrf

        <!-- Class Name Field -->
        <div class="mb-4">
            <label for="className" class="block text-gray-700">Class Name</label>
            <input type="text" name="className" id="className" class="border rounded px-4 py-2 w-full" value="{{ old('className') }}">
            @if ($errors->has('className'))
                <span class="text-red-500 text-sm">{{ $errors->first('className') }}</span>
            @endif
        </div>

        <!-- Teacher ID Field (Nullable) -->
        <div class="mb-4">
            <label for="teacherID" class="block text-gray-700">Teacher</label>
            <select name="teacherID" id="teacherID" class="border rounded px-4 py-2 w-full">
                <option value="">Select a Teacher</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->teacherID }}" {{ old('teacherID') == $teacher->teacherID ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('teacherID'))
                <span class="text-red-500 text-sm">{{ $errors->first('teacherID') }}</span>
            @endif
        </div>

        <!-- Schedule Field -->
        <div class="mb-4">
            <label for="schedule" class="block text-gray-700">Schedule</label>
            <input type="text" name="schedule" id="schedule" class="border rounded px-4 py-2 w-full" value="{{ old('schedule') }}">
            @if ($errors->has('schedule'))
                <span class="text-red-500 text-sm">{{ $errors->first('schedule') }}</span>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
            Create Class
        </button>
    </form>
</div>
@endsection
