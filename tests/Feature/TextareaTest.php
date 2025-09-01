<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TextareaTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_5_form_textarea()
    {
        $this->setFrameworkBootstrap5();
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
    public function it_can_generate_material_admin_26_form_textarea()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-textarea');

        $this->visit('/form-textarea')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('textarea[name="title"][id="title"].form-control')
                    ->seeElement('textarea[rows="3"]')
                    ->seeInElement('textarea[name="title"][id="title"].form-control', 'Lorem ipsum')
                    ->seeElement('i.form-group__bar')
                    ->seeElement('label[for="title"]')
                    ->seeInElement('label', 'Title');
            });
    }

    #[Test]
    public function it_adds_the_tinymce_script_to_the_scripts_stack_for_wysiwyg_inputs()
    {
        $this->registerTestRoute('wysiwyg');

        $this->visit('/wysiwyg')
            ->seeElement('textarea[name="title"][id="title"].wysiwyg')
            ->seeElement('script')
            ->seeInElement('script', 'tinymce');
    }
}
