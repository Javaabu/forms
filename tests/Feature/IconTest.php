<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class IconTest extends TestCase
{
    #[Test]
    public function it_renders_bundled_icons_as_inline_svg(): void
    {
        $html = $this->renderBlade('<x-forms::icon name="calendar" class="size-4" />');

        $svg = $html->filter('svg.forms-icon.size-4[data-icon="calendar"][aria-hidden="true"]');

        $this->assertCount(1, $svg);
        $this->assertGreaterThan(0, $svg->filter('path')->count());
    }

    #[Test]
    public function it_resolves_logical_icon_names_from_the_config(): void
    {
        $html = $this->renderBlade('<x-forms::icon name="date" />');

        $this->assertCount(1, $html->filter('svg[data-icon="calendar"]'));
    }

    #[Test]
    public function it_renders_icon_font_classes_as_an_i_element(): void
    {
        Config::set('forms.icons.date', 'fa-regular fa-calendar');

        $html = $this->renderBlade('<x-forms::icon name="date" /><x-forms::icon name="zmdi zmdi-home" />');

        $this->assertCount(1, $html->filter('i.fa-regular.fa-calendar[aria-hidden="true"]'));
        $this->assertCount(1, $html->filter('i.zmdi.zmdi-home'));
        $this->assertCount(0, $html->filter('svg'));
    }

    #[Test]
    public function it_lets_a_framework_override_an_icon(): void
    {
        Config::set('forms.frameworks.bootstrap-6.icons.clear', 'circle-x');

        $html = $this->renderBlade('<x-forms::icon name="clear" framework="bootstrap-6" />');

        $this->assertCount(1, $html->filter('svg[data-icon="circle-x"]'));
    }

    #[Test]
    public function it_uses_svg_icons_in_date_inputs(): void
    {
        $this->setFrameworkBootstrap6();

        $html = $this->renderBlade('<x-forms::date name="published_at" />');

        $this->assertCount(1, $html->filter('.input-group-text svg[data-icon="calendar"]'));
        $this->assertCount(1, $html->filter('button.btn-date-clear[data-date-clear="#published_at"] svg[data-icon="x"]'));
    }
}
