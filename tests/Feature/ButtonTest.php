<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ButtonTest extends TestCase
{
    #[Test]
    public function it_can_generate_bootstrap_6_button_group()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('button-group');

        $this->visit('/button-group')
            ->seeElement('div.btn-group')
            ->within('div.btn-group', function () {
                $this->seeElement('button.btn-solid.theme-primary');
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_6_button()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('button');

        $this->visit('/button')
            ->seeElement('button[type="button"].btn-solid.theme-danger')
            ->seeInElement('button[type="button"].btn-solid.theme-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_bootstrap_6_submit_button()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('button-submit');

        $this->visit('/button-submit')
            ->seeElement('button[type="submit"].btn-solid.theme-danger')
            ->seeInElement('button[type="submit"].btn-solid.theme-danger', 'Button');
    }

    #[Test]
    public function it_can_generate_bootstrap_6_link_button()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('button-link');

        $this->visit('/button-link')
            ->seeElement('a[href="/test"].btn-solid.theme-danger')
            ->seeInElement('a[href="/test"].btn-solid.theme-danger', 'Button');
    }
}
