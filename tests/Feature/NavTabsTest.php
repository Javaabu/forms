<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class NavTabsTest extends TestCase
{
    #[Test]
    public function it_can_generate_material_admin_26_nav_tabs()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('nav-tabs');

        $this->visit('/nav-tabs')
            ->seeElement('ul.nav.nav-tabs')
            ->within('ul.nav.nav-tabs', function () {
                // active tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link.active', 'Active Tab')
                    ->seeElement('a.nav-link[href="https://active-tab.test"]');

                // inactive tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link', 'Inactive Tab')
                    ->seeElement('a.nav-link[href="https://inactive-tab.test"]');

                // disabled tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link.disabled', 'Disabled Tab')
                    ->seeElement('a.nav-link[href="https://disabled-tab.test"]');

                // icon tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link', 'Icon Tab')
                    ->seeElement('a.nav-link i[class="zmdi zmdi-shield-security mr-2"]');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_nav_tabs()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('nav-tabs');

        $this->visit('/nav-tabs')
            ->seeElement('ul.nav.nav-tabs')
            ->within('ul.nav.nav-tabs', function () {
                // active tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link.active', 'Active Tab')
                    ->seeElement('a.nav-link[href="https://active-tab.test"]');

                // inactive tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link', 'Inactive Tab')
                    ->seeElement('a.nav-link[href="https://inactive-tab.test"]');

                // disabled tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link.disabled', 'Disabled Tab')
                    ->seeElement('a.nav-link[href="https://disabled-tab.test"]');

                // icon tabs
                $this->seeElement('li.nav-item')
                    ->seeElement('a.nav-link')
                    ->seeInElement('a.nav-link', 'Icon Tab')
                    ->seeElement('a.nav-link i[class="zmdi zmdi-shield-security mr-2"]');
            });
    }
}
