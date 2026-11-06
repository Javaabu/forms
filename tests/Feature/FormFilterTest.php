<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FormFilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    //    /** @test */
    //    public function it_can_generate_bootstrap_6_form_filter()
    //    {
    //        $this->setFrameworkBootstrap6();
    //        $this->registerTestRoute('form-filter');
    //
    //        $this->visit('/form-filter')
    //            // search field not hidden
    //            ->seeElement('input[type="text"][name="search"]')
    //            ->seeElement('select[name="select"]')
    //            ->seeElement('select[name="per_page"]')
    //            ->seeElement('input[type="hidden"][name="orderby"]')
    //            ->seeElement('input[type="hidden"][name="order"]');
    //    }

    #[Test]
    public function it_can_generate_bootstrap_6_form_filter()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('form-filter');

        $this->visit('/form-filter')
            // search field not hidden
            ->seeElement('input[type="text"][name="search"]')
            ->seeElement('select[name="select"]')
            ->seeElement('select[name="per_page"]')
            ->seeElement('input[type="hidden"][name="orderby"]')
            ->seeElement('input[type="hidden"][name="order"]');
    }
}
