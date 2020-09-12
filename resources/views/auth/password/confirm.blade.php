@section('title', 'Confirm Password')

@section('message', 'Confirm Password')

<form wire:submit.prevent="confirmPassword">
    <label class="w-full mb-4 block">
        <input
            required
            type="password"
            wire:model.defer="password"
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
