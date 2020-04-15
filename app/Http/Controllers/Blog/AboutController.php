<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Markdown\CacheableInterface;
use App\User;
use Illuminate\Contracts\View\View;

class AboutController extends Controller implements CacheableInterface
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('blog.about', [
            'user' => User::whereEmail(['iksaku@me.com'])->first(),
            'content' => $this,
            'introductoryPhrase' => $this->getIntroductoryPhrase(),
        ]);
    }

    /**
     * @return string
     */
    private function getIntroductoryPhrase(): string
    {
        $phrases = [
            "Still don't know me?",
            "Haven't we already met?",
            'So, you want to know more about me...',
            'This is me... '.emoji('notes'),
            'Who am I you ask?',
            'Peeking at my blog without knowing me?',
            '¿Sabías que hablo Español? '.emoji('mexico'),
        ];

        return $phrases[array_rand($phrases, 1)];
    }

    public function getCacheKey(): string
    {
        return 'about';
    }

    public function getContent(): string
    {
        return /* @lang Markdown */ <<<'MD'
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
some time already, but I'm truly getting better for Math and Physics stuff.

## My Main Programming Languages
* The forever loyal [PHP](https://www.php.net/).
* Our third wheel [.NET](https://dotnet.microsoft.com/)
* The simple, yet powerful
[JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript).
* An intelligent [Python](https://www.python.org/).

## Personal Facts
* :ring: I'm married.
* :martial_arts_uniform: In Karate, I have got up to Black Belt 1° Dan.
* :books: I started learning English by myself at the age of 6.
* :microphone: I get to learn the lyrics of many songs, but fail to remember
the name of the songs, the bands or the artists.
* :nauseated_face: I don't like onion, garlic nor avocado.
MD;
    }
}
