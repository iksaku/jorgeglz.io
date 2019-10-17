<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.index');
    }
}
