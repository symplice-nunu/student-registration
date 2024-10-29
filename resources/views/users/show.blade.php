@extends('layouts.app')
@section('content')
<div class="xl:p-[100px] p-2 h-screen">
    <div class="">
        <div class="text-center">
            <h1 class="text-[25px]">User Details</h1>
        </div>
        <div class="text-right mb-5">
            <a class="bg-black text-white rounded-md px-6 py-3" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
    <div class="bg-black text-white p-1 rounded-md">
        <div class="">
            <img class="h-[300px] w-full object-cover" src="{{ asset('assets/images/profile.jpg') }}" alt="logo">
        </div>
        <div class="px-3 py-2">
          <div class="text-[13px]">
            <div>{{ $user->name }}</div>
            <div>{{ $user->email }}</div>
            @if(!empty($user->getRoleNames()))
              @foreach($user->getRoleNames() as $v)
                <div>{{ $v }}</div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
</div>
@endsection