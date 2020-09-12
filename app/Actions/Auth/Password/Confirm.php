<?php

namespace App\Actions\Auth\Password;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

class Confirm extends Component
{
    public string $password = '';

    public function confirmPassword(): RedirectResponse
    {
        $this->validate([
            'password' => ['required', 'password'],
        ]);

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard.index'));
    }

    public function render(): View
    {
        return view('auth.password.confirm')
            ->extends('layout.auth');
    }
}
