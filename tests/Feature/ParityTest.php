<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Attributes and components added in v2 to match @javaabu/forms (see docs/parity.md).
 */
class ParityTest extends TestCase
{
    /** @return array<string, array{string}> */
    public static function frameworks(): array
    {
        return ['onu' => ['onu'], 'bootstrap-6' => ['bootstrap-6']];
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_adds_form_group_class_to_any_field_wrapper(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade('<x-forms::text name="title" form-group-class="col-span-2" /><x-forms::checkbox name="agree" form-group-class="mt-6" />');

        $this->assertCount(1, $html->filter('div.col-span-2 input[name="title"]'));
        $this->assertCount(1, $html->filter('div.mt-6 input[name="agree"]'));
        $this->assertNull($html->filter('input[name="title"]')->attr('form-group-class'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_marks_thaana_fields_like_onu(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade('<x-forms::text name="name_dv" thaana /><x-forms::textarea name="bio_dv" thaana auto-resize />');

        $input = $html->filter('input[name="name_dv"]');
        $textarea = $html->filter('textarea[name="bio_dv"]');

        $this->assertEquals('rtl', $input->attr('dir'));
        $this->assertEquals('dv', $input->attr('lang'));
        $this->assertNotNull($input->attr('data-thaana'));
        $this->assertEquals('dv', $textarea->attr('lang'));
        $this->assertEquals('true', $textarea->attr('data-auto-resize'));
        $this->assertNull($input->attr('thaana'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_passes_decimals_to_number_inputs(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade('<x-forms::number name="price" decimals="2" step="0.01" />');

        $this->assertEquals('2', $html->filter('input[name="price"]')->attr('data-decimals'));
        $this->assertEquals('0.01', $html->filter('input[name="price"]')->attr('step'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_button_sizes_icons_and_loading(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::button size="sm" start-icon="plus" end-icon="chevron-right">ސޭވްކުރޭ</x-forms::button>
            <x-forms::submit loading>Saving</x-forms::submit>
            <x-forms::link-button url="/x" disabled>Link</x-forms::link-button>
            BLADE);

        $button = $html->filter('button')->eq(0);

        $this->assertCount(1, $button->filter('svg[data-icon-name="plus"][data-icon="inline-start"]'));
        $this->assertCount(1, $button->filter('svg[data-icon-name="chevron-right"][data-icon="inline-end"]'));
        $this->assertStringContainsString($framework === 'onu' ? 'h-7' : 'btn-sm', $button->attr('class'));

        $submit = $html->filter('button[type="submit"]');

        $this->assertEquals('true', $submit->attr('aria-busy'));
        $this->assertNull($submit->filter('svg[data-slot="button-spinner"]')->attr('hidden'));

        $link = $html->filter('a');

        $this->assertNull($link->attr('href'));
        $this->assertEquals('true', $link->attr('aria-disabled'));
    }

    #[Test]
    public function it_hides_the_submit_spinner_until_the_form_submits(): void
    {
        $html = $this->renderBlade('<x-forms::submit>Save</x-forms::submit>');

        $this->assertNotNull($html->filter('button.animate-submit svg[data-slot="button-spinner"]')->attr('hidden'));
    }

    #[Test]
    public function it_accepts_clearable_min_chars_and_parent_on_select2(): void
    {
        $html = $this->renderBlade('<x-forms::select2 name="island" :options="[]" parent="#atoll" min-chars="2" :clearable="false" is-ajax ajax-url="/islands" />');

        $select = $html->filter('select[name="island"]');

        $this->assertEquals('#atoll', $select->attr('data-select-parent'));
        $this->assertEquals('2', $select->attr('data-minimum-input-length'));
        $this->assertNull($select->attr('data-allow-clear'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_can_show_every_error_message_for_a_field(string $framework): void
    {
        $this->setFramework($framework);
        $this->withViewErrors(['password' => ['ދިގުމިން 8 އަކުރު', 'އަދަދެއް ހިމަނަންވާނެ']]);

        $first = $this->renderBlade('<x-forms::errors name="password" />');
        $all = $this->renderBlade('<x-forms::errors name="password" :first-only="false" />');

        $this->assertStringNotContainsString('އަދަދެއް', $first->text());
        $this->assertStringContainsString('ދިގުމިން 8 އަކުރު', $all->text());
        $this->assertStringContainsString('އަދަދެއް ހިމަނަންވާނެ', $all->text());
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_an_error_summary_linking_to_each_field(string $framework): void
    {
        $this->setFramework($framework);
        $this->withViewErrors(['name' => 'ނަން ލިޔުއްވާ.', 'address.city' => 'ރަށް ޚިޔާރުކުރައްވާ.']);

        $html = $this->renderBlade('<x-forms::form summary><x-forms::text name="name" /></x-forms::form>');

        $summary = $html->filter('form > [data-forms-summary][role="alert"]');

        $this->assertCount(1, $summary);
        $this->assertStringContainsString('ތިރީގައިވާ ގޯސްތައް', $this->renderBladeInDhivehi('<x-forms::error-summary />')->text());
        $this->assertCount(1, $summary->filter('a[href="#name"]'));
        $this->assertCount(1, $summary->filter('a[href="#address-city"]'));
        $this->assertNotNull($html->filter('form')->attr('data-focus-on-error'));
    }

    #[Test]
    public function it_renders_no_summary_by_default_like_v1(): void
    {
        $this->withViewErrors(['name' => 'Required']);

        $html = $this->renderBlade('<x-forms::form><x-forms::text name="name" /></x-forms::form>');

        $this->assertCount(0, $html->filter('[data-forms-summary]'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_a_paginator_with_the_pagination_component(string $framework): void
    {
        $this->setFramework($framework);

        $paginator = new LengthAwarePaginator(range(1, 10), 30, 10, 2, ['path' => '/posts']);

        $html = $this->renderBlade('<x-forms::pagination :paginator="$paginator" />', ['paginator' => $paginator]);

        $this->assertCount(1, $html->filter('a[rel="next"][href="/posts?page=3"]'));
    }

    #[Test]
    public function it_formats_values_like_text_entries(): void
    {
        $html = $this->renderBlade('<x-forms::formatted-value :value="[\'މާލެ\', \'އައްޑޫ\']" /> | <x-forms::formatted-value :value="null" />');

        $this->assertStringContainsString('މާލެ,އައްޑޫ', $html->text());
        $this->assertStringContainsString('-', $html->text());
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_supports_disabled_accordion_items_modal_descriptions_and_multiple_files(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::accordion.item name="one" parent="faq" title="Q" disabled show>A</x-forms::accordion.item>
            <x-forms::modal id="m" title="T" description="ތަފްޞީލް">Body</x-forms::modal>
            <x-forms::file name="attachments" multiple :model="false" />
            BLADE);

        $item = $html->filter('details[data-disabled="true"]');

        $this->assertCount(1, $item);
        $this->assertNull($item->attr('open'));
        $this->assertStringContainsString('ތަފްޞީލް', $html->filter('dialog#m')->text());
        $this->assertCount(1, $html->filter('input[type="file"][name="attachments[]"][multiple]'));
    }

    #[Test]
    public function it_can_label_the_per_page_select(): void
    {
        $html = $this->renderBlade('<x-forms::per-page show-label :per-page="50" />');

        $this->assertStringContainsString('Per page', $html->filter('label')->text());
        $this->assertCount(1, $html->filter('select[name="per_page"] option[value="50"][selected]'));
    }

    protected function renderBladeInDhivehi(string $template): Crawler
    {
        app()->setLocale('dv');

        try {
            return $this->renderBlade($template);
        } finally {
            app()->setLocale('en');
        }
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_does_not_duplicate_value_or_id_attributes(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade('<x-forms::hidden name="redirect" value="/back" /><x-forms::checkbox name="agree" id="agree-terms" />');

        $this->assertEquals(1, substr_count($html->html(), 'value="/back"'));
        $this->assertEquals(1, substr_count($html->html(), 'id="agree-terms"'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_escapes_textarea_values(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade('<x-forms::textarea name="body" :default="$value" />', ['value' => '</textarea><script>alert(1)</script>']);

        $this->assertCount(0, $html->filter('script'));
        $this->assertEquals('</textarea><script>alert(1)</script>', $html->filter('textarea')->text());
    }

    #[Test]
    public function it_stops_binding_the_form_model_after_the_form(): void
    {
        $html = $this->renderBlade('<x-forms::form :model="$article"><x-forms::text name="title" /></x-forms::form><x-forms::text name="title" id="after" />', ['article' => ['title' => 'ރާއްޖެ']]);

        $this->assertEquals('ރާއްޖެ', $html->filter('form input[name="title"]')->attr('value'));
        $this->assertEquals('', $html->filter('input#after')->attr('value'));
    }

    #[Test]
    public function search_forms_respect_the_framework_attribute(): void
    {
        $this->setFrameworkOnu();

        $html = $this->renderBlade('<x-forms::search-form action="/islands" framework="bootstrap-6" />');

        $this->assertCount(1, $html->filter('input.form-control[name="search"]'));
    }

    #[Test]
    public function radios_are_checked_only_for_their_own_value(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::form :model="$island">
                <x-forms::radio name="type" value="inhabited" id="type-inhabited" />
                <x-forms::radio name="type" value="resort" id="type-resort" />
                <x-forms::checkbox name="is_capital" />
            </x-forms::form>
            BLADE, ['island' => ['type' => 'resort', 'is_capital' => true]]);

        $this->assertNull($html->filter('#type-inhabited')->attr('checked'));
        $this->assertNotNull($html->filter('#type-resort')->attr('checked'));
        $this->assertNotNull($html->filter('input[name="is_capital"]')->attr('checked'));
    }

    #[Test]
    public function bound_dates_use_the_format_of_their_picker(): void
    {
        $event = new class extends Model
        {
            protected $casts = ['starts_at' => 'datetime'];
        };

        $event->starts_at = '2026-11-04 08:30:15';

        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::date name="starts_at" :model="$event" id="d" />
            <x-forms::datetime name="starts_at" :model="$event" id="dt" />
            <x-forms::time name="starts_at" :model="$event" id="t" />
            <x-forms::time name="starts_at" :model="$event" id="t2" date-format="H:i:s" />
            BLADE, ['event' => $event]);

        $this->assertEquals('2026-11-04', $html->filter('#d')->attr('value'));
        $this->assertEquals('2026-11-04 08:30', $html->filter('#dt')->attr('value'));
        $this->assertEquals('08:30', $html->filter('#t')->attr('value'));
        $this->assertEquals('08:30:15', $html->filter('#t2')->attr('value'));
        $this->assertNull($html->filter('#t2')->attr('date-format'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_simple_paginators(string $framework): void
    {
        $this->setFramework($framework);

        $paginator = new Paginator(range(1, 11), 10, 1, ['path' => '/posts']);

        $html = $this->renderBlade('<x-forms::pagination :paginator="$paginator" />', ['paginator' => $paginator]);

        $this->assertCount(1, $html->filter('a[rel="next"][href="/posts?page=2"]'));
    }

    #[Test]
    public function conditional_links_hide_for_guests_instead_of_failing(): void
    {
        $html = $this->renderBlade('<x-forms::conditional-link url="/admin/islands/1" can="update" :arg="null" value="ހުޅުމާލެ" />');

        $this->assertCount(0, $html->filter('a'));
        $this->assertStringContainsString('ހުޅުމާލެ', $html->text());
    }
}
