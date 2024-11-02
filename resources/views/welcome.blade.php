<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-gradient-to-br from-blue-400 to-purple-500 selection:bg-yellow-400 selection:text-white flex flex-col">
    <!-- Header -->
    <header class="w-full bg-gradient-to-r from-purple-700 to-indigo-700 text-white font-extrabold text-3xl shadow-lg py-6 text-center">
        Laravel Chat App
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center p-4">
        <!-- Home Page -->
        <div class="home-page bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl sm:max-w-md w-full text-center transition-transform duration-300 transform hover:scale-105">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Get Started</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Join the chat! Log in or register to connect with friends and start conversations.</p>

            <!-- Login/Register Links -->
            @if (Route::has('login'))
                <div class="flex justify-center space-x-4">
                    @auth
                        <a href="{{ route('home') }}" class="px-6 py-2 rounded-full font-semibold text-white bg-blue-500 hover:bg-blue-600 transition ease-in-out duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400">Chat List</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 rounded-full font-semibold text-white bg-indigo-500 hover:bg-indigo-600 transition ease-in-out duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 rounded-full font-semibold text-white bg-pink-500 hover:bg-pink-600 transition ease-in-out duration-300 shadow-md focus:outline-none focus:ring-2 focus:ring-pink-400">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>


    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-center text-gray-400 py-4">
        &copy; {{ date('Y') }} Laravel Chat App. All Rights Reserved.
    </footer>
    </body>





</html>
