<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('blog.index', [
            'posts' => Post::query()
                ->isPublished()
                ->orderbyDesc('published_at')
                ->paginate(),
        ]);
    }
}
