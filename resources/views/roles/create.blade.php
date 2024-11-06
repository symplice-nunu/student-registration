@extends('layouts.app')

@section('content')

<div class="py-4">
    <div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Créer un nouveau rôle</h2>
            <a href="{{ route('roles.index') }}" class="px-8 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600">Dos</a>
        </div>

        @if (count($errors) > 0)
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-200 rounded-lg">
                <strong>Whoops!</strong> Il y a eu quelques problèmes avec votre saisie.<br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <div class="form-group">
                    <label class="block text-gray-700 font-semibold mb-2" for="name">Nom:</label>
                    <input type="text" name="name" id="name" placeholder="Nom" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-teal-200" 
                        value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Autorisation:</label>
               <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 lg:grid-cols-4">
                    @foreach($permission as $value)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="mr-2">
                            <label class="text-gray-700">{{ $value->name }}</label>
                        </div>
                    @endforeach
               </div>
            </div>

            <div class="text-center">
                <button type="submit" class="px-10 py-2 w-full bg-teal-500 text-white rounded-lg font-semibold hover:bg-teal-600">Soumettre</button>
            </div>
        </form>
    </div>
</div>

@endsection
