<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class StatusTest extends TestCase
{
    public function test_it_can_generate_status_with_slot()
    {
        $this->registerTestRoute('status-slot');

        $this->visit('/status-slot')
            ->seeElement('span.status')
            ->within('span.status', function () {
                $this->seeElement('div.test')
                     ->seeInElement('div.test', 'Rejected');
            });
    }

    public function test_it_can_generate_material_admin_26_status()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('status');

        $this->visit('/status')
            ->seeElement('span.status.solid.bg-danger')
            ->within('span.status', function () {
                $this->seeText('Rejected');
            });
    }

    public function test_it_can_generate_bootstrap_5_status()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('status');

        $this->visit('/status')
            ->seeElement('span.status.badge.text-bg-danger')
            ->within('span.status', function () {
                $this->seeText('Rejected');
            });
    }
}
