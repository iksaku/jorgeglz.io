<?php

namespace App\Nova\Actions;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class PublishPost extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * PublishPost constructor.
     */
    public function __construct()
    {
        $this->canSee(function (NovaRequest $request) {
            try {
                /** @var Post $model */
                $model = $request->findModelOrFail();
            } catch (ModelNotFoundException $exception) {
                // If not in Detail View, show for bulk selection.
                return true;
            }

            // If in Detail View, only show if post has not been published
            return empty($model->published_at);
        });
    }

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $publish_count = 0;
        foreach ($models as $post) {
            /** @var Post $post */
            if (!empty($post->published_at)) {
                continue;
            }

            $post->update([
                'published_at' => now(),
            ]);

            $publish_count++;
        }

        return Action::message(
            $publish_count > 0
                ? 'Post'.($publish_count > 1 ? 's' : '').' published successfully.'
                : 'No posts were published.'
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
