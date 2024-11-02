<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-400 to-purple-500 selection:bg-yellow-400 selection:text-white flex flex-col">

    <!-- Header with Navbar -->
    <header class="w-full bg-gradient-to-r from-purple-700 to-indigo-700 text-white shadow-lg">
        <nav class="container mx-auto flex items-center justify-between py-4">
            <!-- Navbar Brand -->
            <a href="{{ url('/') }}" class="text-3xl font-extrabold">
                Laravel Chat App
            </a>

            <!-- Navbar Links -->
            <div class="flex items-center space-x-4">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-white hover:underline">
                            {{ __('Login') }}
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white hover:underline">
                            {{ __('Register') }}
                        </a>
                    @endif
                @else
                    <!-- User Dropdown using Alpine.js -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white text-gray-700 rounded-md shadow-lg z-10">
                            <a href="{{ route('logout') }}"
                               class="block px-4 py-2 text-sm hover:bg-gray-200"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <main class="flex-grow flex items-center justify-center p-4">
        @yield('content')
    </main>

<!-- Alpine.js for dropdown toggle -->
<script src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js" defer></script>
</body>
</html>
