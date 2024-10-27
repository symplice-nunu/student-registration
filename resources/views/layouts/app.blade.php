<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

  

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

  

    <title>School Management System</title>

  

    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  

    <!-- Scripts -->
    @vite('resources/css/app.css')
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->

</head>

<body>

    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

            <div class="container">

                

  

                

  

                    <!-- Right Side Of Navbar -->

                        <!-- Authentication Links -->

                        @guest

                            @if (Route::has('login'))

                                <!-- <li class="nav-item">

                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>

                                </li> -->

                            @endif

  

                            @if (Route::has('register'))
<!-- 
                                <li class="nav-item">

                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>

                                </li> -->

                            @endif

                        @else

                        <ul class="navbar-nav ms-auto">

                            <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>

                            <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Role</a></li>

                            <li><a class="nav-link" href="{{ route('students.index') }}">Manage Product</a></li>

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                    {{ Auth::user()->name }}

                                </a>

  

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('logout') }}"

                                       onclick="event.preventDefault();

                                                     document.getElementById('logout-form').submit();">

                                        {{ __('Logout') }}

                                    </a>

  

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">

                                        @csrf

                                    </form>

                                </div>

                            </li>

                    </ul>

                        @endguest

                </div>

            </div>

        </nav>

  

        <main class="">

            <div class="">

                <div class="row justify-content-center">

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body">

                                @yield('content')

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </main>

          

    </div>

</body>

</html>