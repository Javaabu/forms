<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class NoItemsTest extends TestCase
{
    /** @test */
    public function it_can_generated_bulk_actions_for_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('no-items');

        $this->visit('/no-items')
            ->seeElement('.no-items')
            ->within('.no-items', function () {
                $this->see('Let\'s create some new activities');
            })
            ->seeElement('.zmdi.zmdi-file');
    }

    /** @test */
    public function it_can_generated_bulk_actions_for_bootstrap_5()
    {
        $this->withoutExceptionHandling();
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('no-items');

        $this->visit('/no-items')
            ->see('Let\'s create some new activities')
            ->seeElement('.fa-regular.fa-file');
    }
}
