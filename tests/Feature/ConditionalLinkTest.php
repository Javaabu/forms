<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class ConditionalLinkTest extends TestCase
{
    /** @test */
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

    /** @test */
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
