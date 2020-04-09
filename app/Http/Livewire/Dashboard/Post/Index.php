<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Dashboard\Post;

use App\Http\Livewire\Traits\TrashedQuery;
use App\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, TrashedQuery;

    /** @var string */
    public $search = '';

    /** @var array */
    protected $updatesQueryString = [
        'search' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->search = request()->query('search', $this->search);
    }

    public function getPostsProperty(): LengthAwarePaginator
    {
        return Post::query()
            ->when(!empty($this->search), function (Builder $query) {
                $query->where(
                    'title',
                    'LIKE',
                    '%'.preg_replace('/[\s]+/', '%', $this->search).'%'
                );
            })
            ->{$this->trashed}()
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function render()
    {
        return view('livewire.dashboard.post.index');
    }

    public function paginationView(): string
    {
        return 'pagination::tailwind-livewire';
    }
}
