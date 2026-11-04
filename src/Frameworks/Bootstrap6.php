<?php

namespace Javaabu\Forms\Frameworks;

use Illuminate\Support\Str;

/**
 * Bootstrap 6 (targets 6.0.0-alpha.1): variants are composed from a style class and a .theme-* class.
 */
class Bootstrap6 implements Framework
{
    /** @var array<string, string> */
    protected array $themes = [
        'primary' => 'primary',
        'secondary' => 'secondary',
        'success' => 'success',
        'danger' => 'danger',
        'warning' => 'warning',
        'info' => 'info',
        'light' => 'secondary',
        'dark' => 'inverse',
        'accent' => 'accent',
        'inverse' => 'inverse',
    ];

    public function name(): string
    {
        return 'bootstrap-6';
    }

    public function theme(string $color): string
    {
        return 'theme-' . ($this->themes[$color] ?? $color);
    }

    public function button(string $color, ?string $size = null): string
    {
        $size_class = match ($size) {
            null, '', 'md', 'default' => '',
            'icon' => ' btn-icon',
            default => " btn-{$size}",
        };

        if ($color === 'link') {
            return "btn-link{$size_class}";
        }

        if (Str::startsWith($color, 'outline-')) {
            return 'btn-outline ' . $this->theme(Str::after($color, 'outline-')) . $size_class;
        }

        if ($color === 'light') {
            return 'btn-subtle ' . $this->theme($color) . $size_class;
        }

        return 'btn-solid ' . $this->theme($color) . $size_class;
    }

    public function badge(string $color): string
    {
        return 'badge ' . $this->theme($color);
    }

    public function alert(string $type): string
    {
        return 'alert ' . $this->theme($type);
    }
}
