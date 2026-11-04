<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class NoItemsTest extends TestCase
{
    #[Test]
    public function it_can_display_no_items_card_for_bootstrap_6()
    {
        $this->withoutExceptionHandling();
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('no-items');

        $this->visit('/no-items')
            ->see('Let\'s create some new activities')
            ->seeElement('svg[data-icon="file"]');
    }
}
