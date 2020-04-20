@extends('auth.partials.template')

@section('title', 'Login')

@section('message', 'Welcome!')

@section('contents')
    <form action="{{ route('login') }}" method="post">
        @csrf

        <label class="w-full mb-4 block">
            <span class="text-sm font-bold">
                Email
            </span>
            <input
                autofocus
                required
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="escanor@human.race"
                class="form-input dark:bg-gray-700 border-gray-400 dark:border-transparent w-full block mt-2 @error('email') border-red-500 @enderror"
            >
            <x-input-error property="email" />
        </label>

        <label class="w-full mb-4 block">
            <div class="w-full flex items-center justify-between">
                <span class="text-sm font-bold">
                    Password
                </span>

                @if(Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        tabindex="-1"
                        class="cursor-pointer text-sm font-bold text-blue-500 hocus:text-blue-700"
                    >
                        Forgot password?
                    </a>
                @endif
            </div>
            <input
                required
                type="password"
                name="password"
                placeholder="********"
                autocomplete="password"
                class="form-input dark:bg-gray-700 border-gray-400 dark:border-transparent w-full block mt-2 @error('password') border-red-500 @enderror"
            >
            <x-input-error property="password" />
        </label>

        <label class="w-full mb-4 block">
            <input
                type="checkbox"
                name="remember"
                class="form-checkbox dark:bg-gray-700 border-gray-400 dark:border-transparent text-blue-500"
                {{ old('remember', true) ? 'checked' : '' }}
            >
            <span class="text-sm font-bold ml-1">
                Remember
            </span>
            <x-input-error property="remember" />
        </label>

        <div class="w-full block flex items-center justify-center">
            <button
                type="submit"
                class="w-full md:w-2/3 text-white font-bold px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:shadow-outline"
            >
                Login
            </button>
        </div>
    </form>
@endsection
