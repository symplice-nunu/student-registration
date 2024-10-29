@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Role Management</h2>
            <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-teal-500 text-white rounded-lg font-semibold hover:bg-teal-600">Create New Role</a>
     
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-200 rounded-lg">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="text-left border-b border-gray-200">
                    <th class="px-4 py-2 text-gray-600 font-semibold">No</th>
                    <th class="px-4 py-2 text-gray-600 font-semibold">Name</th>
                    <th class="px-4 py-2 text-gray-600 font-semibold w-60">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-700">{{ ++$i }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $role->name }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('roles.show', $role->id) }}" class="px-3 py-1 bg-blue-500 text-white text-[12px] rounded-lg hover:bg-blue-600">Show</a>
                                
                                    <a href="{{ route('roles.edit', $role->id) }}" class="px-3 py-1 bg-indigo-500 text-white text-[12px] rounded-lg hover:bg-indigo-600">Edit</a>
                                @can('role-edit')
                                @endcan
                                @can('Admin')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'class' => 'inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 cursor-pointer']) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {!! $roles->links() !!}
    </div>

</div>

@endsection
