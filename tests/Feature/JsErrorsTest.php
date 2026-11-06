<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class JsErrorsTest extends TestCase
{
    #[Test]
    public function it_can_render_bootstrap_6_js_errors()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('js-errors');

        $this->visit('/js-errors')
            ->seeElement('ul.invalid-feedback.test-input-error');
    }
}
