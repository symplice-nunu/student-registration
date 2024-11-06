@extends('layouts.app')

@section('content')

<div class="py-3 px-2">
    <div class="max-w-4xl  mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Afficher le rôle</h2>
            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600">Dos</a>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Nom:</h3>
                <p class="text-gray-600">{{ $role->name }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Autorisations:</h3>
                <div class="flex flex-wrap gap-2 mt-2">
                    @if (!empty($rolePermissions))
                        @foreach ($rolePermissions as $v)
                            <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full font-semibold">{{ $v->name }}</span>
                        @endforeach
                    @else
                        <p class="text-gray-600">Aucune autorisation attribuée</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
