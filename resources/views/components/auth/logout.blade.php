<form action="{{ route('logout') }}" method="post">
    @csrf

    <button
        class="w-full font-medium hocus:text-gray-100 hocus:bg-red-700 rounded-lg px-4 py-2 focus:outline-none transform duration-200"
        type="submit"
    >
        Logout
    </button>
</form>
