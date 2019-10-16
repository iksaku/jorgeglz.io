<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        logger()->info('Showing post list on page '.$request->get('page', 1).'...');

        return response()->json(
            Post::where('published_at', '<=', now())->orderByDesc('published_at')->paginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        /** @var Post $post */
        $post = Post::whereSlug($slug)->first();

        logger()->info('Showing post \''.$post->slug.'\'');

        return response()->json($post);
    }
}
