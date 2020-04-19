<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Post;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('dashboard.posts.index');
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.posts.update', ['post' => new Post()]);
    }

    /*
     * Store a newly created resource in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'slug' => Str::slug($request->get('title')),
        ]);

        $validated = $request->validate([
            'slug' => 'required|unique:posts',
            'title' => 'required|max:255|unique:posts',
            'content' => 'required|string',
            'published_at' => 'sometimes|required|date|nullable',
            //'tags' => '' TODO
        ]);

        $post = Auth::user()->posts()->create($validated);

        // TODO: Sync Tags

        return redirect()->route('dashboard.posts.show', $post);
    }

    /*
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('dashboard.posts.show', compact('post'));
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        return view('dashboard.posts.update', compact('post'));
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|max:255|unique:posts,title,'.$post->id,
            'content' => 'sometimes|required|string',
            'published_at' => 'sometimes|required|date|nullable',
            //'tags' => '' TODO
        ]);

        $post->update($validated);

        // TODO: Sync Tags

        return redirect()->route('dashboard.posts.show', compact('post'));
    }

    /*
     * Restores Post from trash.
     */
    public function restore(Post $post): RedirectResponse
    {
        if (!$post->restore()) {
            session()->flash('dashboard.posts.restore', [
                'error' => 'Unable to restore post.',
            ]);
        }

        return redirect()->route('dashboard.posts.index');
    }

    /*
     * Remove the specified resource from storage.
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
