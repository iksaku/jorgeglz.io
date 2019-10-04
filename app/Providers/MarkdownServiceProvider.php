<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('markdown', function (string $expresion) {
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
