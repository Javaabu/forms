<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ConditionalLinkTest extends TestCase
{
    #[Test]
    public function it_can_render_conditional_links_for_bootstrap_5()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('conditional-link');

        $this->visit('/conditional-link')
            ->seeElement('a[href="/admin/dashboard"]')
            ->within('a', function () {
                $this->seeText('Javaabu');
            });

    }

    #[Test]
    public function it_can_render_conditional_links_for_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('conditional-link');

        $this->visit('/conditional-link')
            ->seeElement('a[href="/admin/dashboard"]')
            ->within('a', function () {
                $this->seeText('Javaabu');
            });

    }
}
