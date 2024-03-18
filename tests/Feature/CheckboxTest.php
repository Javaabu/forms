<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;

class CheckboxTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    /** @test */
    public function it_can_generate_bootstrap_5_form_checkbox()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-checkbox');

        $this->visit('/form-checkbox')
            ->seeElement('div.form-check')
            ->within('div.form-check', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"].form-check-input')
                    ->seeElement('label.form-check-label')
                    ->seeInElement('label.form-check-label[for="check_me"]', 'Check Me');
            });
    }

    /** @test */
    public function it_can_generate_bootstrap_5_form_checkbox_that_is_required()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-checkbox-required');

        $this->visit('/form-checkbox-required')
            ->seeElement('div.form-check')
            ->within('div.form-check', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][required].form-check-input')
                    ->seeElement('label.form-check-label[for="check_me"]')
                    ->seeInElement('label.form-check-label[for="check_me"]', 'Check Me')
                    ->within('label.form-check-label[for="check_me"]', function () {
                        $this->seeElement('span.text-danger')
                            ->seeInElement('span.text-danger', '*');
                    });
            });
    }

    /** @test */
    public function it_can_generate_bootstrap_5_form_checkbox_that_is_selected()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-checkbox-selected');

        $this->visit('/form-checkbox-selected')
            ->seeElement('div.form-check')
            ->within('div.form-check', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][checked].form-check-input')
                    ->seeElement('label.form-check-label')
                    ->seeInElement('label.form-check-label[for="check_me"]', 'Check Me');
            });
    }

    /** @test */
    public function it_can_generate_bootstrap_5_form_checkbox_that_is_selected_from_model_binding()
    {
        $this->setFrameworkBootstrap5();

        $address = [
            'check_me' => '1',
        ];

        Route::get('form-checkbox-selected-model-binding', function () use ($address) {
            return view('form-checkbox-selected-model-binding')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/form-checkbox-selected-model-binding')
            ->seeElement('div.form-check')
            ->within('div.form-check', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][checked].form-check-input')
                    ->seeElement('label.form-check-label')
                    ->seeInElement('label.form-check-label[for="check_me"]', 'Check Me');
            });
    }

    /** @test */
    public function it_can_generate_material_admin_26_form_checkbox()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-checkbox');

        $this->visit('/form-checkbox')
            ->seeElement('div.checkbox')
            ->within('div.checkbox', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"].form-check-input')
                    ->seeElement('label.checkbox__label')
                    ->seeInElement('label.checkbox__label[for="check_me"]', 'Check Me');
            });
    }

    /** @test */
    public function it_can_generate_material_admin_26_form_checkbox_that_is_required()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-checkbox-required');

        $this->visit('/form-checkbox-required')
            ->seeElement('div.checkbox')
            ->within('div.checkbox', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][required].form-check-input')
                    ->seeElement('label.checkbox__label[for="check_me"]')
                    ->seeInElement('label.checkbox__label[for="check_me"]', 'Check Me')
                    ->within('label.checkbox__label[for="check_me"]', function () {
                        $this->seeElement('span.text-danger')
                            ->seeInElement('span.text-danger', '*');
                    });
            });
    }

}
