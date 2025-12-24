<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use Javaabu\Forms\Tests\TestSupport\Models\Category;

class SelectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_slot_if_the_options_are_empty()
    {
        $this->registerTestRoute('select-slot');

        $this->visit('/select-slot')
            ->seeElement('option[value="a"]')
            ->seeElement('option[value="b"]')
            ->seeElement('option[value="c"]');
    }

    /** @test */
    public function it_can_render_a_placeholder()
    {
        $this->registerTestRoute('select-placeholder');

        $this->visit('/select-placeholder')
            ->seeElement('option[value=""][selected="selected"]')
            ->seeElement('option[value="a"]')
            ->seeElement('option[value="b"]');
    }

    /** @test */
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

    /** @test */
    public function it_can_exclude_the_sync_field_for_multi_selects()
    {
        $this->registerTestRoute('select-sync-field');

        $this->visit('/select-sync-field')
            ->dontSeeElement('input[type="hidden"][name="sync_exclude_sync"]')
            ->dontSeeElement('input[type="hidden"][name="sync_disabled_sync"]')
            ->seeElement('input[type="hidden"][name="custom_sync_name"][value="1"]');
    }

    /** @test */
    public function it_includes_old_values_for_tags()
    {
        $this->registerTestRoute('select-tags');

        $this->session(['_old_input' => ['tags' => ['a', 'b', 'c']]]);

        $this->visit('/select-tags')
            ->seeElement('option[value="a"]:selected')
            ->seeElement('option[value="b"]:selected')
            ->seeElement('option[value="c"]:selected');
    }

    /** @test */
    public function it_can_load_options_from_a_translatable_model()
    {
        $category1 = Category::create(['name' => 'Category 1']);
        $category2 = Category::create(['name' => 'Category 2']);

        $options = Category::query();

        Route::get('select-translatable', function () use ($options) {
            return view('select-translatable')
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select-translatable')
            ->seeElement('option[value="' . $category1->id . '"]')
            ->see('Category 1')
            ->seeElement('option[value="' . $category2->id . '"]')
            ->see('Category 2');
    }
}
