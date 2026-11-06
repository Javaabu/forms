<?php

namespace Javaabu\Forms\Support\Icons;

abstract class Icons
{
    protected static array $icons = [];

    protected static string $icon_prefix = '';

    /**
     * Get the icons
     */
    public static function getIcons(): array
    {
        return static::$icons;
    }

    /**
     * Get the icon prefix
     */
    public static function getIconPrefix(): string
    {
        return static::$icon_prefix;
    }

    /**
     * Get the icon class
     */
    public static function getIconClass($icon): string
    {
        $prefix = static::getIconPrefix();

        if ($prefix) {
            $icon = "$prefix $prefix-$icon";
        }

        return $icon;
    }

    /**
     * Get keys
     */
    public static function getKeys(): array
    {
        return array_keys(static::getIcons());
    }
}
