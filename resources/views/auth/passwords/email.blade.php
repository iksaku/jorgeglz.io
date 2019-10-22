@extends('auth.partials.template')

@section('title', 'Password Reset')

@section('message', 'Password Reset')

@if(session('status'))
    @section('alert', session('status'))
@endif

@section('contents')
    <form action="{{ route('password.email') }}" method="post">
        @csrf

        <label class="w-full mb-4 block">
            <span class="text-sm text-gray-700 font-bold">
                Email
            </span>
            <input
                autofocus
                required
                type="email"
                name="email"
                placeholder="escanor@human.race"
                value="{{ old('email') }}"
                autocomplete="email"
                class="form-input border-gray-400 w-full block  mt-2 @error('email') border-red-500 @enderror"
            >
            @error('email')
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
                Send Recovery Email
            </button>
        </div>
    </form>
@endsection
