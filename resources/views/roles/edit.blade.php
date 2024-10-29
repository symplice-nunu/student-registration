@extends('layouts.app')

@section('content')

<div class="py-4">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Edit Role</h2>
            <a href="{{ route('roles.index') }}" class="px-8 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600">Back</a>
        </div>

        @if (count($errors) > 0)
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-200 rounded-lg">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PATCH')
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold" for="name">
                        <strong>Name:</strong>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="Name" class="mt-1 px-4 py-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-teal-200" />
                </div>

                <div>
                    <strong class="block text-gray-700 font-semibold">Permission:</strong>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 lg:grid-cols-4">
                        @foreach($permission as $value)
                            <label class="flex items-center">
                                <input type="checkbox" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500" />
                                <span class="ml-2 text-gray-700">{{ $value->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="px-4 py-2 w-full bg-teal-500 text-white rounded-lg font-semibold hover:bg-teal-600">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
