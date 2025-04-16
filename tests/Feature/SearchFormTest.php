<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class SearchFormTest extends TestCase
{
    /** @test */
    public function it_can_render_a_material_admin_26_search_form()
    {
        $this->setFrameworkMaterialAdmin26();

        $this->registerTestRoute('search-form');
        $this->registerTestRoute('pagination');

        $this->visit('/search-form?search=hello')
            ->seeElement('form.search[action="http://localhost/pagination"]')
            ->seeElement('input[name="search"][value="hello"]');
    }

    /** @test */
    public function it_can_render_a_bootstrap_5_search_form()
    {
        $this->setFrameworkBootstrap5();

        $this->registerTestRoute('search-form');
        $this->registerTestRoute('pagination');

        $this->visit('/search-form?search=hello')
            ->seeElement('form[action="http://localhost/pagination"]')
            ->seeElement('input[name="search"][value="hello"]');
    }
}
