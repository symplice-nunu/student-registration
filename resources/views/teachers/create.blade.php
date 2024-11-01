@extends('layouts.app')

@section('content')
<div class="h-screen max-w-4xl mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Add New Teacher</h1>

    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" id="name" name="name" 
                class="border rounded px-4 py-2 w-full @error('name') border-red-500 @enderror" 
                value="{{ old('name') }}" >
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="DOB" class="block text-gray-700">Date of Birth:</label>
            <input type="date" id="DOB" name="DOB" 
                class="border rounded px-4 py-2 w-full @error('DOB') border-red-500 @enderror" 
                value="{{ old('DOB') }}" >
            @error('DOB')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" 
                class="border rounded px-4 py-2 w-full @error('email') border-red-500 @enderror" 
                value="{{ old('email') }}" >
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phoneNumber" class="block text-gray-700">Phone Number:</label>
            <input type="text" id="phoneNumber" name="phoneNumber" 
                class="border rounded px-4 py-2 w-full @error('phoneNumber') border-red-500 @enderror" 
                value="{{ old('phoneNumber') }}" >
            @error('phoneNumber')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address:</label>
            <input type="text" id="address" name="address" 
                class="border rounded px-4 py-2 w-full @error('address') border-red-500 @enderror" 
                value="{{ old('address') }}">
            @error('address')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="createUser" class="flex items-center">
                <input type="checkbox" id="createUser" name="createUser" class="mr-2">
                <span class="text-gray-700">Create a user account with default password?</span>
            </label>
        </div>

        <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600">
            Add Teacher
        </button>
    </form>
</div>
@endsection
