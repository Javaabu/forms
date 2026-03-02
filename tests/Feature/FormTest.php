<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class FormTest extends TestCase
{
    public function test_it_can_render_a_form_with_an_action()
    {
        $this->registerTestRoute('form');

        $this->visit('/form')
            ->seeElement('form[action="http://localhost/users"]')
            ->seeElement('input#name');
    }
}
