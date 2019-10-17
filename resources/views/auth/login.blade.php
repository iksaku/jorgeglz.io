<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

@extends('auth.partials.template')

@section('title', 'Login')

@section('message', 'Welcome back!')

@section('form')
    <form action="{{ route('login') }}" method="post" class="bg-gray-100 rounded shadow px-4 py-8">
        @csrf

        <label class="w-full mb-4 block">
            <span class="text-sm font-bold">
                Username
            </span>
            <input type="text" name="email"
                   placeholder="escanor@human.race"
                   value="{{ old('email') }}"
                   class="form-input w-full block mt-2 @error('email') border-red-500 @enderror"
            >
            @error('email')
                <span class="text-sm text-red-500 italic">
                    {{ $message }}
                </span>
            @enderror
        </label>
        <label class="w-full mb-4 block">
            <span class="text-sm font-bold">
                Password
            </span>
            <input type="password" name="password"
                   placeholder="Praise the Sun"
                   class="form-input w-full block mt-2 @error('password') border-red-500 @enderror"
            >
            @error('password')
            <span class="text-sm text-red-500 italic">
                    {{ $message }}
                </span>
            @enderror
        </label>

        <div class="w-full block flex items-center justify-around px-2">
            <label class="w-1/2">
                <input type="checkbox" name="remember" class="form-checkbox text-blue-500" checked>
                <span class="ml-1">
                    Remember
                </span>
            </label>
            <button class="w-1/2 text-white font-bold bg-blue-500 px-4 py-2 rounded hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:shadow-outline">
                Login
            </button>
        </div>
    </form>
@endsection
