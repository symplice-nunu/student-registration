@extends('layouts.app')

@section('content')
<div class="bg-[#d2ebd9] h-screen xl:p-10 lg:p-10 p-2">
    <div class="xl:flex lg:flex text-center">
        <div class="bg-[#e6feed] w-full xl:block hidden rounded-l-xl p-6 xl:px-[100px] lg:px-[100px] xl:py-[150px] lg:py-[150px] py-[117px] md:py-[245px]">
            <div class="flex justify-center">
                <img class="w-[200px]" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </div>
            <div>
                <h1 class="text-[25px]">SCHOOL MANAGEMENT SYSTEM</h1>
            </div>
        </div>
        <div class="bg-[#fafffa] w-full rounded-r-xl p-6 xl:px-[100px] lg:px-[100px] xl:py-[70px] lg:py-[70px] py-[35px] md:py-[165px]">
            <h1 class="text-[25px]"><span>SCHOOL </span><span class="text-[#66a277]">MANAGEMENT</span></h1>
            <form id="loginForm" method="POST" action="{{ route('register') }}" onsubmit="return validateForm()">
                @csrf
                <div class="text-left mt-12">
                    <label for="name" class="text-[#9a9b99] text-[13px]">Name</label>
                    <div>
                        <input type="text" class="border px-4 py-2 w-full text-black rounded" name="name" placeholder="John Doe" id="name">
                        @error('name')
                            <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="text-red-500" id="nameError"></small>
                    </div>
                </div>
                <div class="text-left mt-7">
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
                <div class="text-left mt-7">
                    <label for="password" class="text-[#9a9b99] text-[13px]">Password</label>
                    <div>
                        <input type="password" class="border px-4 py-2 w-full text-black rounded" name="password" placeholder="*******" id="password">
                        @error('password')
                            <span class="text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="text-red-500" id="passwordError"></small>
                    </div>
                </div>
                <div class="text-left mt-7">
                    <label for="password_confirmation" class="text-[#9a9b99] text-[13px]">Confirm Password</label>
                    <div>
                        <input type="password" class="border px-4 py-2 w-full text-black rounded" name="password_confirmation" placeholder="*******" id="password_confirmation">
                        <small class="text-red-500" id="confirmPasswordError"></small>
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="text-white text-[15px] bg-[#253237] w-full py-2 rounded">
                       Register
                    </button>
                </div>
                <div class="flex gap-2 justify-center my-8">
                    <div class="text-[#9a9b99] text-[13px]">Already have an account?</div>
                    <div class="text-[#66a277] text-[13px]">
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    
    let valid = true;

    // Validate Name
    if (name.value.trim() === '') {
        nameError.textContent = 'Name is required.';
        valid = false;
    } else {
        nameError.textContent = '';
    }

    // Validate Email
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (email.value.trim() === '') {
        emailError.textContent = 'Email is required.';
        valid = false;
    } else if (!emailRegex.test(email.value)) {
        emailError.textContent = 'Please enter a valid email address.';
        valid = false;
    } else {
        emailError.textContent = '';
    }

    // Validate Password
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
    if (password.value.trim() === '') {
        passwordError.textContent = 'Password is required.';
        valid = false;
    } else if (!passwordRegex.test(password.value)) {
        passwordError.textContent = 'Password must be at least 8 characters long and include letters and numbers.';
        valid = false;
    } else {
        passwordError.textContent = '';
    }

    // Validate Confirm Password
    if (confirmPassword.value.trim() === '') {
        confirmPasswordError.textContent = 'Please confirm your password.';
        valid = false;
    } else if (password.value !== confirmPassword.value) {
        confirmPasswordError.textContent = 'Passwords do not match.';
        valid = false;
    } else {
        confirmPasswordError.textContent = '';
    }

    return valid;
}
</script>
@endsection
