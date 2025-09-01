<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PerPageTest extends TestCase
{
    #[Test]
    public function it_can_see_the_default_per_page_options_bs5()
    {
        $this->setFrameworkBootstrap5();

        $this->registerTestRoute('per-page')
            ->visit('/per-page')
            ->see('10')
            ->see('20')
            ->see('50')
            ->see('100')
            ->see('500');
    }

    #[Test]
    public function it_can_see_the_custom_per_page_options_bs5()
    {
        $this->setFrameworkBootstrap5();

        $this->withoutExceptionHandling();
        $this->registerTestRoute('per-page-custom')
            ->visit('/per-page-custom')
            ->see('11')
            ->see('22')
            ->see('55');
    }

    #[Test]
    public function it_can_see_the_default_per_page_options_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();

        $this->registerTestRoute('per-page')
            ->visit('/per-page')
            ->see('10')
            ->see('20')
            ->see('50')
            ->see('100')
            ->see('500');
    }

    #[Test]
    public function it_can_see_the_custom_per_page_options_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();

        $this->withoutExceptionHandling();
        $this->registerTestRoute('per-page-custom')
            ->visit('/per-page-custom')
            ->see('11')
            ->see('22')
            ->see('55');
    }
}
