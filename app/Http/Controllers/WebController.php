<?php

namespace App\Http\Controllers;

class WebController extends Controller
{
    /**
     * WebController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['dashboard'],
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function app()
    {
        return view('index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
