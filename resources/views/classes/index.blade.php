@extends('layouts.app')

@section('content')
<div class="h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Class List</h1>

    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <div class="mb-4 text-end">
        <div>
        @can('class-create')
            <a href="{{ route('classes.create') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">New Class</a>
            <a href="{{ route('classes.pdf') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 ml-2">Download PDF</a>
            @endcan
        </div>
       <div class="mt-4">
        <form action="{{ route('classes.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search by class name or teacher ID"
                    class="border rounded px-4 py-2 w-full md:w-1/4">
                <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                    Search
                </button>
            </form>
       </div>
    </div>


    @can('class-list')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left border-b">Class ID</th>
                    <th class="py-2 px-4 text-left border-b">Class Name</th>
                    <th class="py-2 px-4 text-left border-b">Teacher ID</th>
                    <th class="py-2 px-4 text-left border-b">Schedule</th>
                    @can('class-edit')
                    <th class="py-2 px-4 text-center border-b">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $class->classID }}</td>
                        <td class="py-2 px-4 border-b">{{ $class->className }}</td>
                        <td class="py-2 px-4 border-b">{{ $class->teacherID }}</td>
                        <td class="py-2 px-4 border-b">{{ $class->schedule }}</td>
                        @can('class-edit')
                        <td class="py-2 px-4 border-b">
                            @can('class-edit')
                            <a href="{{ route('classes.edit', $class->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            @endcan
                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                @can('class-delete')
                                <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                @endcan
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endcan

    <div class="mt-4">
        {{ $classes->links() }}
    </div>
</div>
@endsection
