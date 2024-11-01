@extends('layouts.app')

@section('content')
    <div id="app" class="w-full md:w-2/3 lg:w-1/2 h-full">
        <chat-component :user="{{ $user }}" :auth="{{ Auth::user() }}"></chat-component>
    </div>
@endsection
