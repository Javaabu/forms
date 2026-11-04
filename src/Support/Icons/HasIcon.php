<?php

/**
 * Simple trait for icon posts
 */

namespace Javaabu\Forms\Support\Icons;

trait HasIcon
{
    public static function iconsClass()
    {
        return static::$icons_class;
    }

    public static function getIcons()
    {
        $icon_class = static::iconsClass();

        return $icon_class::getIcons();
    }

    public static function getIconKeys()
    {
        $icon_class = static::iconsClass();

        return $icon_class::getKeys();
    }

    /**
     * Convert icon to lowercase
     */
    public function setIconAttribute($icon)
    {
        $this->attributes['icon'] = $icon ? strtolower($icon) : null;
    }

    public function getIconClass($icon)
    {
        $icon_class = static::iconsClass();

        return $icon_class::getIconClass($icon);
    }

    public function getIconClassAttribute(): ?string
    {
        $icon_class = $this->getIconClass($this->icon);

        if (str($icon_class)->endsWith($this->icon)) {
            return $icon_class;
        }

        if (isset(static::$default_icon)) {
            return $this->getIconClass(static::$default_icon);
        }

        return null;
    }
}
