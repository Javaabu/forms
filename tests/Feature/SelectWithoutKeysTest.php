<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Http\Request;
use Javaabu\Forms\Tests\TestCase;

class SelectWithoutKeysTest extends TestCase
{
    public function test_it_makes_the_values_numeric()
    {
        $this->registerTestRoute('select-without-keys', function (Request $request) {
            $request->validate([
                'select' => 'required|in:a,b',
            ]);
        });

        $this->visit('/select-without-keys')
            ->seeInElement('option[value="0"]', 'a')
            ->seeInElement('option[value="1"]', 'b')
            ->seeInElement('option[value="2"]', 'c');
    }

    public function test_it_shows_a_validation_error()
    {
        $this->registerTestRoute('select-without-keys', function (Request $request) {
            $request->validate([
                'select' => 'required|in:0,1',
            ]);
        });

        $this->visit('/select-without-keys')
            ->select('2', 'select')
            ->press('Submit')
            ->seeElement('option[value="0"]:not(:selected)')
            ->seeElement('option[value="1"]:not(:selected)')
            ->seeElement('option[value="2"]:selected');
    }
}
