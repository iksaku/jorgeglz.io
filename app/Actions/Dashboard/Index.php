<?php

namespace App\Actions\Dashboard;

use App\Models\Post;
use Livewire\Component;

class Index extends Component
{
    public function getPublishedCountProperty(): int
    {
        return Post::query()
            ->wherePublished()
            ->count();
    }

    public function getDraftCountProperty(): int
    {
        return Post::query()
            ->whereDraft()
            ->count();
    }

    public function render()
    {
        return view('dashboard.index')
            ->extends('layout.dashboard');
    }
}
