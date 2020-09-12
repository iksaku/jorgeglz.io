<?php

namespace App\Actions\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = true;

    public array $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $credentials = $this->validate();

        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        return redirect()->intended(route('dashboard.index'));
    }

    public function render(): View
    {
        return view('auth.login')
            ->extends('layout.auth');
    }
}
