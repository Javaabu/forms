<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CheckboxTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_6_checkbox_with_slot()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('checkbox-slot');

        $this->visit('/checkbox-slot')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"].check')
                    ->seeElement('label.check-label')
                    ->within('label.check-label', function () {
                        $this->seeElement('a')
                            ->seeInElement('a', 'some site');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_checkbox()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-checkbox');

        $this->visit('/form-checkbox')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"].check')
                    ->seeElement('label.check-label')
                    ->seeInElement('label.check-label[for="check_me"]', 'Check Me');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_checkbox_that_is_required()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-checkbox-required');

        $this->visit('/form-checkbox-required')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][required].check')
                    ->seeElement('label.check-label[for="check_me"]')
                    ->seeInElement('label.check-label[for="check_me"]', 'Check Me')
                    ->within('label.check-label[for="check_me"]', function () {
                        $this->seeElement('span.required')
                            ->seeInElement('span.required', '*');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_checkbox_that_is_selected()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-checkbox-selected');

        $this->visit('/form-checkbox-selected')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][checked].check')
                    ->seeElement('label.check-label')
                    ->seeInElement('label.check-label[for="check_me"]', 'Check Me');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_checkbox_that_is_selected_from_model_binding()
    {
        $this->setFrameworkBootstrap6();

        $address = [
            'check_me' => '1',
        ];

        Route::get('form-checkbox-selected-model-binding', function () use ($address) {
            return view('form-checkbox-selected-model-binding')
                ->with('address', $address);
        })->middleware('web');

        $this->visit('/form-checkbox-selected-model-binding')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][checked].check')
                    ->seeElement('label.check-label')
                    ->seeInElement('label.check-label[for="check_me"]', 'Check Me');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_inline_form_checkbox_that_is_required()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-checkbox-inline-required');

        $this->visit('/form-checkbox-inline-required')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][required]')
                    ->seeElement('label.check-label[for="check_me"]')
                    ->dontSeeInElement('label.check-label[for="check_me"]', 'Check Me')
                    ->within('label.check-label[for="check_me"]', function () {
                        $this->dontSeeElement('span.required')
                            ->dontSeeInElement('span.required', '*');
                    });

            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_checkbox_with_helper_text()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-checkbox-helper-text');

        $this->visit('/form-checkbox-helper-text')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="checkbox"][required]')
                    ->seeElement('label.check-label[for="check_me"]');
            })
            ->seeElement('small.form-text')
            ->seeInElement('small.form-text', 'This is some help text.');
    }
}
