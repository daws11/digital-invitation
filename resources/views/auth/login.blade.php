@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-600">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:ring-blue-300 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="text-sm text-red-500 mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">{{ __('Password') }}</label>
                <input id="password" type="password" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:ring-blue-300 @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="text-sm text-red-500 mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-500 border-gray-300 rounded focus:ring-blue-400" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('Remember Me') }}</label>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="w-full px-4 py-2 font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                    {{ __('Login') }}
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
