<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class SelectBooleanValueTest extends TestCase
{
    public function test_it_shows_the_select_field()
    {
        $this->registerTestRoute('select-boolean-value');

        $this->visit('/select-boolean-value')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="0"]');
    }

    public function test_it_shows_the_false_value_selected()
    {
        $this->registerTestRoute('select-boolean-value');

        $this->visit('/select-boolean-value')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="0"][selected="selected"]');
    }
}
