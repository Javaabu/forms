<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SearchFormTest extends TestCase
{
    #[Test]
    public function it_can_render_a_material_admin_26_search_form()
    {
        $this->setFrameworkMaterialAdmin26();

        $this->registerTestRoute('search-form');
        $this->registerTestRoute('pagination');

        $this->visit('/search-form?search=hello')
            ->seeElement('form.search[action="http://localhost/pagination"]')
            ->seeElement('input[name="search"][value="hello"]');
    }

    #[Test]
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
