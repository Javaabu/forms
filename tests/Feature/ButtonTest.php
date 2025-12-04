<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ButtonTest extends TestCase
{
    #[Test]
    public function it_can_generate_bootstrap_5_button_group()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('button-group');

        $this->visit('/button-group')
            ->seeElement('div.btn-group')
            ->within('div.btn-group', function () {
                $this->seeElement('button.btn');
            });
    }

    #[Test]
    public function it_can_generate_material_admin_26_group()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('button-group');

        $this->visit('/button-group')
            ->seeElement('div.button-group.inline-btn-group')
            ->within('div.button-group', function () {
                $this->seeElement('button.btn');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_button()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('button');

        $this->visit('/button')
            ->seeElement('button[type="button"].btn.btn-danger')
            ->seeInElement('button[type="button"].btn.btn-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_material_admin_26_button()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('button');

        $this->visit('/button')
            ->seeElement('button[type="button"].btn.btn-danger')
            ->seeInElement('button[type="button"].btn.btn-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_submit_button()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('button-submit');

        $this->visit('/button-submit')
            ->seeElement('button[type="submit"].btn.btn-danger')
            ->seeInElement('button[type="submit"].btn.btn-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_material_admin_26_submit_button()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('button-submit');

        $this->visit('/button-submit')
            ->seeElement('button[type="submit"].btn.btn-danger')
            ->seeInElement('button[type="submit"].btn.btn-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_bootstrap_5_link_button()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('button-link');

        $this->visit('/button-link')
            ->seeElement('a[href="/test"].btn.btn-danger')
            ->seeInElement('a[href="/test"].btn.btn-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_material_admin_26_link_button()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('button-link');

        $this->visit('/button-link')
            ->seeElement('a[href="/test"].btn.btn-danger')
            ->seeInElement('a[href="/test"].btn.btn-danger', 'Button');
    }

}
