@extends('layouts.app')
@section('content')
<div class="p-4 h-screen">
  <div class="text-center">
      <h1 class="text-[25px]">Gestion des utilisateurs</h1>
  </div>
  @can('users-create')
  <div class="text-right mb-5">
    <a class="bg-black text-white rounded-md px-6 py-3" href="{{ route('users.create') }}"> Créer un nouvel utilisateur</a>
  </div>
  @endcan
  @if ($message = Session::get('success'))
  <div class="text-green-500 text-center pb-3">
    <p>{{ $message }}</p>
  </div>
  @endif
  @can('users-list')
  <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 lg:grid-cols-4 gap-2">
    @foreach ($data as $key => $user)
      <div class="bg-black text-white p-1 rounded-md">
        <div class="">
            <img class="h-[170px] w-full object-cover" src="{{ asset('assets/images/profile.jpg') }}" alt="logo">
        </div>
        <div class="flex justify-between px-3 py-2">
          <div class="text-[13px]">
            <div>{{ $user->name }}</div>
            <div>{{ $user->email }}</div>
              @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                  <div>{{ $v }}</div>
                @endforeach
              @endif
          </div>
          <div class="text-[25px] font-bold mt-1">{{ ++$i }}</div>
        </div>
        <div class="flex justify-end gap-2 px-3 pb-2">
        @can('users-edit')
          <div>
            <a class="text-[12px] text-green-600 font-bold" href="{{ route('users.show',$user->id) }}">Montrer</a>
          </div>
          <div>
            <a class="text-[12px] text-blue-600 font-bold" href="{{ route('users.edit',$user->id) }}">Modifier</a>
          </div>
          @endcan
          @can('users-delete')
          <div>
            <a class="text-[12px] text-red-600 font-bold" href="{{ route('users.destroy',$user->id) }}">Supprimer</a>
          </div>
          @endcan
        </div>
      </div>
    @endforeach
  </div>

  @endcan
  <div class="mt-4">
  {!! $data->render() !!}
    </div>
</div>
@endsection