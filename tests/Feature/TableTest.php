<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Javaabu\Forms\Tests\TestSupport\Models\Activity;

class TableTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_generate_bootstrap_5_table()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('table');

        $this->visit('table')
            ->seeElement('#normal')
            ->within('#normal', function () {
                $this->seeElement('table.table')
                    ->within('table.table', function () {
                        $this->seeElement('thead')
                            ->within('thead', function () {
                                $this->seeElement('tr')
                                    ->within('tr', function () {
                                        $this->seeElement('td')
                                            ->seeInElement('td', 'No')
                                            ->seeInElement('td', 'First Name')
                                            ->seeInElement('td', 'Last Name')
                                            ->seeInElement('td', 'Username');
                                    });
                            });

                        $this->seeElement('tbody')
                            ->within('tbody', function () {
                                $this->seeElement('tr')
                                    ->within('tr', function () {
                                        $this
                                            ->seeInElement('td', '1')
                                            ->seeInElement('td', 'Mark')
                                            ->seeInElement('td', 'Otto')
                                            ->seeInElement('td', '@mdo');
                                    });
                            });
                    });
            });
    }

    #[Test]
    public function it_can_generate_bootstrap_5_striped_table()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('table');

        $this->visit('table')
            ->seeElement('#striped')
            ->within('#striped', function () {
                $this->seeElement('table.table-striped');
            });
    }

    #[Test]
    public function it_can_generate_material_26_table()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('table');

        $this->visit('table')
            ->seeElement('#material')
            ->within('#material', function () {
                $this->seeElement('div.table-responsive')
                    ->within('div.table-responsive', function () {
                        $this->seeElement('thead')
                            ->within('thead', function () {
                                $this->seeElement('tr')
                                    ->within('tr', function () {
                                        $this->seeElement('th')
                                            ->seeInElement('th', 'No')
                                            ->seeInElement('th', 'Date A')
                                            ->seeInElement('th', 'Date B')
                                            ->seeInElement('th', 'Date C')
                                            ->seeInElement('th', 'Date D')
                                            ->seeInElement('th', 'Date E');
                                    });
                            });

                        $this->seeElement('tbody')
                            ->within('tbody', function () {
                                $activities = Activity::query()->take(2)->get();
                                foreach ($activities as $activity) {
                                    $this->seeElement('tr')
                                        ->within('tr', function () use ($activity) {
                                            $this
                                                ->seeElement('.td-checkbox')
                                                ->seeElement('input[type="checkbox"][id="activities-'. $activity->id . '-row-check"]')
                                                ->seeInElement('td', $activity->id)
                                                ->seeInElement('td', $activity->date_a)
                                                ->seeInElement('td', $activity->date_b)
                                                ->seeInElement('td', $activity->date_c)
                                                ->seeInElement('td', $activity->date_d)
                                                ->seeInElement('td', $activity->date_e);
                                        });
                                }
                            });

                    });

                // Pagination check
                $this->seeElement('div.dataTables_info');
                //$this->seeInElement('div.dataTables_info', 'Showing 2 from total 20 entries');
                $this->seeInElement('div', 'Previous');
            });
    }

    #[Test]
    public function it_displays_empty_table_message_when_no_matching_rows()
    {
        $this->setFrameworkMaterialAdmin26();
        $this->registerTestRoute('table');

        $this->visit('table')
            ->seeElement('#material-empty')
            ->within('#material-empty', function () {
                $this->see('No matching things');
            });
    }
}
