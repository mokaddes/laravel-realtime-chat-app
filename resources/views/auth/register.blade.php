@extends('layouts.app')

@section('content')
    <!-- Register Page -->
    <div class="register-page bg-white dark:bg-gray-800 p-8 rounded-lg shadow-xl sm:max-w-md w-full text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Register</h2>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Full Name Input -->
            <input
                type="text"
                name="name"
                placeholder="Full Name"
                class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror"
                value="{{ old('name') }}"
                required
            >
            @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Email Input -->
            <input
                type="email"
                name="email"
                placeholder="Email"
                class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white @error('email') border-red-500 @enderror"
                value="{{ old('email') }}"
                required
            >
            @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Password Input -->
            <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white @error('password') border-red-500 @enderror"
                required
            >
            @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Confirm Password Input -->
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm Password"
                class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white"
                required
            >

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full px-6 py-2 rounded-full font-semibold text-white bg-pink-500 hover:bg-pink-600 transition ease-in-out duration-300 shadow-md"
            >
                Register
            </button>
        </form>

    </div>

@endsection
