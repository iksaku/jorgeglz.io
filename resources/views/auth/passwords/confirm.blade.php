@extends('auth.partials.template')

@section('title', 'Confirm Password')

@section('message', 'Confirm Password')

@section('contents')
    <form action="{{ route('password.confirm') }}" method="post">
        @csrf

        <label class="w-full mb-4 block">
            <div class="w-full flex items-center justify-between">
                <span class="text-sm font-bold">
                    Password
                </span>

                @if(Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        tabindex="-1"
                        class="cursor-pointer text-sm font-bold text-blue-500 hover:text-blue-700"
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

        <div class="w-full block flex items-center justify-center">
            <button
                type="submit"
                class="w-full md:w-2/3 text-white font-bold px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:shadow-outline"
            >
                Confirm Password
            </button>
        </div>
    </form>
@endsection
