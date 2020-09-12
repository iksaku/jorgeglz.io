<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * @mixin Component
 */
trait WithTrashed
{
    public string $trashed = 'withoutTrashed';

    public array $trashedFilters = [
        'withTrashed' => 'Include Trashed Items',
        'withoutTrashed' => 'Exclude Trashed Items',
        'onlyTrashed' => 'Trashed Items Only',
    ];

    public function initializeWithTrashed()
    {
        $this->queryString = array_merge(
            $this->queryString,
            ['trashed' => ['except' => 'withoutTrashed']]
        );
    }

    public function updatingTrashed(): void
    {
        if (isset($this->page)) {
            $this->page = 1;
        }
    }
}
