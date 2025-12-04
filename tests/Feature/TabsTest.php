<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TabsTest extends TestCase
{
    #[Test]
    public function it_can_generate_material_admin_26_tabs()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('tabs');

        $this->visit('/tabs')
            ->seeElement('div.tab-container')
            ->within('.tab-container', function () {
                $this->seeElement('ul.nav.nav-tabs')
                    ->within('ul.nav.nav-tabs', function () {
                        // first tab
                        $this->seeElement('li.nav-item:nth-child(1)')
                            ->within('li.nav-item:nth-child(1)', function () {
                                $this->seeElement('a.nav-link[href="#first-tab"][data-toggle="tab"][role="tab"]')
                                    ->seeInElement('a.nav-link', 'First Tab Title')
                                    ->dontSeeElement('a.active');
                            });

                        // active tab
                        $this->seeElement('li.nav-item:nth-child(2)')
                            ->within('li.nav-item:nth-child(2)', function () {
                                $this->seeElement('a.nav-link.active[href="#active-tab"][data-toggle="tab"][role="tab"]')
                                    ->seeInElement('a.nav-link', 'Active Tab');
                            });

                        // disabled tab
                        $this->seeElement('li.nav-item:nth-child(3)')
                            ->within('li.nav-item:nth-child(3)', function () {
                                $this->seeElement('a.nav-link.disabled[href="#disabled-tab"][data-toggle="tab"][role="tab"]')
                                    ->seeInElement('a.nav-link', 'Disabled Tab')
                                    ->dontSeeElement('a.active');
                            });

                        // external tab
                        $this->seeElement('li.nav-item:nth-child(4)')
                            ->within('li.nav-item:nth-child(4)', function () {
                                $this->seeElement('a.nav-link[href="http://example.com"]')
                                    ->seeInElement('a.nav-link', 'External Tab')
                                    ->dontSeeElement('a.active');
                            });
                    });

                $this->seeElement('div.tab-content')
                    ->within('.tab-content', function () {
                        $this->seeElementCount('div.tab-pane', 3);

                        // first tab
                        $this->seeElement('div.tab-pane#first-tab[role="tabpanel"]')
                            ->dontSeeElement('#first-tab.active')
                            ->seeInElement('#first-tab', 'First Tab Content');

                        // active tab
                        $this->seeElement('div.tab-pane.active.show#active-tab[role="tabpanel"]')
                            ->seeInElement('#active-tab', 'Active Tab Content');

                        // disabled tab
                        $this->seeElement('div.tab-pane#disabled-tab[role="tabpanel"]')
                            ->dontSeeElement('#disabled.active')
                            ->seeInElement('#disabled-tab', 'Disabled Tab Content');

                        // external tab
                        $this->dontSeeElement('div.tab-pane#external-tab');
                    });
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_5_tabs()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('tabs');

        $this->visit('/tabs')
            ->seeElement('div.tab-container')
            ->within('.tab-container', function () {
                $this->seeElement('ul.nav.nav-tabs[role="tablist"]')
                    ->within('ul.nav.nav-tabs', function () {
                        // first tab
                        $this->seeElement('li.nav-item[role="presentation"]:nth-child(1)')
                            ->within('li.nav-item:nth-child(1)', function () {
                                $this->seeElement('button.nav-link[id="first-tab-tab"][data-bs-toggle="tab"][role="tab"][aria-controls="first-tab"][aria-selected="false"]')
                                    ->seeInElement('button.nav-link', 'First Tab Title')
                                    ->dontSeeElement('button.active');
                            });

                        // active tab
                        $this->seeElement('li.nav-item[role="presentation"]:nth-child(2)')
                            ->within('li.nav-item:nth-child(2)', function () {
                                $this->seeElement('button.nav-link.active[id="active-tab-tab"][data-bs-toggle="tab"][role="tab"][aria-controls="active-tab"][aria-selected="true"]')
                                    ->seeInElement('button.nav-link', 'Active Tab');
                            });

                        // disabled tab
                        $this->seeElement('li.nav-item[role="presentation"]:nth-child(3)')
                            ->within('li.nav-item:nth-child(3)', function () {
                                $this->seeElement('button.nav-link[disabled][id="disabled-tab-tab"][data-bs-toggle="tab"][role="tab"][aria-controls="disabled-tab"][aria-selected="false"]')
                                    ->seeInElement('button.nav-link', 'Disabled Tab')
                                    ->dontSeeElement('button.active');
                            });

                        // external tab
                        $this->seeElement('li.nav-item[role="presentation"]:nth-child(4)')
                            ->within('li.nav-item:nth-child(4)', function () {
                                $this->seeElement('a.nav-link[href="http://example.com"]')
                                    ->seeInElement('a.nav-link', 'External Tab')
                                    ->dontSeeElement('a.active');
                            });
                    });

                $this->seeElement('div.tab-content')
                    ->within('.tab-content', function () {
                        $this->seeElementCount('div.tab-pane', 3);

                        // first tab
                        $this->seeElement('div.tab-pane#first-tab[role="tabpanel"][aria-labelledby="first-tab-tab"][tabindex="0"]')
                            ->dontSeeElement('#first-tab.active')
                            ->seeInElement('#first-tab', 'First Tab Content');

                        // active tab
                        $this->seeElement('div.tab-pane.active.show#active-tab[role="tabpanel"][aria-labelledby="active-tab-tab"][tabindex="0"]')
                            ->seeInElement('#active-tab', 'Active Tab Content');

                        // disabled tab
                        $this->seeElement('div.tab-pane#disabled-tab[role="tabpanel"][aria-labelledby="disabled-tab-tab"][tabindex="0"]')
                            ->dontSeeElement('#disabled.active')
                            ->seeInElement('#disabled-tab', 'Disabled Tab Content');

                        // external tab
                        $this->dontSeeElement('div.tab-pane#external-tab');
                    });
            });

    }
}
