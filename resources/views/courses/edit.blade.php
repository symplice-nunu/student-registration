@extends('layouts.app')

@section('content')
<div class="h-screen">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Course</h2>

        <!-- {{-- Display general validation errors --}}
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        {{-- Edit course form --}}
        <form action="{{ route('courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Course ID (read-only) --}}
            <div class="mb-4">
                <label for="courseID" class="block text-gray-700 font-bold mb-2">Course ID</label>
                <input type="text" name="courseID" id="courseID" class="border rounded px-4 py-2 w-full bg-gray-100"
                    value="{{ $course->courseID }}" readonly>
            </div>

            {{-- Course Name field --}}
            <div class="mb-4">
                <label for="courseName" class="block text-gray-700 font-bold mb-2">Course Name</label>
                <input type="text" name="courseName" id="courseName" class="border rounded px-4 py-2 w-full"
                    value="{{ old('courseName', $course->courseName) }}">
                
                {{-- Display error for courseName --}}
                @if ($errors->has('courseName'))
                    <span class="text-red-500 text-sm">{{ $errors->first('courseName') }}</span>
                @endif
            </div>

            {{-- Max Points field --}}
            <div class="mb-4">
                <label for="maxPoints" class="block text-gray-700 font-bold mb-2">Max Points</label>
                <input type="number" name="maxPoints" id="maxPoints" class="border rounded px-4 py-2 w-full"
                    value="{{ old('maxPoints', $course->maxPoints) }}">
                
                {{-- Display error for maxPoints --}}
                @if ($errors->has('maxPoints'))
                    <span class="text-red-500 text-sm">{{ $errors->first('maxPoints') }}</span>
                @endif
            </div>

            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 w-full">
                Update Course
            </button>
        </form>
    </div>
</div>
@endsection
