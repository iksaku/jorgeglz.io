<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function index()
    {
        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Factory|RedirectResponse|View
     */
    public function show(Post $post)
    {
        return view('blog.post', compact('post'));
    }
}
