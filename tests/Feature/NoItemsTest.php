<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class NoItemsTest extends TestCase
{
    #[Test]
    public function it_can_display_no_items_card_for_material_admin_26()
    {
        $this->withoutExceptionHandling();
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('no-items');

        $this->visit('/no-items')
            ->seeElement('.no-items')
            ->within('.no-items', function () {
                $this->see('Let\'s create some new activities');
            })
            ->seeElement('.zmdi.zmdi-file');
    }

    #[Test]
    public function it_can_display_no_items_card_for_bootstrap_5()
    {
        $this->withoutExceptionHandling();
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('no-items');

        $this->visit('/no-items')
            ->see('Let\'s create some new activities')
            ->seeElement('.fa-regular.fa-file');
    }
}
