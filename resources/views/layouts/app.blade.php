<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="flex justify-between bg-gray-900 text-white w-screen">
            <div class="px-5 xl:px-12 py-6 flex w-full items-center">
                <a class="text-3xl font-bold font-heading" href="#">
                    Logo Here.
                </a>
                <!-- Nav Links -->
                <ul class="hidden md:flex px-4 mx-auto font-semibold font-heading space-x-12">
                    <li><a class="hover:text-gray-200" href="#">Home</a></li>
                    <li><a class="hover:text-gray-200" href="#">Dashboard</a></li>
                    <li><a class="hover:text-gray-200" href="#">Contact Us</a></li>
                </ul>
                <!-- Header Icons -->
                <div class="hidden xl:flex items-center space-x-5 items-center">
                    <!-- Favourite Icon  -->
                    <a class="hover:text-gray-200" href="#">
                        <i class="far fa-heart fa-lg"></i>
                    </a>
                    <!-- Sign In / Register      -->
                    <a class="hover:text-gray-200" href="#">
                        <i class="far fa-user-circle fa-lg"></i>
                    </a>
                </div>
            </div>
            <!-- Responsive navbar -->
            <a class="navbar-burger self-center mr-12 xl:hidden" href="#">
                <i class="fas fa-bars fa-lg"></i>
            </a>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
