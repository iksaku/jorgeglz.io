<?php

namespace App\Http\Livewire\Traits;

trait TrashedQuery
{
    public string $trashed = 'withTrashed';

    public array

 $trashedOptions = [
        'withTrashed' => 'Include Trashed Items',
        'withoutTrashed' => 'Exclude Trashed Items',
        'onlyTrashed' => 'Show Trashed Items Only',
    ];

    public function initializeTrashedQuery()
    {
        $this->updatesQueryString = array_merge(
            $this->updatesQueryString,
            ['trashed' => ['except' => 'withTrashed']]
        );

        $this->trashed = request()->query('trashed', $this->trashed);
    }

    public function updatingTrashed(string $value): void
    {
        $this->page = 1;
    }
}
