<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Manifest\Manifest;
use PHPUnit\Framework\Attributes\Test;

class AssetsTest extends TestCase
{
    protected function manifest(): Manifest
    {
        return app(Manifest::class);
    }

    #[Test]
    public function it_registers_its_assets_with_manifest(): void
    {
        $manifest = $this->manifest();

        $this->assertTrue($manifest->hasPackage('forms'));

        foreach (['forms::forms', 'forms::select', 'forms::dates', 'forms::files', 'forms::wysiwyg', 'forms::onu'] as $id) {
            $this->assertTrue($manifest->has($id), "{$id} is not registered");
        }

        $this->assertEquals('@javaabu/forms-blade', $manifest->packages()['forms']->importAlias());
    }

    #[Test]
    public function it_loads_select_scripts_and_styles_after_the_core_script(): void
    {
        $ids = array_map(fn ($asset) => $asset->id(), $this->manifest()->resolve(['forms::select']));

        $this->assertEquals(['forms::forms', 'forms::select-styles', 'forms::select'], $ids);
    }

    #[Test]
    public function components_require_only_the_assets_they_use(): void
    {
        $this->setFrameworkBootstrap6();

        $this->renderBlade('<x-forms::text name="title" />');

        $this->assertTrue($this->manifest()->isRequired('forms::forms'));
        $this->assertFalse($this->manifest()->isRequired('forms::select'));
        $this->assertFalse($this->manifest()->isRequired('forms::dates'));

        $this->renderBlade('<x-forms::select2 name="atoll" :options="[]" /><x-forms::date name="date" /><x-forms::file name="cv" /><x-forms::textarea name="body" wysiwyg />');

        foreach (['forms::select', 'forms::dates', 'forms::files', 'forms::wysiwyg'] as $id) {
            $this->assertTrue($this->manifest()->isRequired($id), "{$id} was not required");
        }
    }

    #[Test]
    public function plain_selects_and_textareas_dont_load_their_enhanced_scripts(): void
    {
        $this->setFrameworkBootstrap6();

        $this->renderBlade('<x-forms::select name="atoll" :options="[]" /><x-forms::textarea name="body" />');

        $this->assertFalse($this->manifest()->isRequired('forms::select'));
        $this->assertFalse($this->manifest()->isRequired('forms::wysiwyg'));
    }

    #[Test]
    public function onu_components_load_the_onu_stylesheet_unless_turned_off(): void
    {
        $this->setFrameworkOnu();

        $this->renderBlade('<x-forms::text name="title" />');

        $this->assertTrue($this->manifest()->isRequired('forms::onu'));

        $this->manifest()->requirements()->flush();
        Config::set('forms.assets.styles', false);

        $this->renderBlade('<x-forms::text name="title" />');

        $this->assertFalse($this->manifest()->isRequired('forms::onu'));
        $this->assertTrue($this->manifest()->isRequired('forms::forms'));
    }

    #[Test]
    public function bootstrap_6_components_never_load_the_onu_stylesheet(): void
    {
        $this->setFrameworkBootstrap6();

        $this->renderBlade('<x-forms::text name="title" />');

        $this->assertFalse($this->manifest()->isRequired('forms::onu'));
    }

    #[Test]
    public function assets_can_be_turned_off(): void
    {
        Config::set('forms.assets.enabled', false);

        $this->renderBlade('<x-forms::select2 name="atoll" :options="[]" />');

        $this->assertEquals([], $this->manifest()->required());
    }

    #[Test]
    public function it_injects_the_prebuilt_tags_once_into_html_pages(): void
    {
        Config::set('manifest.inject', true);
        $this->setFrameworkOnu();

        Route::get('/islands/create', fn () => Blade::render(<<<'BLADE'
            <html><head><title>ރަށް</title></head><body>
                <x-forms::select2 name="atoll" :options="['K' => 'ކާފު']" />
                <x-forms::select2 name="island" :options="[]" />
            </body></html>
            BLADE))->middleware('web');

        $html = $this->call('GET', '/islands/create')->getContent();

        $this->assertEquals(1, preg_match_all('/<script[^>]+src="[^"]*forms-[^"]*\.js"/', $html));
        $this->assertEquals(1, preg_match_all('/<script[^>]+src="[^"]*select-[^"]*\.js"/', $html));
        $this->assertMatchesRegularExpression('/<link[^>]+href="[^"]*select-[^"]*\.css"[^>]*>.*<\/head>/s', $html);
        $this->assertMatchesRegularExpression('/<link[^>]+href="[^"]*onu-standalone-[^"]*\.css"/', $html);
    }
}
