<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TextEntryTest extends TestCase
{
    #[Test]
    public function it_can_render_status_entries_for_bootstrap_5()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry-status');

        $this->visit('/text-entry-status')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Status')
                    ->seeElement('dd')
                    ->within('dd', function () {
                        $this->seeElement('span.status.text-bg-success')
                            ->within('span.status', function () {
                                $this->seeText('Published');
                            });
                    });
            });

    }

    #[Test]
    public function it_can_render_status_entries_for_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('text-entry-status');

        $this->visit('/text-entry-status')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Status')
                    ->seeElement('dd')
                    ->within('dd', function () {
                        $this->seeElement('span.status.bg-success')
                            ->within('span.status', function () {
                                $this->seeText('Published');
                            });
                    });
            });

    }

    #[Test]
    public function it_can_render_array_entries()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry-array');

        $this->visit('/text-entry-array')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Name')
                    ->seeElement('dd')
                    ->seeInElement('dd>ul>li', 'orange');
            });
    }

    #[Test]
    public function it_can_render_boolean_entries()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('boolean-entry');

        $this->visit('/boolean-entry')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Is Open')
                    ->seeElement('dd')
                    ->seeInElement('dd', 'Yes');
            });
    }

    #[Test]
    public function it_can_render_multiline_text_entries()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry-multiline');

        $this->visit('/text-entry-multiline')
            ->seeElement('dl')
            ->within('dl', function () {
                $this->seeElement('dt')
                    ->seeInElement('dt', 'Name')
                    ->seeElement('dd')
                    ->seeInElement('dd', "Javaabu<br>\nCompany");
            });
    }

    #[Test]
    public function it_can_set_the_text_entry_from_model()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('text-entry-model');

        $this->visit('/text-entry-model')
            ->seeElement('.card')
            ->within('.card', function () {
                $this->seeElement('dl')
                    ->within('dl', function () {
                        $this->seeElement('dt')
                            ->seeInElement('dt', 'Name')
                            ->seeElement('dd')
                            ->seeInElement('dd', 'Javaabu');
                    });
            });
    }

    #[Test]
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

    #[Test]
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

    #[Test]
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
