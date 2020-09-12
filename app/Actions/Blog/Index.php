<?php

namespace App\Actions\Blog;

use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function getPostsProperty(): Paginator
    {
        return Post::query()
            ->select(['id', 'slug', 'title', 'published_at'])
            ->wherePublished()
            ->orderByDesc('published_at')
            ->simplePaginate();
    }

    public function render(): View
    {
        return view('blog.index')
            ->extends('layout.blog');
    }
}
