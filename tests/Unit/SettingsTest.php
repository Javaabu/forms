<?php

namespace Javaabu\Forms\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Support\Settings;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Forms\Tests\TestSupport\FakeSettings;
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

    #[Test]
    public function it_reads_javaabu_settings_when_the_config_has_no_value(): void
    {
        FakeSettings::$values = ['per_page' => 50, 'default_lat' => 4.17];

        $this->assertEquals(50, Settings::get('per_page', 20));
        $this->assertEquals(4.17, Settings::get('default_lat'));

        Config::set('forms.defaults.per_page', 35);

        $this->assertEquals(35, Settings::get('per_page', 20));
    }

    #[Test]
    public function per_page_selects_the_per_page_setting(): void
    {
        FakeSettings::$values = ['per_page' => 50];

        $html = $this->renderBlade('<x-forms::per-page />');

        $this->assertEquals('50', $html->filter('select[name="per_page"] option[selected]')->attr('value'));
    }
}
