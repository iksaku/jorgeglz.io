<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        logger()->info('Requested \'posts/\' page, redirecting to index...');

        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Response|View
     */
    public function show(string $slug)
    {
        if ($slug === 'who-am-i.html') {
            return redirect()->route('blog.post', 'who-am-i', 301);
        }

        $post = Post::query()
            ->whereSlug($slug)
            ->isPublished()
            ->first();

        if (empty($post)) {
            logger()->error('Unable to find Post \''.$slug.'\'...');

            abort(404, 'Post \''.$slug.'\' not found.');
        }

        logger()->info('Showing Post \''.$post->slug.'\'...');

        return view('blog.post', compact('post'));
    }
}
