@extends('layouts.app')
@section('content')

<div class="py-2 px-2">
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="xl:max-w-xl lg:max-w-xl mx-auto bg-white shadow-lg rounded-lg p-8">
        @csrf
        @method('PATCH')

        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Modifier l'utilisateur</h2>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nom/Prenom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Nom/Prenom">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="E-mail">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Mot de passe</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Mot de passe">
        </div>

        <div class="mb-4">
            <label for="confirm-password" class="block text-sm font-medium text-gray-600 mb-1">Confirmez le mot de passe</label>
            <input type="password" name="confirm-password" id="confirm-password" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" placeholder="Confirmez le mot de passe">
        </div>

        <div class="mb-4">
            <label for="roles" class="block text-sm font-medium text-gray-600 mb-1">Rôle</label>
            <select name="roles[]" id="roles" class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-2 bg-teal-500 text-white rounded-lg font-semibold hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 w-full">Soumettre</button>
        </div>
    </form>
</div>
@endsection
