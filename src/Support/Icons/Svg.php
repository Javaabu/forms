<?php

namespace Javaabu\Forms\Support\Icons;

class Svg
{
    /** @var array<string, string>|null */
    protected static ?array $icons = null;

    /**
     * The inner markup of a bundled icon, or null when the name isn't bundled.
     */
    public static function get(string $name): ?string
    {
        return static::all()[$name] ?? null;
    }

    public static function has(string $name): bool
    {
        return array_key_exists($name, static::all());
    }

    /** @return array<string, string> */
    public static function all(): array
    {
        return static::$icons ??= require __DIR__ . '/../../../resources/icons/icons.php';
    }
}
