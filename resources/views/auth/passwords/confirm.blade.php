@extends('auth.partials.template')

@section('title', 'Confirm Password')

@section('message', 'Confirm Password')

@section('contents')
    <form action="{{ route('password.confirm') }}" method="post">
        @csrf

        <label class="w-full mb-4 block">
            <div class="w-full flex items-center justify-between">
                <span class="text-sm text-gray-700 font-bold">
                    Password
                </span>

                @if(Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        tabindex="-1"
                        class="cursor-pointer text-xs font-bold text-blue-500 hover:text-blue-700"
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
                class="form-input border-gray-400 w-full block mt-2 @error('password') border-red-500 @enderror"
            >
            @error('password')
            <span class="text-sm text-red-500 italic">
                    {{ $message }}
                </span>
            @enderror
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
