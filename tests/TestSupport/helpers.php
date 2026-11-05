<?php

use Javaabu\Forms\Tests\TestSupport\FakeSettings;

/*
 * Stands in for javaabu/settings' get_setting(), so the tests cover reading defaults from
 * settings without installing it (settings v2 requires javaabu/forms). Unset keys return
 * null, as settings does, so components fall back to the forms config and their defaults.
 */
if (! function_exists('get_setting')) {
    function get_setting(string $key): mixed
    {
        return FakeSettings::$values[$key] ?? null;
    }
}
