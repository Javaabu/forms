<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;

class TextEntryTest extends TestCase
{
    /** @test */
    public function it_can_set_the_text_entry_from_model()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry-model');

        $this->visit('/text-entry-model')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Name')
                    ->seeElement('dd')
                    ->seeInElement('dd', 'Javaabu');
            });
    }

    /** @test */
    public function it_can_set_the_text_entry_from_value()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry-value');

        $this->visit('/text-entry-value')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Name')
                    ->seeElement('dd')
                    ->seeInElement('dd', 'Javaabu');
            });
    }

    /** @test */
    public function it_can_generate_bootstrap_5_text_entry()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry');

        $this->visit('/text-entry')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Name')
                    ->seeElement('dd')
                    ->seeInElement('dd', 'Javaabu');
            });
    }

    /** @test */
    public function it_can_generate_material_admin_26_text_entry()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('text-entry');

        $this->visit('/text-entry')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Name')
                    ->seeElement('dd')
                    ->seeInElement('dd', 'Javaabu');
            });
    }
}