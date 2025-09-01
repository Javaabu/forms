<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class InputTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_5_form_inputs_with_input_group()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input-prepend-append');

        $this->visit('/form-input-prepend-append')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('div.input-group')
                    ->seeElement('label.form-label')
                    ->seeInElement('label.form-label[for="title"]', 'Title')
                    ->within('div.input-group', function () {
                        $this->seeElement('div.input-group-text.prepend')
                            ->seeInElement('div.input-group-text.prepend', 'MVR')
                            ->seeElement('input[name="title"][value="Lorem ipsum"].form-control')
                            ->seeElement('div.input-group-text.append')
                            ->seeInElement('div.input-group-text.append', 'New Link');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_form_inputs_without_form_group()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input-without-label');

        $this->visit('/form-input-without-label')
            ->seeElement('input[name="title"][value="Lorem ipsum"].form-control')
            ->dontSeeElement('label')
            ->dontSeeElement('div.mb-4');
    }

    #[Test]
    public function it_can_generate_material_admin_26_form_inputs_without_form_group()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-input-without-label');

        $this->visit('/form-input-without-label')
            ->seeElement('input[name="title"][value="Lorem ipsum"].form-control')
            ->dontSeeElement('label')
            ->dontSeeElement('div.form-group');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_form_inputs()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input');

        $this->visit('/form-input')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('input[name="title"][value="Lorem ipsum"].form-control')
                    ->seeElement('label.form-label')
                    ->seeInElement('label.form-label[for="title"]', 'Title');
            });
    }

    #[Test]
    public function it_can_set_form_inputs_as_required()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input-required');

        $this->visit('/form-input-required')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('input[name="title"][value="Lorem ipsum"][id="title"][required].form-control')
                    ->seeElement('label.form-label[for="title"]')
                    ->seeInElement('label.form-label[for="title"]', 'Title')
                    ->within('label.form-label[for="title"]', function () {
                        $this->seeElement('span.required')
                             ->seeInElement('span.required', '*');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_inline_form_inputs()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input-inline');

        $this->visit('/form-input-inline')
            ->seeElement('div.row.mb-4')
            ->within('div.row.mb-4', function () {
                $this->seeElement('label.col-form-label[for="title"]')
                    ->seeInElement('label.col-form-label[for="title"]', 'Title')
                    ->seeElement('div.col-sm-9.col-lg-10')
                    ->within('div.col-sm-9.col-lg-10', function () {
                        $this->seeElement('input[name="title"][id="title"][value="Lorem ipsum"].form-control');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_floating_form_inputs()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input-floating');

        $this->visit('/form-input-floating')
            ->seeElement('div.form-floating')
            ->within('div.form-floating', function () {
                $this->seeElement('label[for="title"]')
                    ->seeInElement('label[for="title"]', 'Title')
                    ->seeElement('input[name="title"][id="title"][value="Lorem ipsum"].form-control');
            });
    }

    #[Test]
    public function it_can_display_form_input_help_texts()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-input-help');

        $this->visit('/form-input-help')
            ->seeElement('div')
            ->within('div', function () {
                $this->seeElement('input[name="title"][value="Lorem ipsum"][id="title"].form-control')
                    ->seeElement('label.form-label[for="title"]')
                    ->seeElement('div.form-text')
                    ->seeInElement('div.form-text', 'This is some help text.');

            });
    }

    #[Test]
    public function it_can_generate_material_admin_26_form_inputs()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-input');

        $this->visit('/form-input')
            ->seeElement('div.form-group')
            ->within('div.form-group', function () {
                $this->seeElement('input[name="title"][value="Lorem ipsum"].form-control')
                    ->seeElement('i.form-group__bar')
                    ->seeElement('label[for="title"]')
                    ->seeInElement('label', 'Title');
            });
    }

    #[Test]
    public function it_can_generate_different_form_input_types()
    {
        $this->registerTestRoute('form-input-types');

        $this->visit('/form-input-types')
            ->seeElement('input[name="number_input"][type="number"]')
            ->seeElement('input[name="number"][type="number"]')
            ->seeElement('input[name="text"][type="text"]')
            ->seeElement('input[name="email"][type="email"]')
            ->seeElement('input[name="password"][type="password"]')
            ->seeElement('input[name="url"][type="url"]')
            ->seeElement('input[name="tel"][type="tel"]');
    }

    #[Test]
    public function it_can_generate_latitude_inputs()
    {
        $this->registerTestRoute('latitude');

        $this->visit('/latitude')
            ->seeElement('input[name="latitude"][type="number"][step="0.000001"][min="-90"][max="90"]');
    }

    #[Test]
    public function it_can_generate_longitude_inputs()
    {
        $this->registerTestRoute('longitude');

        $this->visit('/longitude')
            ->seeElement('input[name="longitude"][type="number"][step="0.000001"][min="-180"][max="180"]');
    }
}
