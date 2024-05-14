<?php

namespace Javaabu\Forms\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Javaabu\Forms\FormsServiceProvider;
use Javaabu\Forms\Tests\TestSupport\Providers\TestServiceProvider;
use Javaabu\Settings\SettingsServiceProvider;
use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://localhost';

    public static function isLaravel10(): bool
    {
        return version_compare(app()->version(), '10.0', '>=');
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:yWa/ByhLC/GUvfToOuaPD7zDwB64qkc/QkaQOrT5IpE=');

        $this->app['config']->set('session.serialization', 'php');

        //$this->app['config']->set('form-components.framework', env('FORM_COMPONENTS_FRAMEWORK', 'tailwind'));

        View::addLocation(__DIR__ . '/TestSupport/views');

        Model::unguard();
    }

    protected function getPackageProviders($app)
    {
        return [
            SettingsServiceProvider::class,
            MediaLibraryServiceProvider::class,
            FormsServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    protected function setFramework(string $framework): self
    {
        Config::set('forms.framework', $framework);

        return $this;
    }

    protected function setFrameworkBootstrap5(): self
    {
        return $this->setFramework('bootstrap-5');
    }

    protected function setFrameworkMaterialAdmin26(): self
    {
        return $this->setFramework('material-admin-26');
    }

    protected function registerTestRoute($uri, callable $post = null): self
    {
        Route::middleware('web')->group(function () use ($uri, $post) {
            Route::view($uri, $uri);

            if ($post) {
                Route::post($uri, $post);
            }
        });

        return $this;
    }
}
