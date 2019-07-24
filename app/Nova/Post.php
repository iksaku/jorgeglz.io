<?php

namespace App\Nova;

use App\Nova\Actions\PublishPost;
use App\Nova\Filters\PublishedPosts;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Iksaku\NovaExtendedMarkdown\NovaExtendedMarkdown;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Post';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'slug', 'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('ID')
                ->sortable(),

            Slug::make('Slug')
                ->sortable(),

            TextWithSlug::make('Title')
                ->slug('slug')
                ->sortable()
                ->rules('required', 'max:60'),

            BelongsTo::make('Author', 'author', 'App\Nova\User')
                ->sortable()
                ->rules('required'),

            Boolean::make('Published', 'published_at')
                ->onlyOnIndex()
                ->sortable()
                ->resolveUsing(function ($timestamp) {
                    return !empty($timestamp);
                }),
            Date::make('Published At')
                ->hideFromIndex()
                ->nullable(),

            NovaExtendedMarkdown::make('Content')
                ->alwaysShow()
                ->rules('required'),

            BelongsToMany::make('Tags')
                ->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new PublishedPosts(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new PublishPost(),
        ];
    }
}
