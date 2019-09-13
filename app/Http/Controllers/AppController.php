<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Inertia\Response;

class AppController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function home(Request $request): Response
    {
        logger()->info('Showing Post list on page '.$request->get('page', 1).'...');

        $posts = Post::query()
            ->isPublished()
            ->orderByDesc('published_at')
            ->paginate();

        return inertia('App/Home', compact('posts'));
    }

    /**
     * @return Response
     */
    public function about(): Response
    {
        return inertia('App/About');
    }

    /**
     * @param string $slug
     * @return Response
     */
    public function post(string $slug): Response
    {
        $post = Post::query()
            ->whereSlug($slug)
            ->isPublished()
            ->first();

        if (empty($post)) {
            logger()->error('Unable to find Post \''.$slug.'\'...');

            return inertia()->render('App/Error', [
                'code' => 404,
                'message' => 'Post \''.$slug.'\' not found.',
            ]);
        }

        logger()->info('Showing Post \''.$post->slug.'\'...');

        return inertia('App/Post', $post);
    }
}
