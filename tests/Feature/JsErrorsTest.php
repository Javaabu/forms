<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class JsErrorsTest extends TestCase
{
    #[Test]
    public function it_can_render_bootstrap_5_js_errors()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('js-errors');

        $this->visit('/js-errors')
            ->seeElement('ul.invalid-feedback.test-input-error');
    }

    #[Test]
    public function it_can_render_material_admin_26_js_errors()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('js-errors');

        $this->visit('/js-errors')
            ->seeElement('ul.invalid-feedback.test-input-error');
    }
}
