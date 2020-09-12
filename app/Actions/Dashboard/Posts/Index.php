<?php

namespace App\Actions\Dashboard\Posts;

use App\Livewire\WithTrashed;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithTrashed;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function getPostsProperty(): LengthAwarePaginator
    {
        return Post::query()
            ->search(['id' => '=', 'title'], $this->search)
            ->{$this->trashed}()
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function restore(int $id)
    {
        Post::whereId($id)->restore();
    }

    public function render()
    {
        return view('dashboard.posts.index')
            ->extends('layout.dashboard');
    }
}
