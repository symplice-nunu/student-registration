<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>School Management System</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Scripts -->
    @vite('resources/css/app.css')
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>
<body>
    <div id="app">
    @guest
    @if (Route::has('login'))
    @endif
    @if (Route::has('register'))
    @endif
    @else
        <div class="flex">

            <!-- Sidebar Menu (hidden by default on mobile) -->
            <div id="sidebarMenu" class="bg-black text-white py-8 px-5 w-[310px] hidden xl:block lg:block">
                <div class="flex gap-2">
                    <div>
                        <img class="w-[30px]" src="{{ asset('assets/images/logo.png') }}" alt="logo">
                    </div>
                    <div class="mt-2">SMS</div>
                </div>
                <div class="text-[#d4d4d4] pt-9">MAIN MENU</div>

                <a href="{{ route('home') }}">
                    <div class="mt-4 px-3 rounded py-2 {{ request()->routeIs('home') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Dashboard
                    </div>
                </a>
                <a href="{{ route('users.index') }}">
                    <div class="px-3 rounded py-2 {{ request()->routeIs('users.index') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Users
                    </div>
                </a>
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <div class="px-3 rounded py-2 {{ request()->routeIs('roles.index') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Role
                    </div>
                </a>
                <a class="nav-link" href="{{ route('students.index') }}">
                    <div class="px-3 rounded py-2 {{ request()->routeIs('students.index') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Student
                    </div>
                </a>
                <a class="nav-link" href="{{ route('teachers.index') }}">
                    <div class="px-3 rounded py-2 {{ request()->routeIs('teachers.index') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Teacher
                    </div>
                </a>
                <a class="nav-link" href="{{ route('classes.index') }}">
                    <div class="px-3 rounded py-2 {{ request()->routeIs('classes.index') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Class
                    </div>
                </a>
                <a class="nav-link" href="{{ route('documents.list') }}">
                    <div class="px-3 rounded py-2 {{ request()->routeIs('documents.list') ? 'bg-white text-black' : 'text-white' }} hover:bg-white hover:text-black">Document
                    </div>
                </a>
            </div>
            <div class=" w-full">
               <div class="py-2 pr-4 flex gap-1 justify-between xl:justify-end lg:text-right bg-[#f3f3fa]">

                    <!-- Hamburger Icon -->
                    <div class="block xl:hidden lg:hidden px-5 py-1">
                        <button id="hamburger" class="text-black">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex">
                        <div>
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <button @click="open = !open" class="px-4 mt-1">
                                    {{ Auth::user()->name }}
                                </button>

                                <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false" 
                                    class="absolute right-0 mt-1 w-48 py-2 bg-white border border-gray-200 rounded shadow-lg z-20">
                                    <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" 
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <img class="w-[30px] rounded-full" src="{{ asset('assets/images/profile.jpg') }}" alt="logo">
                        </div>
                    </div>
               </div>
               <div class="border"></div>
                @endguest
                <div class="min-h-screen flex flex-col">
                    <div>
                        <main class="bg-[#f4f4f6] flex-grow">
                            @yield('content')
                            <!-- <footer class="fixed bottom-0 left-0 w-full text-center py-4 bg-[#f3f3fa] text-gray-600 text-sm">
                                &copy; {{ now()->year }} School Management System. All rights reserved.
                            </footer> -->
                        </main>
                    </div>
                </div>
            </div>
        </div> 
    <script>
        document.getElementById("hamburger").addEventListener("click", function() {
            const menu = document.getElementById("sidebarMenu");
            menu.classList.toggle("hidden");
        });
    </script>
   
    </div>
</body>
</html>