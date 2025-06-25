<?php

namespace Javaabu\Forms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Javaabu\Forms\Http\Middleware\OverrideFormsDefaults;

class FormsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // declare publishes
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('forms.php'),
            ], 'forms-config');

            $this->publishes([
                __DIR__ . '/../lang' => lang_path('vendor/forms'),
            ], 'forms-translations');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/forms'),
            ], 'forms-views');
        }

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'forms');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'forms');

        // declare blade directives
        Blade::directive('model', function ($model) {
            return '<?php app(\Javaabu\Forms\FormsDataBinder::class)->bind(' . $model . '); ?>';
        });

        Blade::directive('endmodel', function ($model) {
            return '<?php app(\Javaabu\Forms\FormsDataBinder::class)->pop(); ?>';
        });

        Blade::componentNamespace('Javaabu\\Forms\\Views\\Components', 'forms');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // merge package config with user defined config
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'forms');

        // register the data binder
        $this->app->singleton(FormsDataBinder::class, fn () => new FormsDataBinder());

        app('router')->aliasMiddleware('forms', OverrideFormsDefaults::class);

        // Register custom artisan commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Javaabu\Forms\Commands\PublishViewCommand::class,
            ]);
        }
    }
}
