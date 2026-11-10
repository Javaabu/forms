<?php

namespace Javaabu\Forms\Frameworks;

use InvalidArgumentException;

class Frameworks
{
    /** @var array<string, class-string<Framework>> */
    protected static array $frameworks = [
        'onu' => Onu::class,
        'bootstrap-6' => Bootstrap6::class,
    ];

    /** @var array<string, Framework> */
    protected static array $instances = [];

    /**
     * Registers a framework, so components can render with framework="$name"
     * once its views exist in resources/views/vendor/forms/$name.
     *
     * @param  class-string<Framework>  $framework
     */
    public static function register(string $name, string $framework): void
    {
        static::$frameworks[$name] = $framework;

        unset(static::$instances[$name]);
    }

    public static function get(string $name): Framework
    {
        if (isset(static::$instances[$name])) {
            return static::$instances[$name];
        }

        $framework = static::$frameworks[$name] ?? null;

        if (! $framework) {
            throw new InvalidArgumentException("Unknown forms framework [{$name}]. Supported: " . implode(', ', static::names()) . '.');
        }

        return static::$instances[$name] = app($framework);
    }

    /** @return array<int, string> */
    public static function names(): array
    {
        return array_keys(static::$frameworks);
    }
}
