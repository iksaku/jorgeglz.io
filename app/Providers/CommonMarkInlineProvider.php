<?php

namespace App\Providers;

use App\CommonMark\Converter;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\DocParser;
use League\CommonMark\HtmlRenderer;

class CommonMarkInlineProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->markdownSingleton();
    }

    /**
     * Overrides Converter Interface for the Markdown Singleton.
     *
     * @return void
     */
    protected function markdownSingleton()
    {
        $this->app->singleton('markdown', function (Container $app) {
            $environment = $app['markdown.environment'];
            $docParser = new DocParser($environment);
            $htmlRenderer = new HtmlRenderer($environment);

            return new Converter($docParser, $htmlRenderer);
        });

        $this->app->alias('markdown', Converter::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bladeDirective();
    }

    /**
     * Overrides Markdown Blade Directive.
     *
     * @return void
     */
    public function bladeDirective()
    {
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
