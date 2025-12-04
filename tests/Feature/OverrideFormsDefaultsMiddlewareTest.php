<?php

namespace Javaabu\Forms\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Javaabu\Forms\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OverrideFormsDefaultsMiddlewareTest extends TestCase
{
    #[Test]
    public function it_can_use_the_middleware_to_switch_what_theme_to_use()
    {
        $this->withoutExceptionHandling();

        $current_theme = Config::get('forms.framework');
        $this->assertTrue($current_theme === 'bootstrap-5');

        $this->setFrameworkMaterialAdmin26();

        $current_theme = Config::get('forms.framework');
        $this->assertTrue($current_theme === 'material-admin-26');

        \Route::get('/change-framework', function () {
            return 'Framework changed to Bootstrap-5';
        })->middleware('forms:bootstrap-5');

        $this->get('/change-framework')
            ->seeText('Framework changed to Bootstrap-5');

        $current_theme = Config::get('forms.framework');
        $this->assertTrue($current_theme === 'bootstrap-5');
    }
}
