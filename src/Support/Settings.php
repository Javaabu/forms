<?php

namespace Javaabu\Forms\Support;

use Throwable;

class Settings
{
    /**
     * Reads a default from the forms config, then javaabu/settings (when installed), then the fallback.
     */
    public static function get(string $key, mixed $fallback = null): mixed
    {
        $value = config("forms.defaults.{$key}");

        if (! is_null($value)) {
            return $value;
        }

        if (function_exists('get_setting')) {
            try {
                $value = get_setting($key);
            } catch (Throwable) {
                $value = null;
            }
        }

        return $value ?? $fallback;
    }
}
