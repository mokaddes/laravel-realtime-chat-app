@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-purple-700 to-indigo-700 text-white font-extrabold text-2xl text-center">
                        {{ __('Chat List') }}
                    </div>
                    <div class="p-6 space-y-4">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @forelse ($users as $user)
                            <div class="flex items-center bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-sm hover:shadow-lg transition duration-300">
                                <!-- Placeholder Avatar -->
                                <div class="flex-shrink-0 mr-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f46e5&color=fff&size=50" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                                </div>

                                <!-- User Info -->
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 dark:text-white">{{ $user->name }}</h4>
                                    <a href="{{ route('chat', $user->id) }}" class="text-indigo-500 hover:text-indigo-600 text-sm underline">Start Chat</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No users available for chat.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
