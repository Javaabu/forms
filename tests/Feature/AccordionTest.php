<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AccordionTest extends TestCase
{
    #[Test]
    public function it_can_generate_bootstrap_6_accordion_header()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('accordion-header');

        $this->visit('/accordion-header')
            ->seeElement('summary.accordion-header#item-1')
            ->within('.accordion-header#item-1', function () {
                $this->seeElement('svg.accordion-icon')
                    ->see('Accordion Item #1');
            })
            ->seeElement('summary.accordion-header#item-2')
            ->within('.accordion-header#item-2', function () {
                $this->seeElement('svg.accordion-icon')
                    ->see('Accordion Item #2');
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_6_accordion_collapse()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('accordion-collapse');

        $this->visit('/accordion-collapse')
            ->seeElement('div.accordion-body#item-1[data-accordion="accordionExample"]')
            ->seeInElement('.accordion-body#item-1', 'Accordion Item #1')

            ->seeElement('div.accordion-body#item-2[data-accordion="accordionExample"]')
            ->within('.accordion-body#item-2', function () {
                $this->seeElement('strong')
                    ->seeInElement('strong', 'Accordion Item #2');
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_6_accordion_item()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('accordion-item');

        $this->visit('/accordion-item')
            ->seeElement('details.accordion-item#item-1[open][name="accordionExample"]')
            ->seeElement('details.accordion-item#item-2[name="accordionExample"]')
            ->dontSeeElement('details.accordion-item#item-2[open]')
            ->seeElement('summary.accordion-header[aria-controls="collapseOne"]')
            ->seeElement('details.accordion-item#item-1')
            ->within('.accordion-item#item-1', function () {
                $this->seeElement('summary.accordion-header')
                    ->within('.accordion-header', function () {
                        $this->seeElement('svg.accordion-icon')
                            ->see('Accordion Item #1');
                    });

                $this->seeElement('div.accordion-body#collapseOne[data-accordion="accordionExample"]')
                    ->seeInElement('.accordion-body#collapseOne', 'First item Body');
            })

            ->seeElement('details.accordion-item#item-2')
            ->within('.accordion-item#item-2', function () {
                $this->seeElement('summary.accordion-header')
                    ->within('.accordion-header', function () {
                        $this->seeElement('svg.accordion-icon')
                            ->see('Accordion Item #2');
                    });

                $this->seeElement('div.accordion-body#collapseTwo[data-accordion="accordionExample"]')
                    ->seeInElement('.accordion-body#collapseTwo', 'Second item Body');
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_6_accordion_using_named_items()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('accordion');

        $this->visit('/accordion')
            ->seeElement('div.accordion#accordionExample')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('details.accordion-item#item-1')
                    ->within('.accordion-item#item-1', function () {
                        $this->seeElement('summary.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('svg.accordion-icon')
                                    ->see('Accordion Item #1');
                            });

                        $this->seeElement('div.accordion-body#collapseOne[data-accordion="accordionExample"]')
                            ->seeInElement('.accordion-body#collapseOne', 'First item Body');
                    })

                    ->seeElement('details.accordion-item#item-2')
                    ->within('.accordion-item#item-2', function () {
                        $this->seeElement('summary.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('svg.accordion-icon')
                                    ->see('Accordion Item #2');
                            });

                        $this->seeElement('div.accordion-body#collapseTwo[data-accordion="accordionExample"]')
                            ->seeInElement('.accordion-body#collapseTwo', 'Second item Body');
                    });
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_6_accordion_using_unnamed_items()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('accordion-unnamed');

        $this->visit('/accordion-unnamed')
            ->seeElement('div.accordion#accordionExample')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('details.accordion-item#item-1')
                    ->within('.accordion-item#item-1', function () {
                        $this->seeElement('summary.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('svg.accordion-icon')
                                    ->see('Accordion Item #1');
                            });

                        $this->seeElement('div.accordion-body#accordionExample-item-0-collapse[data-accordion="accordionExample"]')
                            ->seeInElement('.accordion-body#accordionExample-item-0-collapse', 'First item Body');
                    })

                    ->seeElement('details.accordion-item#item-2')
                    ->within('.accordion-item#item-2', function () {
                        $this->seeElement('summary.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('svg.accordion-icon')
                                    ->see('Accordion Item #2');
                            });

                        $this->seeElement('div.accordion-body#accordionExample-item-1-collapse[data-accordion="accordionExample"]')
                            ->seeInElement('.accordion-body#accordionExample-item-1-collapse', 'Second item Body');
                    });
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_6_accordion_using_slot()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('accordion-slot');

        $this->visit('/accordion-slot')
            ->seeElement('div.accordion#accordionExample')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('details.accordion-item#item-1')
                    ->within('.accordion-item#item-1', function () {
                        $this->seeElement('summary.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('svg.accordion-icon')
                                    ->see('Accordion Item #1');
                            });

                        $this->seeElement('div.accordion-body#collapseOne[data-accordion="accordionExample"]')
                            ->seeInElement('.accordion-body#collapseOne', 'First item Body');
                    })

                    ->seeElement('details.accordion-item#item-2')
                    ->within('.accordion-item#item-2', function () {
                        $this->seeElement('summary.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('svg.accordion-icon')
                                    ->see('Accordion Item #2');
                            });

                        $this->seeElement('div.accordion-body#collapseTwo[data-accordion="accordionExample"]')
                            ->seeInElement('.accordion-body#collapseTwo', 'Second item Body');
                    });
            });

    }
}
