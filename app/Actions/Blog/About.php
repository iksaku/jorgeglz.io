<?php

namespace App\Actions\Blog;

use Illuminate\Support\Arr;
use Livewire\Component;

class About extends Component
{
    public function getPhraseProperty(): string
    {
        return Arr::random([
            "Still don't know me?",
            "Haven't we already met?",
            'So, you want to know more about me...',
            //'This is me... '.emoji('notes'),
            'Who am I you ask?',
            'Peeking at my blog without knowing me?',
            //'¿Sabías que hablo Español? '.emoji('mexico'),
        ]);
    }

    public function render()
    {
        return view('blog.about')
            ->extends('layout.blog');
    }
}
