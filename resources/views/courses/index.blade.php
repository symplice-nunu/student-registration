@extends('layouts.app')

@section('content')
<div class="h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Course List</h1>

    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <div class="mb-4 text-end">
        <div>
            <a href="{{ route('courses.create') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">New Course</a>
            <a href="{{ route('courses.pdf') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 ml-2">Download PDF</a>
        </div>
        <div class="mt-4">
            <form action="{{ route('courses.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search by course name"
                    class="border rounded px-4 py-2 w-full md:w-1/4">
                <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                    Search
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left border-b">Course ID</th>
                    <th class="py-2 px-4 text-left border-b">Course Name</th>
                    <th class="py-2 px-4 text-left border-b">Max Points</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $course->courseID }}</td>
                        <td class="py-2 px-4 border-b">{{ $course->courseName }}</td>
                        <td class="py-2 px-4 border-b">{{ $course->maxPoints }}</td>
                        <td class="py-2 px-4 text-center border-b">
                            <a href="{{ route('courses.edit', $course->id) }}" class="text-white bg-blue-500 px-5 py-1 text-[10px] rounded">Edit</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-500 px-3 py-1 text-[10px] rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>
</div>
@endsection
