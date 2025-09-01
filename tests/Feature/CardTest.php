<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CardTest extends TestCase
{
    #[Test]
    public function it_can_generate_bootstrap_5_card_title()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card-title');

        $this->visit('/form-card-title')
            ->seeElement('h5.card-title')
            ->seeInElement('h5.card-title', 'Card title');
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_title()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card-title');

        $this->visit('/form-card-title')
            ->seeElement('h4.card-title')
            ->seeInElement('h4.card-title', 'Card title');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_subtitle()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card-subtitle');

        $this->visit('/form-card-subtitle')
            ->seeElement('h6.card-subtitle')
            ->seeInElement('h6.card-subtitle', 'Card subtitle');
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_subtitle()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card-subtitle');

        $this->visit('/form-card-subtitle')
            ->seeElement('h6.card-subtitle')
            ->seeInElement('h6.card-subtitle', 'Card subtitle');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_header()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card-header');

        $this->visit('/form-card-header')
            ->seeElement('div.card-header')
            ->seeInElement('div.card-header', 'Card header');
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_header()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card-header');

        $this->visit('/form-card-header')
            ->seeElement('div.card-header')
            ->seeInElement('div.card-header', 'Card header');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_footer()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card-footer');

        $this->visit('/form-card-footer')
            ->seeElement('div.card-footer')
            ->seeInElement('div.card-footer', 'Card footer');
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_footer()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card-footer');

        $this->visit('/form-card-footer')
            ->seeElement('div.card-footer')
            ->seeInElement('div.card-footer', 'Card footer');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#normal')
            ->within('div#normal', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('div.card-body')
                            ->within('div.card-body', function () {
                                $this->seeElement('h5.card-title')
                                    ->seeInElement('h5.card-title', 'Card Title')
                                    ->see('This is a card');
                            });
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_with_header()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#header')
            ->within('div#header', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('div.card-header.text-primary')
                            ->seeInElement('div.card-header.text-primary', 'This is in the header');
                    });
            });
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_with_header()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#header')
            ->within('div#header', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('div.card-header.text-primary')
                            ->seeInElement('div.card-header.text-primary', 'This is in the header');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_with_subtitle()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#subtitle')
            ->within('div#subtitle', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('h6.card-subtitle')
                            ->seeInElement('h6.card-subtitle', 'Card Subtitle');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_with_image_top()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#image-top')
            ->within('div#image-top', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('img.card-img-top');
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_card_with_footer()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#footer')
            ->within('div#footer', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('div.card-footer');
                    });
            });
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_with_footer()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#footer')
            ->within('div#footer', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('div.card-footer');
                    });
            });
    }

    // write test for material admin

    #[Test]
    public function it_can_generate_material_admin_26_card()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#normal')
            ->within('div#normal', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('div.card-body')
                            ->within('div.card-body', function () {
                                $this->seeElement('h4.card-title')
                                    ->seeInElement('h4.card-title', 'Card Title')
                                    ->see('This is a card');
                            });
                    });
            });
    }



    #[Test]
    public function it_can_generate_material_admin_26_card_with_subtitle()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#subtitle')
            ->within('div#subtitle', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('h6.card-subtitle')
                            ->seeInElement('h6.card-subtitle', 'Card Subtitle');
                    });
            });
    }

    #[Test]
    public function it_can_generate_material_admin_26_card_with_image_top()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('form-card');

        $this->visit('/form-card')
            ->seeElement('div#image-top')
            ->within('div#image-top', function () {
                $this
                    ->seeElement('div.card')
                    ->within('div.card', function () {
                        $this->seeElement('img.card-img-top');
                    });
            });
    }


}
