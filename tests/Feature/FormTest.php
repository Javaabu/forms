<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FormTest extends TestCase
{
    #[Test]
    public function it_can_render_a_form_with_an_action()
    {
        $this->registerTestRoute('form');

        $this->visit('/form')
            ->seeElement('form[action="http://localhost/users"]')
            ->seeElement('input#name');
    }
}
