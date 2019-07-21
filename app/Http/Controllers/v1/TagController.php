<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Tag;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * TagController constructor.
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
     * @return Response
     */
    public function index()
    {
        logger()->info('Showing tag list...');

        return response()->json(Tag::all());
    }

    /**
     * Display the specified resource.
     *
     * @param string $name
     * @return Response
     */
    public function show(string $name)
    {
        /** @var Tag $tag */
        $tag = Tag::whereName($name)->first();

        if (empty($tag)) {
            logger()->info('Unable to find tag \''.$name.'\'');

            return response()->json([
                'message' => 'Unable to find specified tag.',
            ], 404);
        }

        logger()->info('Showing posts on tag \''.$tag->name.'\'');

        return response()->json($tag->load('posts'));
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
        $this->authorize('create', Tag::class);

        /** @var User $user */
        $user = Auth::user();

        logger()->info($user->name.' is creating a new tag...');

        $data = $request->validate([
            'name' => 'required|string|unique:tags,name',
        ]);

        $tag = Tag::create($data);

        logger()->info('Successfully created tag \''.$tag->name.'\'');

        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Tag $tag
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        /** @var User $user */
        $user = Auth::user();

        logger()->info($user->name.' is updating a tag...');

        $data = $request->validate([
            'name' => 'required|string|unique:tags,name',
        ]);

        if (!$tag->update($data)) {
            logger()->error('Unable to update tag.');

            return response()->json([
                'message' => 'Unable to update tag.',
            ], 500);
        }

        logger()->info('Successfully updated tag \''.$tag->name.'\'');

        return response()->json($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        /** @var User $user */
        $user = Auth::user();

        try {
            logger()->info($user->name.' is archiving tag \''.$tag->name.'\'');
            $tag->delete();
        } catch (Exception $e) {
            logger()->error('Unable to archive tag: '.$e->getMessage());

            return response()->json([
                'message' => 'An error occurred while archiving tag.',
            ], 500);
        }

        logger()->info('Successfully archived tag \''.$tag->name.'\'');

        return response()->json([
            'message' => 'Tag archived successfully',
        ]);
    }
}
