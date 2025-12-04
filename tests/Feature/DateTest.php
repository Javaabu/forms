<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('forms.inputs.required_text', 'forms::strings.required_text');
        Config::set('forms.inputs.inline', false);
    }

    #[Test]
    public function it_can_generate_bootstrap_5_date_inputs()
    {
        $this->setFrameworkBootstrap5();
        $this->registerTestRoute('date-inputs');

        $this->visit('/date-inputs')
            ->seeElement('input#published_at.date-picker')
            ->seeElement('input#expire_at.datetime-picker')
            ->seeElement('input#opening_time.time-picker');
    }
}
