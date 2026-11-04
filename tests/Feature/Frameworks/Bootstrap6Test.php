<?php

namespace Javaabu\Forms\Tests\Feature\Frameworks;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class Bootstrap6Test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setFrameworkBootstrap6();
    }

    #[Test]
    public function it_renders_selects_with_form_control_instead_of_form_select(): void
    {
        $html = $this->renderBlade('<x-forms::select name="status" :options="[\'a\' => \'A\']" />');

        $this->assertCount(1, $html->filter('select.form-control[name="status"]'));
        $this->assertCount(0, $html->filter('.form-select'));
    }

    #[Test]
    public function it_renders_checkboxes_with_the_check_class_and_no_wrapper_class(): void
    {
        $html = $this->renderBlade('<x-forms::checkbox name="agree" />');

        $this->assertCount(1, $html->filter('div.form-field > input.check[type="checkbox"]#agree'));
        $this->assertCount(1, $html->filter('label.check-label[for="agree"]'));
        $this->assertCount(0, $html->filter('.form-check, .form-check-input'));
    }

    #[Test]
    public function it_maps_button_colours_to_variant_and_theme_classes(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::button color="primary">A</x-forms::button>
            <x-forms::button color="outline-danger">B</x-forms::button>
            <x-forms::button color="light">C</x-forms::button>
            <x-forms::button color="dark">D</x-forms::button>
            <x-forms::link-button color="link" url="/x">E</x-forms::link-button>
            BLADE);

        $this->assertCount(1, $html->filter('button.btn-solid.theme-primary'));
        $this->assertCount(1, $html->filter('button.btn-outline.theme-danger'));
        $this->assertCount(1, $html->filter('button.btn-subtle.theme-secondary'));
        $this->assertCount(1, $html->filter('button.btn-solid.theme-inverse'));
        $this->assertCount(1, $html->filter('a.btn-link[href="/x"]'));
    }

    #[Test]
    public function it_renders_modals_as_native_dialogs(): void
    {
        $html = $this->renderBlade(<<<'BLADE'
            <x-forms::modal id="edit-modal" title="ތަފްސީލު" size="xl">
                <p>Body</p>
                <x-slot:footer>Footer</x-slot:footer>
            </x-forms::modal>
            BLADE);

        $this->assertCount(1, $html->filter('dialog.dialog.dialog-xl#edit-modal[aria-labelledby="edit-modal-title"]'));
        $this->assertEquals('ތަފްސީލު', trim($html->filter('h2.dialog-title#edit-modal-title')->text()));
        $this->assertCount(1, $html->filter('.dialog-header button.btn-close[data-bs-dismiss="dialog"]'));
        $this->assertCount(1, $html->filter('.dialog-body p'));
        $this->assertEquals('Footer', trim($html->filter('.dialog-footer')->text()));
        $this->assertCount(0, $html->filter('.modal, .modal-dialog, .modal-content'));
    }

    #[Test]
    public function it_maps_legacy_modal_size_classes_to_dialog_sizes(): void
    {
        $html = $this->renderBlade('<x-forms::modal id="m" modal-size-class="modal-sm">Body</x-forms::modal>');

        $this->assertCount(1, $html->filter('dialog.dialog.dialog-sm#m'));
    }

    #[Test]
    public function it_renders_alerts_with_a_theme_an_icon_and_a_close_button(): void
    {
        $html = $this->renderBlade('<x-forms::alert type="danger" icon="circle-x" heading="Oops" dismissible>Body</x-forms::alert>');

        $this->assertCount(1, $html->filter('div.alert.theme-danger[role="alert"]'));
        $this->assertCount(1, $html->filter('.alert svg[data-icon="circle-x"]'));
        $this->assertEquals('Oops', trim($html->filter('h4.alert-heading')->text()));
        $this->assertCount(1, $html->filter('.alert button.btn-close[data-bs-dismiss="alert"]'));
        $this->assertCount(0, $html->filter('.alert-dismissible'));
    }

    #[Test]
    public function it_marks_invalid_inputs_for_assistive_technology(): void
    {
        $this->withViewErrors(['title' => 'ސުރުޚީ ލިޔުން ލާޒިމް.']);

        $html = $this->renderBlade('<x-forms::text name="title" />');

        $this->assertCount(1, $html->filter('input.form-control.is-invalid[aria-invalid="true"]'));
        $this->assertStringContainsString('ސުރުޚީ', $html->filter('.invalid-feedback')->text());
    }

    #[Test]
    public function it_uses_prefixed_responsive_classes_for_inline_fields(): void
    {
        $html = $this->renderBlade('<x-forms::text name="title" inline />');

        $this->assertCount(1, $html->filter('div.row.mb-4 > label.col-form-label[class~="sm:col-3"][class~="lg:col-2"]'));
        $this->assertCount(1, $html->filter('div.row.mb-4 > div[class~="sm:col-9"][class~="lg:col-10"] input.form-control'));
    }
}
