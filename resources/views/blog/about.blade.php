<?php
/** @var App\User $user */
/** @var string $introductoryPhrase */
?>

@extends('blog.partials.template')

@section('title', 'About')

@push('meta')
    <meta name="description" content="Here you can get a gist of who I am, and what do I like.">
@endpush

@section('content')
    <div class="md:max-w-6xl bg-gray-100 border border-gray-300 rounded shadow p-4 mx-auto">
        <h1 class="text-3xl text-center font-bold mb-4">
            {!! $introductoryPhrase !!}
        </h1>

        <img src="{{ $user->avatar }}?size=512" alt="" class="h-64 w-64 block mx-auto rounded-full">

        <article class="markdown">
            @markdown
## About Me, Myself and I
My name is Jorge González, also known in the online work as _iksaku_.
I was born in Mexico :mexico: and I like tech-related stuff, food and also
sports (not as a spectator but as a player, even if I'm not the most
proficient one).

My sport of choice is Karate :martial_arts_uniform:, I've been practicing
since I was 7 years old, and I've got the opportunity to be under the guidance
of a lot of excellent sensei here from Mexico, as well as from Guatemala,
Spain and Japan directly.

I'm currently studying a _Software Engineering_ degree, which I hope to finish
around year 2020. To be honest, I don't feel like I'm learning new tech-related
stuff at school, since I've been learning and studying on those lands for quite
some time already, but I'm trully getting better for Math and Physics stuff.

## My Main Programming Languages
* The forever loyal [PHP](https://www.php.net/).
* Our third wheel [.NET](https://dotnet.microsoft.com/)
* The simple, yet powerful
[JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript).
* An intelligent [Python](https://www.python.org/).

## Personal Facts
* :ring: I'm currently engaged.
* :martial_arts_uniform: In Karate, I have got up to Black Belt 1° Dan.
* :books: I started learning English by myself at the age of 6.
* :microphone: I get to learn the lyrics of many songs, but fail to remember
the name of the songs, the bands or the artists.
* :nauseated_face: I don't like onion, garlic nor avocado.
            @endmarkdown
        </article>
    </div>
@endsection
