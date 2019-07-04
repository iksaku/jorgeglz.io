<?php

namespace App\Http\Controllers\v1;

use App\Tag;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    // TODO: Tag Primary Key to Name (So we can Tag-type store, update and destroy methods)

    /**
     * TagController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => ['store', 'update', 'destroy']
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        logger()->info($user->name . ' is creating a new tag...');

        $validatedData = $request->validate([
            'name' => 'required|string|unique:tags,name'
        ]);

        $tag = Tag::create($validatedData);

        logger()->info('Successfully created tag \'' . $tag->name . '\'');

        return response()->json($tag);
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

        logger()->info('Showing posts on tag \'' . $tag->name . '\'');

        return response()->json($tag->load('posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $name
     * @return Response
     */
    public function update(Request $request, string $name)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Tag $tag */
        $tag = Tag::whereName($name)->first();

        logger()->info($user->name . ' is updating a tag...');

        $validatedData = $request->validate([
            'name' => 'required|string|unique:tags,name'
        ]);

        if (!$tag->update($validatedData)) {
            logger()->error('Unable to update tag.');

            return response()->json([
                'message' => 'Unable to update tag.'
            ], 500);
        }

        logger()->info('Successfully updated tag \'' . $tag->name . '\'');

        return response()->json($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $name
     * @return Response
     */
    public function destroy(string $name)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Tag $tag */
        $tag = Tag::whereName($name)->first();

        try {
            logger()->info($user->name . ' is archiving tag \'' . $tag->name . '\'');
            $tag->delete();
        } catch (Exception $e) {
            logger()->error('Unable to archive tag: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while archiving tag.'
            ], 500);
        }

        logger()->info('Successfully archived tag \'' . $tag->name . '\'');

        return response()->json([
            'message' => 'Tag archived successfully'
        ]);
    }
}
