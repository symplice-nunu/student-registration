@extends('layouts.app')

@section('content')
<div class="max-w-2xl h-screen mx-auto p-4">
    <h1 class="text-2xl font-bold text-center mb-4">Modifier l'étudiant</h1>
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('name'))
                <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="dateOfBirth" class="block text-gray-700 text-sm font-bold mb-2">Date de naissance:</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" value="{{ old('dateOfBirth', $student->dateOfBirth) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('dateOfBirth'))
                <span class="text-red-500 text-sm">{{ $errors->first('dateOfBirth') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('email'))
                <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Addresse:</label>
            <textarea id="address" name="address"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('address', $student->address) }}</textarea>
            @if ($errors->has('address'))
                <span class="text-red-500 text-sm">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="phoneNumber" class="block text-gray-700 text-sm font-bold mb-2">Numéro de téléphone:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber', $student->phoneNumber) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('phoneNumber'))
                <span class="text-red-500 text-sm">{{ $errors->first('phoneNumber') }}</span>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Mise à jour de l'étudiant
            </button>
        </div>
    </form>
</div>
@endsection
