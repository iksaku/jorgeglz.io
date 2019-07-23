<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => ['store', 'update', 'destroy'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        logger()->info('Showing post list on page '.$request->get('page', 1).'...');

        return response()->json(
            Post::where('published_at', '<=', now())->orderByDesc('published_at')->paginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        logger()->info('Showing post \''.$post->slug.'\'');

        return response()->json($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        /** @var User $user */
        $user = Auth::user();

        logger()->info($user->name.' is creating a new post...');

        $data = $request->validate([
            'title' => 'required|string|unique:posts,title',
            'content' => 'required|string',
            'publish' => 'required|boolean',
            'tags' => 'sometimes|required|array',
            'author_id' => 'sometimes|required|exists:users,id',
        ]);

        $post = new Post($data);
        $post->slug = Str::slug($post->title);

        /** @var User $author */
        $author = isset($data['author_id'])
            ? $author = User::find($data['author_id'])
            : $user;

        if (isset($data['publish'])) {
            $publish = (bool) $data['publish'];

            if ($publish && empty($post->published_at)) {
                $post->published_at = now();
            } elseif (!$publish) {
                $post->published_at = null;
            }
        }

        if (!$author->posts()->save($post)) {
            logger()->error('Unable to create post.');

            return response()->json([
                'message' => 'Unable to create post.',
            ], 500);
        }

        if (array_key_exists('tags', $data)) {
            logger()->info('Tags: '.$data['tags']);

            $tagList = empty($data['tags']) ? [] : explode(',', $data['tags']);
            $tagIds = [];

            if (!empty($tagList)) {
                foreach ($tagList as $tagName) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
            }

            $post->tags()->sync($tagIds);
            $post = $post->fresh();
        }

        logger()->info('Successfully created post \''.$post->slug.'\'');

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        /** @var User $user */
        $user = Auth::user();

        logger()->info($user->name.' is updating a post...');

        $data = $request->validate([
            'title' => 'sometimes|required|string|unique:posts,title',
            'content' => 'sometimes|required|string',
            'publish' => 'sometimes|required|boolean',
            'tags' => 'sometimes|required|array',
            'author_id' => 'sometimes|required|exists:users,id',
        ]);

        $post->slug = Str::slug($post->title);

        /** @var User $author */
        $author = isset($data['author_id'])
            ? User::find($data['author_id'])
            : $user;

        if (isset($data['publish'])) {
            $publish = (bool) $data['publish'];

            if ($publish && empty($post->published_at)) {
                $post->published_at = now();
            } elseif (!$publish) {
                $post->published_at = null;
            }
        }

        $post->author()->associate($author);

        if (!$post->update($data)) {
            logger()->error('Unable to update post.');

            return response()->json([
                'message' => 'Unable to update post.',
            ], 500);
        }

        if (array_key_exists('tags', $data)) {
            logger()->info('Tags: '.$data['tags']);

            $tagList = empty($data['tags']) ? [] : explode(',', $data['tags']);
            $tagIds = [];

            if (!empty($tagList)) {
                foreach ($tagList as $tagName) {
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
            }

            $post->tags()->sync($tagIds);
            $post = $post->fresh();
        }

        logger()->info('Successfully updated post \''.$post->slug.'\'');

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        /** @var User $user */
        $user = Auth::user();

        try {
            logger()->info($user->name.' is archiving post \''.$post->slug.'\'');
            $post->delete();
        } catch (Exception $e) {
            logger()->error('Unable to archive post: '.$e->getMessage());

            return response()->json([
                'message' => 'An error occurred while archiving post.',
            ], 500);
        }

        logger()->info('Successfully archived post \''.$post->slug.'\'');

        return response()->json([
            'message' => 'Post archived successfully',
        ]);
    }
}
