<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RadioTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_5_form_checkbox()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-radio');

        $this->visit('/form-radio')
            ->seeElement('div.form-check')
            ->within('div.form-check', function () {
                $this
                    ->seeElement('input[name="status"][id="status"][type="radio"].form-check-input')
                    ->seeElement('label.form-check-label')
                    ->seeInElement('label.form-check-label[for="status"]', 'Status 1');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_form_checkbox_that_is_required()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-radio-required');

        $this->visit('/form-radio-required')
            ->seeElement('div.form-check')
            ->within('div.form-check', function () {
                $this
                    ->seeElement('input[name="status"][id="status"][type="radio"][required].form-check-input')
                    ->seeElement('label.form-check-label[for="status"]')
                    ->seeInElement('label.form-check-label[for="status"]', 'Status 1')
                    ->within('label.form-check-label[for="status"]', function () {
                        $this->seeElement('span.required')
                            ->seeInElement('span.required', '*');
                    });
            });
    }


    #[Test]
    public function it_can_generate_material_admin_26_form_checkbox()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-radio');

        $this->visit('/form-radio')
            ->seeElement('div.radio')
            ->within('div.radio', function () {
                $this
                    ->seeElement('input[name="status"][id="status"][type="radio"]')
                    ->seeElement('label.radio__label')
                    ->seeInElement('label.radio__label[for="status"]', 'Status 1');
            });
    }

    #[Test]
    public function it_can_generate_material_admin_26_form_checkbox_that_is_required()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-radio-required');

        $this->visit('/form-radio-required')
            ->seeElement('div.radio')
            ->within('div.radio', function () {
                $this
                    ->seeElement('input[name="status"][id="status"][type="radio"][required]')
                    ->seeElement('label.radio__label[for="status"]')
                    ->seeInElement('label.radio__label[for="status"]', 'Status 1')
                    ->within('label.radio__label[for="status"]', function () {
                        $this->seeElement('span.required')
                            ->seeInElement('span.required', '*');
                    });
            });
    }
}
