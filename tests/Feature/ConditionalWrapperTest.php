<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ConditionalWrapperTest extends TestCase
{
    #[Test]
    public function it_can_render_conditional_wrapper_bs5()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('conditional-wrapper');

        $this->visit('/conditional-wrapper')
            ->seeElement('div[data-enable-elem="#input"]');
    }

    #[Test]
    public function it_can_render_conditional_wrapper_powered_by_checkbox_bs5()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('conditional-wrapper-checkbox');

        $this->visit('/conditional-wrapper-checkbox')
            ->seeElement('div[data-enable-section-checkbox="#input"]');
    }

    #[Test]
    public function it_can_render_conditional_wrapper_material_26()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('conditional-wrapper');

        $this->visit('/conditional-wrapper')
            ->seeElement('div[data-enable-elem="#input"]');
    }

    #[Test]
    public function it_can_render_conditional_wrapper_powered_by_checkbox_material_26()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('conditional-wrapper-checkbox');

        $this->visit('/conditional-wrapper-checkbox')
            ->seeElement('div[data-enable-section-checkbox="#input"]');
    }
}
