<?php

namespace Javaabu\Forms\Tests;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Javaabu\Forms\FormsServiceProvider;
use Javaabu\Forms\Tests\TestSupport\Providers\TestServiceProvider;
use Javaabu\Helpers\HelpersServiceProvider;
use Javaabu\Manifest\ManifestServiceProvider;
use Javaabu\Settings\SettingsServiceProvider;
use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Symfony\Component\DomCrawler\Crawler;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://localhost';

    public static function isLaravel9(): bool
    {
        return version_compare(app()->version(), '9.0', '>=') && version_compare(app()->version(), '10.0', '<');
    }

    public static function isLaravel10(): bool
    {
        return version_compare(app()->version(), '10.0', '>=');
    }

    public static function isMediaLibrary10(): bool
    {
        return InstalledVersions::satisfies(new VersionParser, 'spatie/laravel-medialibrary', '10.*');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:yWa/ByhLC/GUvfToOuaPD7zDwB64qkc/QkaQOrT5IpE=');

        $this->app['config']->set('session.serialization', 'php');

        // Tests check which assets components require; AssetsTest covers injection.
        $this->app['config']->set('manifest.inject', false);

        // Behaviour tests render with Bootstrap 6; framework tests pick their own.
        $this->app['config']->set('forms.framework', 'bootstrap-6');

        // $this->app['config']->set('form-components.framework', env('FORM_COMPONENTS_FRAMEWORK', 'tailwind'));

        View::addLocation(__DIR__ . '/TestSupport/views');

        if (empty(glob($this->app->databasePath('migrations/*_create_media_table.php')))) {
            Artisan::call('vendor:publish', [
                '--provider' => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
                '--tag' => self::isMediaLibrary10() ? 'migrations' : 'medialibrary-migrations',
            ]);

            Artisan::call('migrate');
        }

        Model::unguard();
    }

    protected function getPackageProviders($app)
    {
        return [
            SettingsServiceProvider::class,
            MediaLibraryServiceProvider::class,
            HelpersServiceProvider::class,
            ManifestServiceProvider::class,
            FormsServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    /**
     * Renders a Blade string and returns a crawler for the HTML.
     *
     * @param  array<string, mixed>  $data
     */
    protected function renderBlade(string $template, array $data = []): Crawler
    {
        return new Crawler(Blade::render($template, $data));
    }

    /**
     * Shares validation errors with the views, as a failed form request would.
     *
     * @param  array<string, string|array<int, string>>  $errors
     */
    protected function withViewErrors(array $errors, string $key = 'default'): self
    {
        View::share('errors', (new ViewErrorBag)->put($key, new MessageBag($errors)));

        return $this;
    }

    protected function setFramework(string $framework): self
    {
        Config::set('forms.framework', $framework);

        return $this;
    }

    protected function setFrameworkBootstrap6(): self
    {
        return $this->setFramework('bootstrap-6');
    }

    protected function setFrameworkOnu(): self
    {
        return $this->setFramework('onu');
    }

    protected function registerTestRoute($uri, ?callable $post = null): self
    {
        Route::middleware('web')->group(function () use ($uri, $post) {
            Route::view($uri, $uri)->name($uri);

            if ($post) {
                Route::post($uri, $post);
            }
        });

        return $this;
    }

    /**
     * Copied from https://github.com/spatie/laravel-medialibrary/issues/623#issuecomment-2110321741
     *
     * @return $this
     */
    protected function setupFakeMediaDisk(): self
    {
        Storage::fake('uploads');

        config()->set('filesystems.disks.media', [
            'driver' => 'local',
            'root' => Storage::disk('uploads')->path(''),
        ]);

        return $this;
    }
}
