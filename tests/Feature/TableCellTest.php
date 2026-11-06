<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TableCellTest extends TestCase
{
    #[Test]
    public function it_can_render_enum_table_cell_entries_for_bootstrap_6()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-enum');

        $this->visit('/table-cell-enum')
            ->seeElement('td')
            ->within('td', function () {
                $this->seeText('Report Article');
            });

    }

    #[Test]
    public function it_can_render_status_table_cell_entries_for_bootstrap_6()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-status');

        $this->visit('/table-cell-status')
            ->seeElement('td')
            ->within('td', function () {
                $this->seeElement('span.status.badge.theme-success')
                    ->within('span.status', function () {
                        $this->seeText('Published');
                    });
            });

    }

    #[Test]
    public function it_can_render_boolean_table_cells()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-boolean');

        $this->visit('/table-cell-boolean')
            ->seeElement('td')
            ->seeInElement('td', 'Yes');
    }

    #[Test]
    public function it_can_render_array_text_table_cells()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-array');

        $this->visit('/table-cell-array')
            ->seeElement('td')
            ->seeInElement('td', 'orange');
    }

    #[Test]
    public function it_can_render_multiline_text_table_cells()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-multiline');

        $this->visit('/table-cell-multiline')
            ->seeElement('td')
            ->seeInElement('td', "Javaabu<br>\nCompany");
    }

    #[Test]
    public function it_can_set_the_table_cell_from_model()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-model');

        $this->visit('/table-cell-model')
            ->seeElement('tr')
            ->within('tr', function () {
                $this->seeElement('td')
                    ->seeInElement('td', 'Javaabu');
            });
    }

    #[Test]
    public function it_can_set_the_table_cell_from_value()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell-value');

        $this->visit('/table-cell-value')
            ->seeElement('td')
            ->seeInElement('td', 'Javaabu');
    }

    #[Test]
    public function it_can_generate_bootstrap_6_table_cell()
    {
        $this->setFrameworkBootstrap6();
        $this->registerTestRoute('table-cell');

        $this->visit('/table-cell')
            ->seeElement('td')
            ->seeInElement('td', 'Javaabu');
    }
}
