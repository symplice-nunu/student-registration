@extends('layouts.app')
@section('content')
<div class="p-4 h-screen">
  <div class="text-center">
      <h1 class="text-[25px]">Users Management</h1>
  </div>
  <div class="text-right mb-5">
    <a class="bg-black text-white rounded-md px-6 py-3" href="{{ route('users.create') }}"> Create New User</a>
  </div>
  @if ($message = Session::get('success'))
  <div class="text-green-500 text-center pb-3">
    <p>{{ $message }}</p>
  </div>
  @endif
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
          <div>
            <a class="text-[12px] text-green-600 font-bold" href="{{ route('users.show',$user->id) }}">Show</a>
          </div>
          <div>
            <a class="text-[12px] text-blue-600 font-bold" href="{{ route('users.edit',$user->id) }}">Edit</a>
          </div>
          <div>
            <a class="text-[12px] text-red-600 font-bold" href="{{ route('users.destroy',$user->id) }}">Delete</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mt-4">
  {!! $data->render() !!}
    </div>
</div>
@endsection