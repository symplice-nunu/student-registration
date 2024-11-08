@extends('layouts.app')

@section('content')
<div class="h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Liste des étudiants</h1>
    
    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <!-- Create New Student Button -->
     @can('student-create')
    <div class="mb-4 text-end">
        <a href="{{ route('students.create') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
            Nouvel étudiant
        </a>
        <a href="{{ route('students.pdf') }}" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 ml-2">
            Rapport PDF
        </a>

    </div>
    @endcan


    <!-- Search Form -->
    <div class="mb-4 text-right">
        <form action="{{ route('students.index') }}" method="GET">
            <input type="text" name="search" placeholder="rechercher par nom ou email"
                class="border rounded px-4 py-2 w-full md:w-1/4">
            <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
                Recherche
            </button>
        </form>
    </div>

    @can('student-list')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left border-b">No</th>
                    <th class="py-2 px-4 text-left border-b">Nom</th>
                    <th class="py-2 px-4 text-left border-b">Date de naissance</th>
                    <th class="py-2 px-4 text-left border-b">Email</th>
                    <th class="py-2 px-4 text-left border-b">Adresse</th>
                    <th class="py-2 px-4 text-left border-b">Numéro de téléphone</th>
                    @can('student-edit')
                    <th class="py-2 px-4 text-center border-b">Actes</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ ++$i }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->dateOfBirth }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->address }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->phoneNumber }}</td>
                        @can('student-edit')
                        <td class="py-2 px-4 border-b">
                        @can('student-edit')
                            <a href="{{ route('students.edit', $student->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            @endcan
                            @can('student-delete')
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                            </form>
                            @endcan
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endcan

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection
