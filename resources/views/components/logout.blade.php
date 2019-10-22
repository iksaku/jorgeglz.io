<a
    class="text-black cursor-pointer"
    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
>
    Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="post" class="hidden">
    @csrf
</form>
