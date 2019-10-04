<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\User;
use Hamcrest\Thingy;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        logger()->info('Showing About page...');

        return view('blog.about', [
            'user' => User::whereEmail('iksaku@me.com')->first(),
            'introductoryPhrase' => $this->getIntroductoryPhrase()
        ]);
    }

    private function getIntroductoryPhrase(): string
    {
        $phrases = [
            "Still don't know me?",
            "Haven't we already met?",
            "So, you want to know more about me...",
            "This is me... " . github_emoji('notes'),
            "What? Who am I you ask?",
            "Peeking at my blog without knowing me?",
            "¿Sabías que hablo Español? " . github_emoji('mexico'),
        ];

        return $phrases[array_rand($phrases, 1)];
    }
}
