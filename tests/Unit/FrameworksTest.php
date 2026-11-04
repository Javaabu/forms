<?php

namespace Javaabu\Forms\Tests\Unit;

use InvalidArgumentException;
use Javaabu\Forms\Frameworks\Bootstrap6;
use Javaabu\Forms\Frameworks\Frameworks;
use Javaabu\Forms\Frameworks\Onu;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FrameworksTest extends TestCase
{
    #[Test]
    public function it_resolves_the_bundled_frameworks(): void
    {
        $this->assertInstanceOf(Onu::class, Frameworks::get('onu'));
        $this->assertInstanceOf(Bootstrap6::class, Frameworks::get('bootstrap-6'));
        $this->assertEquals(['onu', 'bootstrap-6'], Frameworks::names());
    }

    #[Test]
    public function it_throws_for_an_unknown_framework(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Frameworks::get('bootstrap-5');
    }

    #[Test]
    public function it_can_register_a_custom_framework(): void
    {
        Frameworks::register('my-theme', Bootstrap6::class);

        $this->assertInstanceOf(Bootstrap6::class, Frameworks::get('my-theme'));
    }

    #[Test]
    public function it_maps_bootstrap_colours_to_bootstrap_6_classes(): void
    {
        $framework = new Bootstrap6;

        $this->assertEquals('btn-solid theme-danger btn-sm', $framework->button('danger', 'sm'));
        $this->assertEquals('btn-outline theme-primary', $framework->button('outline-primary'));
        $this->assertEquals('badge theme-success', $framework->badge('success'));
        $this->assertEquals('alert theme-warning', $framework->alert('warning'));
    }

    #[Test]
    public function it_defaults_to_the_onu_framework(): void
    {
        $config = require __DIR__ . '/../../config/config.php';

        $this->assertEquals('onu', $config['framework']);
    }
}
