@extends('auth.partials.template')

@section('title', 'Password Reset')

@section('message', 'Password Reset')

@section('contents')
    <form action="{{ route('password.update') }}" method="post">
        @csrf

        <input type="text" name="token" value="{{ $token }}" class="hidden">

        <label class="w-full mb-4 block">
            <span class="text-sm text-gray-700 font-bold">
                Email
            </span>
            <input
                autofocus
                required
                type="text"
                name="email"
                placeholder="escanor@human.race"
                value="{{ $email ?? old('email') }}"
                autocomplete="email"
                class="form-input border-gray-400 w-full block mt-2 @error('email') border-red-500 @enderror"
                readonly
            >
            @error('email')
                <span class="text-sm text-red-500 italic">
                    {{ $message }}
                </span>
            @enderror
        </label>

        <label class="w-full mb-4 block">
            <span class="text-sm text-gray-700 font-bold">
                New Password
            </span>
            <input
                required
                type="password"
                name="password"
                placeholder="********"
                autocomplete="new-password"
                class="form-input border-gray-400 w-full block mt-2 @error('password') border-red-500 @enderror"
            >
            @error('password')
                <span class="text-sm text-red-500 italic">
                    {{ $message }}
                </span>
            @enderror
        </label>

        <label class="w-full mb-4 block">
            <span class="text-sm text-gray-700 font-bold">
                Confirm Password
            </span>
            <input
                required
                type="password"
                name="password_confirmation"
                placeholder="********"
                autocomplete="new-password"
                class="form-input border-gray-400 w-full block mt-2"
            >
        </label>

        <div class="w-full block flex items-center justify-center">
            <button
                type="submit"
                class="w-full md:w-2/3 text-white font-bold px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:shadow-outline"
            >
                Save Password
            </button>
        </div>
    </form>
@endsection
