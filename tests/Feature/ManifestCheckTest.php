<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Manifest\Enums\NpmScopes;
use Javaabu\Manifest\Manifest;
use PHPUnit\Framework\Attributes\Test;

class ManifestCheckTest extends TestCase
{
    /**
     * What a Blade-only app installs for javaabu/forms: what manifest:check asks for.
     *
     * @var array<string, string>
     */
    protected array $blade_app = [
        '@javaabu/onu' => '0.2.1',
        'flatpickr' => '4.6.13',
        'laravel-vite-plugin' => '2.0.1',
        'react' => '19.3.1',
        'tailwindcss' => '4.3.4',
        'tom-select' => '2.4.3',
        'vite' => '8.3.5',
    ];

    protected function tearDown(): void
    {
        File::delete(base_path('package.json'));
        File::deleteDirectory(base_path('node_modules'));

        parent::tearDown();
    }

    /**
     * Writes the app's package.json and node_modules, as manifest's own tests do.
     *
     * @param  array<string, string>  $installed
     */
    protected function installNpm(array $installed): void
    {
        File::put(base_path('package.json'), json_encode(['devDependencies' => array_map(fn ($version) => "^{$version}", $installed)]));

        foreach ($installed as $name => $version) {
            File::ensureDirectoryExists(base_path("node_modules/{$name}"));
            File::put(base_path("node_modules/{$name}/package.json"), json_encode(['name' => $name, 'version' => $version]));
        }
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, array<string, mixed>>
     */
    protected function manifestCheck(array $options = []): array
    {
        Artisan::call('manifest:check', ['--json' => true, ...$options]);

        return collect(json_decode(Artisan::output(), true))->keyBy('name')->all();
    }

    #[Test]
    public function it_asks_blade_apps_only_for_what_its_blade_scripts_and_styles_import(): void
    {
        $package = app(Manifest::class)->packages()['forms'];

        $this->assertEquals(['flatpickr', 'tom-select'], array_keys($package->npmDependencies(NpmScopes::ASSETS)));
        $this->assertEquals(['@javaabu/onu', 'tailwindcss', 'react'], array_keys($package->npmPeerDependencies(NpmScopes::ASSETS)));

        // Not the React @javaabu/forms, react-dom or Inertia: forms has no pages, and the
        // JS apps import through @javaabu/forms-blade is the same Blade code.
        $this->assertSame([], $package->npmDependencies(NpmScopes::PAGES));
        $this->assertSame([], $package->npmPeerDependencies(NpmScopes::PAGES));
    }

    #[Test]
    public function manifest_check_passes_in_a_blade_only_app_without_react_forms_or_inertia(): void
    {
        $this->installNpm($this->blade_app);

        $rows = $this->manifestCheck();

        $this->assertEqualsCanonicalizing(array_keys($this->blade_app), array_keys($rows));
        $this->assertArrayNotHasKey('@javaabu/forms', $rows);
        $this->assertArrayNotHasKey('react-dom', $rows);

        foreach ($rows as $name => $row) {
            $this->assertEquals('ok', $row['status'], $name);
            $this->assertEquals(['assets'], $row['scopes'], $name);
        }

        $this->assertSame(0, Artisan::call('manifest:check'));
    }

    #[Test]
    public function manifest_check_asks_for_react_because_onu_thaana_imports_it(): void
    {
        $this->installNpm(array_diff_key($this->blade_app, ['react' => true]));

        $rows = $this->manifestCheck();

        $this->assertEquals('missing', $rows['react']['status']);
        $this->assertEquals(['forms'], $rows['react']['needed_by']);

        $this->assertSame(1, Artisan::call('manifest:check'));
    }

    #[Test]
    public function forms_needs_nothing_for_inertia_pages_beyond_manifest_build_tools(): void
    {
        $this->installNpm([...$this->blade_app, '@inertiajs/react' => '2.3.0']);

        $rows = collect($this->manifestCheck(['--scope' => ['pages']]))
            ->filter(fn ($row) => in_array('forms', $row['needed_by'] ?? []));

        // manifest adds its build tools to every scope; forms declares nothing for pages.
        $this->assertEqualsCanonicalizing(['laravel-vite-plugin', 'vite'], $rows->keys()->all());
    }
}
