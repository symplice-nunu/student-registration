@extends('layouts.app')

@section('content')
<div class="bg-[#d2ebd9] h-screen xl:p-10 lg:p-10 p-2">
    <div class="xl:flex lg:flex text-center">
        <div class="bg-[#e6feed] w-full xl:block hidden rounded-l-xl p-6 xl:px-[100px] lg:px-[100px] xl:py-[150px] lg:py-[150px] py-[30px] md:py-[45px]">
            <div class="flex justify-center">
                <img class="w-[200px]" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </div>
            <div>
                <h1 class="text-[25px]">SCHOOL MANAGEMENT SYSTEM</h1>
            </div>
        </div>
        <div class="bg-[#fafffa] w-full rounded-r-xl p-6 xl:px-[100px] lg:px-[250px] xl:py-[250px] lg:py-[150px] py-[117px] md:py-[245px]">
            <h1 class="text-[25px]"><span>SCHOOL </span><span class="text-[#66a277]">MANAGEMENT</span></h1>
            @if (session('status'))
            <div class="text-green-500" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form id="resetForm" method="POST" action="{{ route('password.email') }}" onsubmit="return validateForm()">
                @csrf
                <div class="text-left mt-12">
                    <label for="email" class="text-[#9a9b99] text-[13px]">Email</label>
                    <div>
                        <input type="email" class="border px-4 py-2 w-full text-black rounded" name="email" placeholder="johnnana@gmail.com" id="email">
                        @error('email')
                            <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="text-red-500" id="emailError"></small>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="text-white text-[15px] bg-[#253237] w-full py-2 rounded">
                       Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    let valid = true;

    // Check if email is empty
    if (email.value.trim() === '') {
        emailError.textContent = 'Email is required.';
        valid = false;
    } else {
        emailError.textContent = '';
    }

    // Email Regex: Standard email pattern
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email.value && !emailRegex.test(email.value)) {
        emailError.textContent = 'Please enter a valid email address.';
        valid = false;
    }

    return valid; // Return true if valid, false otherwise
}
</script>
@endsection
