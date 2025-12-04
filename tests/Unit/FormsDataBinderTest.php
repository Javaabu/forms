<?php

namespace Javaabu\Forms\Tests\Unit;

use Javaabu\Forms\FormsDataBinder;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FormsDataBinderTest extends TestCase
{
    #[Test]
    public function it_can_bind_targets()
    {
        $binder = new FormsDataBinder();
        $this->assertNull($binder->get());

        $binder->bind($array = ['foo' => 'bar']);
        $this->assertEquals($array, $binder->get());
    }

    #[Test]
    public function it_can_bind_multiple_targets()
    {
        $binder = new FormsDataBinder();

        $binder->bind($targetA = ['foo' => 'bar']);
        $binder->bind($targetB = ['bar' => 'foo']);

        $this->assertEquals($targetB, $binder->get());
        $binder->pop();

        $this->assertEquals($targetA, $binder->get());
        $binder->pop();

        $this->assertNull($binder->get());
    }
}
