<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class PublishedPosts extends Filter
{
    /**
     * Name of the Filter.
     *
     * @var string
     */
    public $name = 'Published';

    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $value === 'published'
            ? $query->whereNotNull('published_at')
            : $query->whereNull('published_at');
    }

    /**
     * Get the filter's available options.
     *
     * @param Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Only Published' => 'published',
            'Only Not Published' => 'not_published',
        ];
    }
}
