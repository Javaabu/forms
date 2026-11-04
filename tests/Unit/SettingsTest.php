<?php

namespace Javaabu\Forms\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Support\Settings;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SettingsTest extends TestCase
{
    #[Test]
    public function it_reads_defaults_from_the_forms_config_first(): void
    {
        Config::set('forms.defaults.per_page', 35);

        $this->assertEquals(35, Settings::get('per_page', 20));
    }

    #[Test]
    public function it_falls_back_to_the_given_default_when_nothing_is_set(): void
    {
        $this->assertEquals('fallback', Settings::get('a_setting_that_does_not_exist', 'fallback'));
    }
}
