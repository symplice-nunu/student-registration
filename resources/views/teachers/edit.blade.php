@extends('layouts.app')

@section('content')
<div class="max-w-2xl h-screen mx-auto p-4">
    <h1 class="text-2xl font-bold text-center mb-4">Edit Teacher</h1>
    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $teacher->name) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('name'))
                <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="DOB" class="block text-gray-700 text-sm font-bold mb-2">Date of Birth:</label>
            <input type="date" id="DOB" name="DOB" value="{{ old('DOB', $teacher->DOB) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('DOB'))
                <span class="text-red-500 text-sm">{{ $errors->first('DOB') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $teacher->email) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('email'))
                <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
            <textarea id="address" name="address"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('address', $teacher->address) }}</textarea>
            @if ($errors->has('address'))
                <span class="text-red-500 text-sm">{{ $errors->first('address') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <label for="phoneNumber" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber', $teacher->phoneNumber) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @if ($errors->has('phoneNumber'))
                <span class="text-red-500 text-sm">{{ $errors->first('phoneNumber') }}</span>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Teacher
            </button>
        </div>
    </form>
</div>
@endsection
