<?php

namespace Javaabu\Forms\Tests\Feature\Frameworks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Forms\Tests\TestSupport\Models\Activity;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Renders every fixture view with every framework, so a framework can't miss a view
 * or break on one of the attribute combinations the feature tests use.
 */
class FrameworkSmokeTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, array{string, string}> */
    public static function views(): array
    {
        $views = [
            'accordion',
            'accordion-collapse',
            'accordion-header',
            'accordion-item',
            'accordion-slot',
            'accordion-unnamed',
            'boolean-entry',
            'bulk-actions',
            'button',
            'button-group',
            'button-link',
            'button-submit',
            'checkbox-slot',
            'conditional-link',
            'conditional-wrapper',
            'conditional-wrapper-checkbox',
            'date-inputs',
            'file-unbound',
            'file-value',
            'form',
            'form-card',
            'form-card-footer',
            'form-card-header',
            'form-card-subtitle',
            'form-card-title',
            'form-checkbox',
            'form-checkbox-helper-text',
            'form-checkbox-inline-required',
            'form-checkbox-required',
            'form-checkbox-selected',
            'form-filter',
            'form-group-blank',
            'form-help',
            'form-input',
            'form-input-floating',
            'form-input-help',
            'form-input-inline',
            'form-input-prepend-append',
            'form-input-required',
            'form-input-types',
            'form-input-without-label',
            'form-label',
            'form-label-floating',
            'form-label-inline',
            'form-label-required',
            'form-radio',
            'form-radio-required',
            'form-textarea',
            'js-errors',
            'label-blank',
            'label-slot',
            'latitude',
            'longitude',
            'multiple-select-keys',
            'nav-tabs',
            'no-items',
            'per-page',
            'per-page-custom',
            'radio-slot',
            'select-boolean-value',
            'select-multiple',
            'select-placeholder',
            'select-slot',
            'select-sync-field',
            'select-tags',
            'select-without-keys',
            'spoof-method',
            'status',
            'status-slot',
            'table',
            'table-cell',
            'table-cell-array',
            'table-cell-boolean',
            'table-cell-enum',
            'table-cell-model',
            'table-cell-multiline',
            'table-cell-status',
            'table-cell-value',
            'tabs',
            'text-entry',
            'text-entry-array',
            'text-entry-enum',
            'text-entry-model',
            'text-entry-multiline',
            'text-entry-status',
            'text-entry-value',
            'wysiwyg',
        ];

        $cases = [];

        foreach (['onu', 'bootstrap-6'] as $framework) {
            foreach ($views as $view) {
                $cases["{$framework} {$view}"] = [$framework, $view];
            }
        }

        return $cases;
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_laravel_pagination_with_every_framework(string $framework): void
    {
        $paginator = new LengthAwarePaginator(range(1, 10), 95, 10, 3, ['path' => '/articles']);

        $html = new Crawler($paginator->links("forms::{$framework}.pagination")->toHtml());

        $this->assertStringContainsString('95', $html->text());
        $this->assertCount(1, $html->filter('.page-item.active'));
        $this->assertCount(1, $html->filter('a[rel="prev"][href="/articles?page=2"]'));
        $this->assertCount(1, $html->filter('a[rel="next"][href="/articles?page=4"]'));
    }

    /** @return array<string, array{string}> */
    public static function frameworks(): array
    {
        return ['onu' => ['onu'], 'bootstrap-6' => ['bootstrap-6']];
    }

    #[Test]
    #[DataProvider('views')]
    public function it_renders_every_fixture_view_with_every_framework(string $framework, string $view): void
    {
        Activity::factory()->count(2)->create();

        $this->setFramework($framework);
        $this->registerTestRoute($view);

        $this->visit("/{$view}")
            ->assertResponseOk();
    }
}
