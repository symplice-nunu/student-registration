@extends('layouts.app')

@section('content')
<div class="bg-[#d2ebd9] h-screen xl:p-10 lg:p-10 p-2">
    <div class="xl:flex lg:flex text-center">
        <div class="bg-[#e6feed] w-full xl:block hidden rounded-l-xl p-6">sfdsf</div>
        <div class="bg-[#fafffa] w-full rounded-r-xl p-6 xl:px-[100px] lg:px-[100px] xl:py-[150px] lg:py-[150px] py-[117px] md:py-[245px]">
            <h1 class="text-[25px]"><span>SCHOOL </span><span class="text-[#66a277]">MANAGEMENT</span></h1>
            <div class="text-left mt-12">
                <label for="" class="text-[#9a9b99] text-[13px]">Email</label>
                <div>
                    <input type="email" class="border px-4 py-2 w-full text-black rounded" name="" placeholder="johnnana@gmail.com" id="">
                </div>
            </div>
            <div class="text-left mt-7">
                <label for="" class="text-[#9a9b99] text-[13px]">Password</label>
                <div>
                    <input type="password" class="border px-4 py-2 w-full text-black rounded" name="" placeholder="*******" id="">
                </div>
            </div>
            <div class="text-right mt-1">
                <div class="text-[#66a277] text-[13px]">
                   Forgot Password?
                </div>
            </div>
            <div class=" mt-8">
                <button class="text-white text-[15px] bg-[#253237] w-full py-2 rounded">
                   Sign in
                </button>
            </div>
            <div class="flex gap-2 justify-center my-8">
                <div class="text-[#9a9b99] text-[13px]">Are you new?</div>
                <div class="text-[#66a277] text-[13px]">
                   Create an Account
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
