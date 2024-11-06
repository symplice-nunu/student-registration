@extends('layouts.app')

@section('content')
<div class="px-4 py-6 max-w-2xl mx-auto">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Créer un nouvel utilisateur</h1>
    </div>
    
    @if (count($errors) > 0)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom/Prenom</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Nom/Prenom" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="E-mail" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Mot de passe" required>
        </div>

        <div class="mb-4">
            <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirmez le mot de passe</label>
            <input type="password" name="confirm-password" id="confirm-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Confirmez le mot de passe" required>
        </div>

        <div class="mb-6">
            <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
            <select name="roles[]" id="roles" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-2 bg-teal-500 w-full text-white rounded-lg font-semibold hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">Soumettre</button>
        </div>
    </form>
</div>
@endsection
