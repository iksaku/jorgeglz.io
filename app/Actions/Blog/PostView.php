<?php

namespace App\Actions\Blog;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostView extends Component
{
    public Post $post;

    public function render(): View
    {
        return view('blog.post-view')
            ->extends('layout.blog');
    }
}
