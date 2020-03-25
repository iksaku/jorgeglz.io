<?php

namespace App\Providers;

use App\Observers\PostCacheObserver;
use App\Post;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerBladeDirectives();
        $this->registerObservers();
    }

    private function registerObservers(): void
    {
        Post::observe(PostCacheObserver::class);
    }

    private function registerBladeDirectives(): void
    {
        // Route
        Blade::if('route', 'in_route');

        // Markdown
        Blade::directive('markdown', function ($expresion) {
            if ($expresion) {
                return "<?php echo markdown($expresion); ?>";
            }

            return '<?php ob_start(); ?>';
        });
        Blade::directive('endmarkdown', function () {
            return '<?php echo markdown(ob_get_clean()); ?>';
        });
    }
}
