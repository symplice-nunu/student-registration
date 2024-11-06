<!-- resources/views/assign/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-5">
    <h1 class="text-lg font-bold mb-4">Edit Selection</h1>
    <form action="{{ route('selections.update', $selection->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="student_name">Student Name</label>
        <select name="student_name" id="student_name" class="border px-4 py-2 mb-4 w-full">
            @foreach ($students as $student)
                <option value="{{ $student->name }}" {{ $student->name == $selection->student_name ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
            @endforeach
        </select>

        <label for="class_name">Class</label>
        <select name="class_name" id="class_name" class="border px-4 py-2 mb-4 w-full">
            @foreach ($classes as $class)
                <option value="{{ $class->className }}" {{ $class->className == $selection->class_name ? 'selected' : '' }}>
                    {{ $class->className }}
                </option>
            @endforeach
        </select>

        <label for="course_names">Course</label>
        <select name="course_names[]" id="course_names" multiple class="border px-4 py-2 mb-4 w-full">
            @foreach ($courses as $course)
                <option value="{{ $course->courseName }}" 
                    {{ in_array($course->courseName, explode(',', $selection->course_names)) ? 'selected' : '' }}>
                    {{ $course->courseName }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded">Update Selection</button>
    </form>
</div>
@endsection
