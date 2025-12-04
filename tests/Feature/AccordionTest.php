<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AccordionTest extends TestCase
{
    #[Test]
    public function it_can_generate_bootstrap_5_accordion_header()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('accordion-header');

        $this->visit('/accordion-header')
            ->seeElement('h2.accordion-header#item-1')
            ->within('.accordion-header#item-1', function () {
                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
                    ->seeInElement('.accordion-button', 'Accordion Item #1');
            })
            ->seeElement('h2.accordion-header#item-2')
            ->within('.accordion-header#item-2', function () {
                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
                    ->seeInElement('.accordion-button', 'Accordion Item #2');
            });

    }

    #[Test]
    public function it_can_generate_material_admin_26_accordion_header()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('accordion-header');

        $this->visit('/accordion-header')
            ->seeElement('div.accordion__title#item-1[data-toggle="collapse"][data-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
            ->seeInElement('.accordion__title#item-1', 'Accordion Item #1')
            ->seeElement('div.accordion__title#item-2[data-toggle="collapse"][data-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
            ->seeInElement('.accordion__title#item-2', 'Accordion Item #2');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_accordion_collapse()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('accordion-collapse');

        $this->visit('/accordion-collapse')
            ->seeElement('div.accordion-collapse#item-1.collapse.show[data-bs-parent="#accordionExample"]')
            ->seeInElement('.accordion-collapse#item-1', 'Accordion Item #1')

            ->seeElement('div.accordion-collapse#item-2.collapse[data-bs-parent="#accordionExample"]')
            ->within('.accordion-collapse#item-2', function () {
                $this->seeElement('strong')
                    ->seeInElement('strong', 'Accordion Item #2');
            });

    }

    #[Test]
    public function it_can_generate_material_admin_26_accordion_collapse()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('accordion-collapse');

        $this->visit('/accordion-collapse')
            ->seeElement('div.collapse#item-1.collapse.show[data-parent="#accordionExample"]')
            ->seeInElement('.collapse#item-1', 'Accordion Item #1')

            ->seeElement('div.collapse#item-2.collapse[data-parent="#accordionExample"]')
            ->within('.collapse#item-2', function () {
                $this->seeElement('strong')
                    ->seeInElement('strong', 'Accordion Item #2');
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_5_accordion_item()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('accordion-item');

        $this->visit('/accordion-item')
            ->seeElement('div.accordion-item#item-1')
            ->within('.accordion-item#item-1', function () {
                $this->seeElement('h2.accordion-header')
                    ->within('.accordion-header', function () {
                        $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
                            ->seeInElement('.accordion-button', 'Accordion Item #1');
                    });

                $this->seeElement('div.accordion-collapse#collapseOne.collapse.show[data-bs-parent="#accordionExample"]')
                    ->seeInElement('.accordion-collapse#collapseOne', 'First item Body');
            })

            ->seeElement('div.accordion-item#item-2')
            ->within('.accordion-item#item-2', function () {
                $this->seeElement('h2.accordion-header')
                    ->within('.accordion-header', function () {
                        $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
                            ->seeInElement('.accordion-button', 'Accordion Item #2');
                    });

                $this->seeElement('div.accordion-collapse#collapseTwo.collapse[data-bs-parent="#accordionExample"]')
                    ->seeInElement('.accordion-collapse#collapseTwo', 'Second item Body');
            });

    }

    #[Test]
    public function it_can_generate_material_admin_26_accordion_item()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('accordion-item');

        $this->visit('/accordion-item')
            ->seeElement('div.accordion__item#item-1')
            ->within('.accordion__item#item-1', function () {
                $this->seeElement('div.accordion__title[data-toggle="collapse"][data-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
                    ->seeInElement('.accordion__title', 'Accordion Item #1');

                $this->seeInElement('div.collapse#collapseOne.collapse.show[data-parent="#accordionExample"]', 'First item Body');
            })

            ->seeElement('div.accordion__item#item-2')
            ->within('.accordion__item#item-2', function () {
                $this->seeElement('div.accordion__title[data-toggle="collapse"][data-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
                    ->seeInElement('.accordion__title', 'Accordion Item #2');

                $this->seeInElement('div.collapse#collapseTwo.collapse[data-parent="#accordionExample"]', 'Second item Body');
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_5_accordion_using_named_items()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('accordion');

        $this->visit('/accordion')
            ->seeElement('div.accordion#accordionExample')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('div.accordion-item#item-1')
                    ->within('.accordion-item#item-1', function () {
                        $this->seeElement('h2.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
                                    ->seeInElement('.accordion-button', 'Accordion Item #1');
                            });

                        $this->seeElement('div.accordion-collapse#collapseOne.collapse.show[data-bs-parent="#accordionExample"]')
                            ->seeInElement('.accordion-collapse#collapseOne', 'First item Body');
                    })

                    ->seeElement('div.accordion-item#item-2')
                    ->within('.accordion-item#item-2', function () {
                        $this->seeElement('h2.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
                                    ->seeInElement('.accordion-button', 'Accordion Item #2');
                            });

                        $this->seeElement('div.accordion-collapse#collapseTwo.collapse[data-bs-parent="#accordionExample"]')
                            ->seeInElement('.accordion-collapse#collapseTwo', 'Second item Body');
                    });
            });

    }

    #[Test]
    public function it_can_generate_material_admin_accordion_using_named_items()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('accordion');

        $this->visit('/accordion')
            ->seeElement('div.accordion#accordionExample[role="tablist"]')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('div.accordion__item#item-1')
                    ->within('.accordion__item#item-1', function () {
                        $this->seeElement('div.accordion__title[data-toggle="collapse"][data-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
                            ->seeInElement('.accordion__title', 'Accordion Item #1');

                        $this->seeInElement('div.collapse#collapseOne.collapse.show[data-parent="#accordionExample"]', 'First item Body');
                    })

                    ->seeElement('div.accordion__item#item-2')
                    ->within('.accordion__item#item-2', function () {
                        $this->seeElement('div.accordion__title[data-toggle="collapse"][data-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
                            ->seeInElement('.accordion__title', 'Accordion Item #2');

                        $this->seeInElement('div.collapse#collapseTwo.collapse[data-parent="#accordionExample"]', 'Second item Body');
                    });
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_5_accordion_using_unnamed_items()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('accordion-unnamed');

        $this->visit('/accordion-unnamed')
            ->seeElement('div.accordion#accordionExample')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('div.accordion-item#item-1')
                    ->within('.accordion-item#item-1', function () {
                        $this->seeElement('h2.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#accordionExample-item-0-collapse"][aria-expanded="true"][aria-controls="accordionExample-item-0-collapse"]')
                                    ->seeInElement('.accordion-button', 'Accordion Item #1');
                            });

                        $this->seeElement('div.accordion-collapse#accordionExample-item-0-collapse.collapse.show[data-bs-parent="#accordionExample"]')
                            ->seeInElement('.accordion-collapse#accordionExample-item-0-collapse', 'First item Body');
                    })

                    ->seeElement('div.accordion-item#item-2')
                    ->within('.accordion-item#item-2', function () {
                        $this->seeElement('h2.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#accordionExample-item-1-collapse"][aria-expanded="false"][aria-controls="accordionExample-item-1-collapse"]')
                                    ->seeInElement('.accordion-button', 'Accordion Item #2');
                            });

                        $this->seeElement('div.accordion-collapse#accordionExample-item-1-collapse.collapse[data-bs-parent="#accordionExample"]')
                            ->seeInElement('.accordion-collapse#accordionExample-item-1-collapse', 'Second item Body');
                    });
            });

    }

    #[Test]
    public function it_can_generate_bootstrap_5_accordion_using_slot()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('accordion-slot');

        $this->visit('/accordion-slot')
            ->seeElement('div.accordion#accordionExample')
            ->within('.accordion#accordionExample', function () {
                $this->seeElement('div.accordion-item#item-1')
                    ->within('.accordion-item#item-1', function () {
                        $this->seeElement('h2.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseOne"][aria-expanded="true"][aria-controls="collapseOne"]')
                                    ->seeInElement('.accordion-button', 'Accordion Item #1');
                            });

                        $this->seeElement('div.accordion-collapse#collapseOne.collapse.show[data-bs-parent="#accordionExample"]')
                            ->seeInElement('.accordion-collapse#collapseOne', 'First item Body');
                    })

                    ->seeElement('div.accordion-item#item-2')
                    ->within('.accordion-item#item-2', function () {
                        $this->seeElement('h2.accordion-header')
                            ->within('.accordion-header', function () {
                                $this->seeElement('button.accordion-button[data-bs-toggle="collapse"][data-bs-target="#collapseTwo"][aria-expanded="false"][aria-controls="collapseTwo"]')
                                    ->seeInElement('.accordion-button', 'Accordion Item #2');
                            });

                        $this->seeElement('div.accordion-collapse#collapseTwo.collapse[data-bs-parent="#accordionExample"]')
                            ->seeInElement('.accordion-collapse#collapseTwo', 'Second item Body');
                    });
            });

    }
}
