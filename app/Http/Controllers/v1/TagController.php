<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
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
    public function show(string $name): Response
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
}
