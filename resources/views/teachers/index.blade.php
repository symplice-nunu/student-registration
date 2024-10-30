@extends('layouts.app')

@section('content')
<div class="h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Teacher List</h1>

    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <!-- Create New Teacher Button -->
    <div class="mb-4 text-end">
        <a href="{{ route('teachers.create') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
            New Teacher
        </a>
        <a href="{{ route('teachers.pdf') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 ml-2">
            PDF Report
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-4 text-right">
        <form action="{{ route('teachers.index') }}" method="GET">
            <input type="text" name="search" placeholder="Search by name or email"
                class="border rounded px-4 py-2 w-full md:w-1/4">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b">No</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Date of Birth</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Phone Number</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ ++$i }}</td>
                        <td class="py-2 px-4 border-b">{{ $teacher->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $teacher->DOB }}</td>
                        <td class="py-2 px-4 border-b">{{ $teacher->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $teacher->phoneNumber }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('teachers.edit', $teacher->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $teachers->links() }}
    </div>
</div>
@endsection
