<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BulkTest extends TestCase
{
    #[Test]
    public function it_can_generated_bulk_actions_for_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('bulk-actions');

        $this->visit('/bulk-actions')
            ->seeElement('select')
            ->seeElement('option[value="approve"]')
            ->seeElement('option[value="ban"]')
            ->seeElement('option[value="delete"]')
            ->seeElement('button[type="submit"]')
            ->within('button[type="submit"]', function () {
                $this->see('Apply');
            });
    }

    #[Test]
    public function it_can_generated_bulk_actions_for_bootstrap_5()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('bulk-actions');

        $this->visit('/bulk-actions')
            ->seeElement('select')
            ->seeElement('option[value="approve"]')
            ->seeElement('option[value="ban"]')
            ->seeElement('option[value="delete"]')
            ->seeElement('button[type="submit"]')
            ->within('button[type="submit"]', function () {
                $this->see('Apply');
            });
    }
}
