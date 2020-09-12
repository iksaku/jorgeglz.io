<?php

namespace App\Actions\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout(): void
    {
        Auth::logout();

        $this->redirect(route('blog.index'));
    }

    public function render(): View
    {
        return view('auth.logout');
    }
}
