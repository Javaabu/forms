<?php

namespace Javaabu\Forms\Tests\Feature\Frameworks;

use Javaabu\Forms\Frameworks\Onu;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OnuTest extends TestCase
{
    protected Onu $onu;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setFrameworkOnu();

        $this->onu = new Onu;
    }

    #[Test]
    public function it_renders_inputs_with_the_classes_onu_renders(): void
    {
        $html = $this->renderBlade('<x-forms::text name="title" label="ސުރުޚީ" required />');

        $field = $html->filter('div[data-slot="form-field"][data-label-layout="stacked"]');
        $input = $html->filter('input[data-slot="input"][name="title"]#title');

        $this->assertCount(1, $field);
        $this->assertCount(1, $input);
        $this->assertEquals($this->onu->classes('input.input'), $input->attr('class'));
        $this->assertEquals('ސުރުޚީ', trim($html->filter('label[data-slot="label"][for="title"]')->getNode(0)->firstChild->textContent));
        $this->assertCount(1, $html->filter('label span[data-slot="required-marker"][aria-hidden="true"]'));
    }

    #[Test]
    public function it_renders_help_text_and_errors_like_onu_form_field(): void
    {
        $this->withViewErrors(['title' => 'ސުރުޚީ ލިޔުން ލާޒިމް.']);

        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::text name="title">
                <x-slot:help>ދިވެހިން ލިޔޭ</x-slot:help>
            </x-forms::text>
            BLADE);

        $this->assertEquals('true', $html->filter('input[name="title"]')->attr('aria-invalid'));
        $this->assertStringContainsString('ދިވެހިން ލިޔޭ', $html->filter('p[data-slot="help-text"]')->text());
        $this->assertStringContainsString('ސުރުޚީ ލިޔުން ލާޒިމް.', $html->filter('div[data-slot="field-errors"][aria-live="polite"]')->text());
        $this->assertCount(1, $html->filter('div[data-slot="field-errors"] svg[data-icon="circle-alert"]'));
    }

    #[Test]
    public function it_lays_out_inline_fields_with_onu_inline_layout(): void
    {
        $html = $this->renderBlade('<x-forms::text name="title" inline />');

        $field = $html->filter('div[data-slot="form-field"][data-label-layout="inline"]');

        $this->assertCount(1, $field);
        $this->assertEquals($this->onu->classes('field_inline.grid'), $field->filter('div')->eq(1)->attr('class'));
    }

    #[Test]
    public function it_renders_prepend_and_append_as_an_input_group(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::number name="price">
                <x-slot:prepend>MVR</x-slot:prepend>
                <x-slot:append>.00</x-slot:append>
            </x-forms::number>
            BLADE);

        $this->assertCount(1, $html->filter('div[data-slot="input-group"][role="group"]'));
        $this->assertCount(1, $html->filter('div[data-slot="input-group-addon"][data-align="inline-start"]'));
        $this->assertCount(1, $html->filter('div[data-slot="input-group-addon"][data-align="inline-end"]'));
        $this->assertCount(1, $html->filter('input[data-slot="input-group-control"][name="price"]'));
    }

    #[Test]
    public function it_renders_selects_as_onu_native_selects(): void
    {
        $html = $this->renderBlade('<x-forms::select name="atoll" :options="[\'K\' => \'ކ. އަތޮޅު\']" />');

        $this->assertCount(1, $html->filter('div[data-slot="native-select-wrapper"] > select[data-slot="native-select"][name="atoll"]'));
        $this->assertCount(1, $html->filter('svg[data-slot="native-select-icon"]'));
        $this->assertStringContainsString('ކ. އަތޮޅު', $html->filter('option[value="K"]')->text());
    }

    #[Test]
    public function it_renders_native_checkboxes_and_radios_with_onu_classes(): void
    {
        $html = $this->renderBlade('<x-forms::checkbox name="agree" /><x-forms::radio name="gender" value="f" />');

        $checkbox = $html->filter('input[type="checkbox"][data-slot="checkbox"]#agree');
        $radio = $html->filter('input[type="radio"][data-slot="radio"]');

        $this->assertStringContainsString('checked:bg-primary', $checkbox->attr('class'));
        $this->assertStringContainsString('forms-checkbox', $checkbox->attr('class'));
        $this->assertStringContainsString('rounded-full', $radio->attr('class'));
        $this->assertCount(2, $html->filter('div[data-slot$="-field"] label'));
    }

    #[Test]
    public function it_maps_button_colours_to_onu_variants(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::button color="danger">A</x-forms::button>
            <x-forms::button color="outline-primary" type="submit">B</x-forms::button>
            <x-forms::link-button color="light" url="/x">C</x-forms::link-button>
            BLADE);

        $danger = $html->filter('button[data-variant="destructive"]');

        $this->assertEquals('button', $danger->attr('type'));
        $this->assertStringContainsString($this->onu->classes('button.destructive.default'), $danger->attr('class'));
        $this->assertCount(1, $html->filter('button[data-variant="outline"][type="submit"]'));
        $this->assertCount(1, $html->filter('a[data-slot="button"][data-variant="outline"][href="/x"]'));
    }

    #[Test]
    public function it_renders_status_badges_and_alerts_by_tone(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::status color="success">ފާސް</x-forms::status>
            <x-forms::alert type="danger" heading="މައްސަލައެއް" icon="circle-x" dismissible>ފޯމު ފުރިހަމަ ނުވޭ.</x-forms::alert>
            BLADE);

        $this->assertCount(1, $html->filter('span.status[data-slot="status-badge"][data-tone="success"]'));
        $this->assertCount(1, $html->filter('div[data-slot="callout"][data-tone="danger"][role="alert"]'));
        $this->assertEquals('މައްސަލައެއް', trim($html->filter('[data-slot="alert-title"]')->text()));
        $this->assertCount(1, $html->filter('[data-slot="callout"] button[data-part="callout-dismiss"]'));
    }

    #[Test]
    public function it_renders_modals_as_dialogs_with_onu_modal_classes(): void
    {
        $html = $this->renderBlade('<x-forms::modal id="edit" title="ބަދަލުކުރޭ" size="xl">Body<x-slot:footer>Footer</x-slot:footer></x-forms::modal>');

        $dialog = $html->filter('dialog.forms-dialog#edit[data-slot="dialog-content"][aria-labelledby="edit-title"]');

        $this->assertCount(1, $dialog);
        $this->assertStringContainsString('sm:max-w-4xl', $dialog->attr('class'));
        $this->assertCount(1, $html->filter('h2[data-slot="modal-title"]#edit-title'));
        $this->assertCount(1, $html->filter('[data-slot="modal-footer"]'));
    }

    #[Test]
    public function it_renders_cards_accordions_and_tabs_with_onu_slots(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::card>
                <x-slot:title>ކާޑު</x-slot:title>
                Body
                <x-slot:footer>Footer</x-slot:footer>
            </x-forms::card>
            <x-forms::accordion id="faq" :items="['one' => ['title' => 'ސުވާލު', 'content' => 'ޖަވާބު', 'show' => true]]" />
            <x-forms::tabs :tabs="[['name' => 'general'], ['name' => 'details']]" active="general">
                <x-slot:general>General</x-slot:general>
                <x-slot:details>Details</x-slot:details>
            </x-forms::tabs>
            BLADE);

        $this->assertCount(1, $html->filter('[data-slot="card"] [data-slot="card-header"] [data-slot="card-title"]'));
        $this->assertCount(1, $html->filter('[data-slot="card-footer"]'));
        $this->assertCount(1, $html->filter('div[data-slot="accordion"]#faq details[data-slot="accordion-item"][open][name="faq"] summary[data-slot="accordion-trigger"]'));
        $this->assertCount(2, $html->filter('[data-slot="tabs-list"][role="tablist"] button[role="tab"][data-slot="tabs-trigger"]'));
        $this->assertCount(1, $html->filter('button[role="tab"][data-state="active"][aria-selected="true"]'));
        $this->assertCount(1, $html->filter('[data-slot="tabs-content"].hidden'));
    }

    #[Test]
    public function it_renders_text_entries_as_onu_description_lists(): void
    {
        $html = $this->renderBlade('<x-forms::text-entry label="ނަން" value="އަޙްމަދު" inline />');

        $this->assertCount(1, $html->filter('dl[data-slot="description-list"][data-layout="inline"] dt[data-slot="description-list-label"]'));
        $this->assertStringContainsString('އަޙްމަދު', $html->filter('dd[data-slot="description-list-value"]')->text());
    }
}
