<?php
/** @var App\User $user */
/** @var string $content */
/** @var string $introductoryPhrase */
?>

@extends('layouts.blog')

@section('title', 'About')

<x-meta og="title" content="About Jorge González" />
<x-meta og="description" content="Get a gist of who I am and what do I like." />

@section('content')
    <div class="flex-grow max-w-6xl flex flex-col mx-auto space-y-8">
        <div class="w-full flex flex-col-reverse md:flex-row md:reverse-order items-center justify-center md:space-x-8 space-y-4 space-y-reverse md:space-y-0">
            <img
                src="{{ avatar('iksaku@me.com') }}?size=512"
                alt="Jorge's avatar"
                class="h-32 w-32 rounded-full"
            >

            <h1 class="text-3xl text-center font-bold">
                {!! $introductoryPhrase !!}
            </h1>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg p-4">
            <article class="markdown">
                <h2>About Me, Myself and I</h2>
                <p>
                    My name is Jorge González, also known in the online work as <i>iksaku</i>.
                    I was born in Mexico @emoji('mexico') and I like tech-related stuff, food and also
                    sports (not as a spectator but as a player, even if I'm not the most
                    proficient one).
                </p>
                <p>
                    My sport of choice is Karate @emoji('martial_arts_uniform'), I've been practicing
                    since I was 7 years old, and I've got the opportunity to be under the guidance
                    of a lot of excellent sensei here from Mexico, as well as from Guatemala,
                    Spain and Japan directly.
                </p>
                <p>
                    I'm currently studying a <i>Software Engineering</i> degree, which I hope to finish
                    around year 2020. To be honest, I don't feel like I'm learning new tech-related
                    stuff at school, since I've been learning and studying on those lands for quite
                    some time already, but I'm truly getting better for Math and Physics stuff.
                </p>

                <h2>My Main Programming Languages</h2>
                <ul>
                    <li>
                        The forever loyal <a href="https://www.php.net/">PHP</a>.
                    </li>
                    <li>
                        The complex <a href="https://dotnet.microsoft.com/">.NET</a>.
                    </li>
                    <li>
                        The simple, yet powerful <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript">JavaScript</a>.
                    </li>
                    <li>
                        The intelligent <a href="https://www.python.org/">Python</a>.
                    </li>
                </ul>

                <h2>Personal Facts</h2>
                <ul>
                    <li>@emoji('ring') I'm married.</li>
                    <li>@emoji('martial_arts_uniform') In Karate, I have got up to Black Belt 1° Dan.</li>
                    <li>@emoji('books') I started learning English by myself at the age of 6.</li>
                    <li>
                        @emoji('microphone') I get to learn the lyrics of many songs, but fail to remember the name of the songs, the
                        bands or the artists.
                    </li>
                    <li>@emoji('nauseated_face') I don't like onion, garlic nor avocado.</li>
                </ul>
            </article>
        </div>
    </div>
@endsection
