<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Pagination\LengthAwarePaginator;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class DhivehiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app()->setLocale('dv');
    }

    /** @return array<string, array{string}> */
    public static function frameworks(): array
    {
        return ['onu' => ['onu'], 'bootstrap-6' => ['bootstrap-6']];
    }

    #[Test]
    public function it_has_a_dhivehi_line_for_every_english_line(): void
    {
        $en = require __DIR__ . '/../../lang/en/strings.php';
        $dv = require __DIR__ . '/../../lang/dv/strings.php';

        $this->assertEquals([], array_keys(array_diff_key($en, $dv)), 'Missing Dhivehi lines');
        $this->assertEquals([], array_keys(array_diff_key($dv, $en)), 'Dhivehi lines with no English line');
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_component_text_in_dhivehi(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::select2 name="atoll" :options="['K' => 'ކާފު އަތޮޅު']" />
            <x-forms::filter-submit cancel-url="/islands" />
            <x-forms::file name="cv" :model="false" />
            BLADE);

        $text = $html->text();

        $this->assertStringContainsString('އެއްވެސް އެއްޗެއް ޚިޔާރުނުކޮށް', $text);
        $this->assertStringContainsString('ކާފު އަތޮޅު', $text);
        $this->assertStringContainsString('ފިލްޓަރު ކުރޭ', $text);
        $this->assertStringContainsString('ފޮހެލާ', $text);
        $this->assertStringContainsString('ފައިލް ސެލެކްޓްކޮށްލާ', $text);
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_uses_thaana_labels_and_values_unchanged(string $framework): void
    {
        $this->setFramework($framework);

        $html = $this->renderBlade('<x-forms::text name="name_dv" label="ނަން" default="އަޙްމަދު މުޙައްމަދު" thaana required />');

        $this->assertStringContainsString('ނަން', $html->filter('label')->text());
        $this->assertEquals('އަޙްމަދު މުޙައްމަދު', $html->filter('input[name="name_dv"]')->attr('value'));
        $this->assertEquals('rtl', $html->filter('input[name="name_dv"]')->attr('dir'));
    }

    #[Test]
    #[DataProvider('frameworks')]
    public function it_renders_pagination_in_dhivehi(string $framework): void
    {
        $paginator = new LengthAwarePaginator(range(1, 10), 30, 10, 2, ['path' => '/']);

        $html = $this->renderBlade('<x-forms::pagination :paginator="$p" :framework="$framework" />', ['p' => $paginator, 'framework' => $framework]);

        $this->assertStringContainsString('ޖުމްލަ 30 އިން 10 ދައްކަނީ', $html->text());
        $this->assertCount(1, $html->filter('a[rel="prev"][aria-label="ކުރީގެ"]'));
        $this->assertCount(1, $html->filter('a[rel="next"][aria-label="ކުރިއަށް"]'));
    }
}
