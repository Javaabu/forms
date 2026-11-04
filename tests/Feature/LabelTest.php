<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LabelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
    }

    #[Test]
    public function it_can_generate_material_admin_label_with_a_slot()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('label-slot');

        $this->visit('/label-slot')
            ->seeElementCount('label', 1)
            ->within('label', function () {
                $this->seeElement('a')
                    ->seeInElement('a', 'some site');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_label_with_a_slot()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('label-slot');

        $this->visit('/label-slot')
            ->seeElementCount('label', 1)
            ->within('label', function () {
                $this->seeElement('a')
                    ->seeInElement('a', 'some site');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_blank_form_group()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-group-blank');

        $this->visit('/form-group-blank')
            ->seeElement('div.mb-4')
            ->within('div.mb-4', function () {
                $this->seeElement('span')
                    ->seeInElement('span', 'Test')
                    ->seeElement('label.form-label')
                    ->seeInElement('label.form-label', '');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_blank_label()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('label-blank');

        $page = $this->visit('/label-blank')
            ->seeElementCount('label', 1)
            ->seeInElement('label', '');
    }

    #[Test]
    public function it_can_generate_bootstrap_6_standard_form_labels()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-label');

        $page = $this->visit('/form-label')
            ->seeElementCount('label', 1)
            ->seeInElement('label', 'Title');

        $class = $page->crawler()->filter('label')->attr('class');

        $this->assertEquals('form-label', $class);
    }

    #[Test]
    public function it_can_generate_bootstrap_6_required_string_for_form_labels()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-label-required');

        $this->visit('/form-label-required')
            ->seeElementCount('label', 1)
            ->seeInElement('label', 'Title')
            ->within('label', function () {
                $this->seeElementCount('span.required', 1)
                    ->seeInElement('span.required', '*');
            });
    }

    #[Test]
    public function it_can_float_bootstrap_6_labels()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-label-floating');

        $page = $this->visit('/form-label-floating')
            ->seeElementCount('label', 1)
            ->seeInElement('label', 'Title');

        $class = $page->crawler()->filter('label')->attr('class');

        $this->assertNull($class);
    }

    #[Test]
    public function it_can_generate_bootstrap_6_inline_form_labels()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-label-inline');

        $page = $this->visit('/form-label-inline')
            ->seeElementCount('label', 1)
            ->seeInElement('label', 'Title');

        $class = $page->crawler()->filter('label')->attr('class');

        $this->assertEquals('sm:col-3 lg:col-2 col-form-label', $class);
    }

    #[Test]
    public function it_can_display_bootstrap_6_form_help_text()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-help');

        $this->visit('/form-help')
            ->seeElementCount('small.form-text', 1)
            ->seeInElement('small.form-text', 'This is a help text');
    }
}
