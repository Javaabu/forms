<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BulkTest extends TestCase
{
    #[Test]
    public function it_can_generated_bulk_actions_for_bootstrap_6()
    {
        $this->setFrameworkBootstrap6();
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
