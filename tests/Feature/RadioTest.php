<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RadioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_6_radio_with_slot()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('radio-slot');

        $this->visit('/radio-slot')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="check_me"][id="check_me"][type="radio"].radio')
                    ->seeElement('label.radio-label')
                    ->within('label.radio-label', function () {
                        $this->seeElement('a')
                            ->seeInElement('a', 'some site');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_radio()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-radio');

        $this->visit('/form-radio')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="status"][id="status"][type="radio"].radio')
                    ->seeElement('label.radio-label')
                    ->seeInElement('label.radio-label[for="status"]', 'Status 1');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_radio_that_is_required()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-radio-required');

        $this->visit('/form-radio-required')
            ->seeElement('div.form-field')
            ->within('div.form-field', function () {
                $this
                    ->seeElement('input[name="status"][id="status"][type="radio"][required].radio')
                    ->seeElement('label.radio-label[for="status"]')
                    ->seeInElement('label.radio-label[for="status"]', 'Status 1')
                    ->within('label.radio-label[for="status"]', function () {
                        $this->seeElement('span.required')
                            ->seeInElement('span.required', '*');
                    });
            });
    }
}
