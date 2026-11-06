<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TextareaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_textarea()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-textarea');

        $this->visit('/form-textarea')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('textarea[name="title"][id="title"].form-control')
                    ->seeElement('textarea[rows="3"]')
                    ->seeInElement('textarea[name="title"][id="title"].form-control', 'Lorem ipsum')
                    ->seeElement('label.form-label')
                    ->seeInElement('label.form-label[for="title"]', 'Title');
            });
    }

    #[Test]
    public function it_adds_the_tinymce_script_to_the_scripts_stack_for_wysiwyg_inputs()
    {
        $this->registerTestRoute('wysiwyg');

        $this->visit('/wysiwyg')
            ->seeElement('textarea[name="title"][id="title"].wysiwyg')
            ->seeElement('script[src$="vendors/tinymce/tinymce.min.js"]');
    }

    #[Test]
    public function it_loads_tinymce_from_the_configured_url(): void
    {
        config()->set('forms.wysiwyg.tinymce_url', 'https://cdn.example.com/tinymce/7/tinymce.min.js');

        $this->registerTestRoute('wysiwyg');

        $this->visit('/wysiwyg')
            ->seeElement('script[src="https://cdn.example.com/tinymce/7/tinymce.min.js"]');
    }
}
