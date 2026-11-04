<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Route;

class OverrideFormsDefaultsMiddlewareTest extends TestCase
{
    #[Test]
    public function it_can_use_the_middleware_to_switch_what_theme_to_use()
    {
        $this->withoutExceptionHandling();

        $current_theme = Config::get('forms.framework');
        $this->assertEquals('bootstrap-6', $current_theme);

        $this->setFrameworkOnu();

        $current_theme = Config::get('forms.framework');
        $this->assertEquals('onu', $current_theme);

        Route::get('/change-framework', function () {
            return 'Framework changed to Bootstrap 6';
        })->middleware('forms:bootstrap-6');

        $this->get('/change-framework')
            ->seeText('Framework changed to Bootstrap 6');

        $current_theme = Config::get('forms.framework');
        $this->assertEquals('bootstrap-6', $current_theme);
    }
}
