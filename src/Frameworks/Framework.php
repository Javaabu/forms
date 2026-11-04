<?php

namespace Javaabu\Forms\Frameworks;

/**
 * Maps the colour names components accept (Bootstrap's: primary, outline-danger, ...)
 * to a framework's classes.
 */
interface Framework
{
    public function name(): string;

    /**
     * Classes for a button of the given colour (primary, secondary, success, danger,
     * warning, info, light, dark, link, or outline-<colour>) and size (sm, lg).
     */
    public function button(string $color, ?string $size = null): string;

    /**
     * Classes for a status badge of the given colour.
     */
    public function badge(string $color): string;

    /**
     * Classes for an alert of the given type.
     */
    public function alert(string $type): string;
}
