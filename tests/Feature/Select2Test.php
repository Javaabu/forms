<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Javaabu\Forms\Tests\TestSupport\Enums\ArticleStatuses;
use Javaabu\Forms\Tests\TestSupport\Models\Article;

class Select2Test extends TestCase
{
    #[Test]
    public function it_can_render_a_select_2_basic_element_whose_value_comes_from_an_enum_cast()
    {
        // create an article
        $article = new Article([
            'status' => ArticleStatuses::Draft,
        ]);

        // create options
        $options = [
            'draft' => 'Draft',
            'published' => 'Published',
        ];

        Route::get('select2-enum', function () use ($article, $options) {
            return view('select2-enum')
                ->with('article', $article)
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select2-enum')
            ->seeElement('select.select2-basic[id="status"][data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]')
            ->seeElement('option[value="draft"]:selected')
            ->seeElement('option[value="published"]');

    }

    #[Test]
    public function it_can_render_a_select2_basic_element()
    {
        $post = [
            'author' => 2,
        ];

        $options = [
            '1' => 'Arushad',
            '2' => 'John',
            '3' => 'Amy',
        ];

        Route::get('select2-basic', function () use ($post, $options) {
            return view('select2-basic')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select2-basic')
            ->seeElement('select.select2-basic[id="author"][data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="2"]:selected')
            ->seeElement('option[value="3"]');
    }

    #[Test]
    public function it_can_render_a_select_2_basic_element_with_a_label()
    {
        $post = [
            'author' => 2,
        ];

        $options = [
            '1' => 'Arushad',
            '2' => 'John',
            '3' => 'Amy',
        ];

        Route::get('select2-basic', function () use ($post, $options) {
            return view('select2-basic-label')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select2-basic')
            ->seeElement('label[for="author"]')
            ->seeElement('select.select2-basic[id="author"][data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="2"]:selected')
            ->seeElement('option[value="3"]');
    }

    #[Test]
    public function it_can_render_a_select2_ajax_element()
    {
        $post = [
            'author' => 2,
        ];

        $options = [
            '2' => 'John',
        ];

        Route::get('select2-ajax', function () use ($post, $options) {
            return view('select2-ajax')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select2-ajax')
            ->seeElement('select.select2-ajax[id="author"][data-allow-clear="true"][data-placeholder="Nothing Selected"][data-select-ajax-url="/api/authors"][data-name-field="list_name"]')
            ->seeElement('option[value=""]')
            ->seeElement('option[value="2"]:selected');
    }

    #[Test]
    public function it_can_render_a_select2_element_with_custom_form_group_class_material_admin_26()
    {
        $this->setFrameworkMaterialAdmin26();

        $post = [
            'author' => 2,
        ];

        $options = [
            '1' => 'Arushad',
            '2' => 'John',
            '3' => 'Amy',
        ];

        Route::get('select2-basic', function () use ($post, $options) {
            return view('select2-basic-form-group-class')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select2-basic')
            ->seeElement('div.custom-class')
            ->seeElement('select.select2-basic[id="author"][data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="2"]:selected')
            ->seeElement('option[value="3"]');
    }

    #[Test]
    public function it_can_render_a_select2_element_with_custom_form_group_class_bootstrap_5()
    {
        $this->setFrameworkBootstrap5();

        $post = [
            'author' => 2,
        ];

        $options = [
            '1' => 'Arushad',
            '2' => 'John',
            '3' => 'Amy',
        ];

        Route::get('select2-basic', function () use ($post, $options) {
            return view('select2-basic-form-group-class')
                ->with('post', $post)
                ->with('options', $options);
        })->middleware('web');

        $this->visit('/select2-basic')
            ->seeElement('div.custom-class')
            ->seeElement('select.select2-basic[id="author"][data-allow-clear="true"][data-placeholder="Nothing Selected"]')
            ->seeElement('option[value=""]')
            ->seeElement('option[value="1"]')
            ->seeElement('option[value="2"]:selected')
            ->seeElement('option[value="3"]');
    }
}
