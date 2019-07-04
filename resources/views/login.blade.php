@extends('template')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen h-full w-full bg-gray-200 text-gray-700 px-4">
        <h1 class="text-center text-3xl py-10">Welcome back!</h1>

        <div class="bg-gray-100 rounded-lg shadow-md max-w-xs w-full mx-auto p-6">
            <form method="POST" action="">
                @csrf

                <label class="block mb-6">
                    <span class="text-gray-700">Email</span>
                    <input type="email" name="email" placeholder="john@example.com" autofocuse
                           class="form-input mt-2 block w-full @error('email') border-red-500 @enderror">

                    @error('email')
                        @component('components.form-error')
                            {{ $message }}
                        @endcomponent
                    @enderror
                </label>

                <label class="block mb-6">
                    <span class="text-gray-700">Password</span>
                    <input type="password" name="password" placeholder="******"
                           class="form-input mt-2 block w-full @error('password') border-red-500 @enderror">

                    @error('password')
                        @component('components.form-error')
                            {{ $message }}
                        @endcomponent
                    @enderror
                </label>

                <div class="block flex flex-col sm:flex-row items-center justify-between">
                    <label class="mb-4 sm:my-4 sm:w-4/5">
                        <input type="checkbox" name="remember" class="form-checkbox text-blue-500 border-gray-500">
                        <span>Remember me</span>
                    </label>

                    <button
                            type="submit"
                            class="text-white font-bold py-2 w-2/3 rounded bg-blue-500 hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:shadow-outline"
                    >
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
