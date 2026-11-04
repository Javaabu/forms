<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class StatusTest extends TestCase
{
    #[Test]
    public function it_can_generate_status_with_slot()
    {
        $this->registerTestRoute('status-slot');

        $this->visit('/status-slot')
            ->seeElement('span.status')
            ->within('span.status', function () {
                $this->seeElement('div.test')
                    ->seeInElement('div.test', 'Rejected');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_status()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('status');

        $this->visit('/status')
            ->seeElement('span.status.badge.theme-danger')
            ->within('span.status', function () {
                $this->seeText('Rejected');
            });
    }
}
