<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SearchFormTest extends TestCase
{
    #[Test]
    public function it_can_render_a_bootstrap_6_search_form()
    {
        $this->setFrameworkBootstrap6();

        $this->registerTestRoute('search-form');
        $this->registerTestRoute('pagination');

        $this->visit('/search-form?search=hello')
            ->seeElement('form[action="http://localhost/pagination"]')
            ->seeElement('input[name="search"][value="hello"]');
    }
}
