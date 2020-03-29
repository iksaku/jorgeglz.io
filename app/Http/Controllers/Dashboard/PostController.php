<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Post;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.posts.index', [
            'posts' => Post::query()
                ->withTrashed()
                ->orderByDesc('created_at')
                ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.posts.update', ['post' => new Post()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return View
     */
    public function store(Request $request): View
    {
        $request->merge([
            'slug' => Str::slug($request->get('title')),
        ]);

        $validated = $request->validate([
            'slug' => 'required|unique:posts',
            'title' => 'required|unique:posts|max:255',
            'content' => 'required',
            'published_at' => 'required|date|nullable',
            //'tags' => '' TODO
        ]);

        $post = Post::create($validated);

        // TODO: Sync Tags

        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return View
     */
    public function show(Post $post): View
    {
        return view('dashboard.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return View
     */
    public function edit(Post $post): View
    {
        return view('dashboard.posts.update', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return View
     */
    public function update(Request $request, Post $post): View
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|unique:posts|max:255',
            'content' => 'sometimes|required|string',
            'published_at' => 'sometimes|required|date|nullable',
            //'tags' => '' TODO
        ]);

        $post->update($validated);

        // TODO: Sync Tags

        return view('dashboard.posts.show', compact('post'));
    }

    public function restore(Post $post): RedirectResponse
    {
        if (!$post->restore()) {
            session()->flash('dashboard.posts.restore', [
                'error' => 'Unable to restore post.',
            ]);
        }

        return redirect()->route('dashboard.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        try {
            $post->delete();
        } catch (Exception $e) {
            session()->flash('dashboard.posts.destroy', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('dashboard.posts.show');
        }

        session()->flash('dashboard.posts.destroy', [
            'message' => 'Successfully archived post \''.$post->id.'\'.',
        ]);

        return redirect()->route('dashboard.posts.index');
    }
}
