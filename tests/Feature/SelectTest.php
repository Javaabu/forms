<?php

namespace Javaabu\Forms\Tests\Feature;

use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SelectTest extends TestCase
{
    #[Test]
    public function it_shows_the_slot_if_the_options_are_empty()
    {
        $this->registerTestRoute('select-slot');

        $this->visit('/select-slot')
            ->seeElement('option[value="a"]')
            ->seeElement('option[value="b"]')
            ->seeElement('option[value="c"]');
    }

    #[Test]
    public function it_can_render_a_placeholder()
    {
        $this->registerTestRoute('select-placeholder');

        $this->visit('/select-placeholder')
            ->seeElement('option[value=""][selected="selected"]')
            ->seeElement('option[value="a"]')
            ->seeElement('option[value="b"]');
    }

    #[Test]
    public function it_adds_a_sync_field_for_multi_selects()
    {
        $this->registerTestRoute('select-multiple');

        $this->visit('/select-multiple')
            ->seeElement('select[name="sectors[]"]')
            ->seeElement('input[type="hidden"][name="sync_sectors"][value="1"]')
            ->seeElement('option[value="a"]')
            ->seeElement('option[value="b"]')
            ->seeElement('option[value="c"]');
    }
}
