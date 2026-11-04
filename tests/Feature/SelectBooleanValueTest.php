<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SelectBooleanValueTest extends TestCase
{
    #[Test]
    public function it_shows_the_select_field()
    {
        $this->registerTestRoute('select-boolean-value');

        $this->visit('/select-boolean-value')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="0"]');
    }

    #[Test]
    public function it_shows_the_false_value_selected()
    {
        $this->registerTestRoute('select-boolean-value');

        $this->visit('/select-boolean-value')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="0"][selected="selected"]');
    }
}
