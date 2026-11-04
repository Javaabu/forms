<?php

namespace Javaabu\Forms\Frameworks;

use Illuminate\Support\Str;

/**
 * Onu (@javaabu/onu): the class strings come from resources/onu/classes.php,
 * which scripts/onu-classes.mjs generates by rendering Onu's own components.
 */
class Onu implements Framework
{
    /** @var array<string, mixed>|null */
    protected ?array $classes = null;

    /** @var array<string, string> */
    protected array $button_variants = [
        'primary' => 'default',
        'secondary' => 'secondary',
        'success' => 'success',
        'danger' => 'destructive',
        'warning' => 'warning',
        'info' => 'default',
        'light' => 'outline',
        'dark' => 'secondary',
        'link' => 'link',
    ];

    /** @var array<string, string> */
    protected array $tones = [
        'primary' => 'info',
        'info' => 'info',
        'success' => 'success',
        'warning' => 'warning',
        'danger' => 'danger',
        'secondary' => 'neutral',
        'light' => 'neutral',
        'dark' => 'neutral',
    ];

    public function name(): string
    {
        return 'onu';
    }

    /**
     * Classes Onu renders for a component part, e.g. "input" or "button.destructive.sm".
     */
    public function classes(string $key, string $default = ''): string
    {
        return data_get($this->all(), $key, $default);
    }

    /** @return array<string, mixed> */
    public function all(): array
    {
        return $this->classes ??= require __DIR__ . '/../../resources/onu/classes.php';
    }

    public function buttonVariant(string $color): string
    {
        if (Str::startsWith($color, 'outline-')) {
            return 'outline';
        }

        return $this->button_variants[$color] ?? 'default';
    }

    public function tone(string $color): string
    {
        return $this->tones[$color] ?? 'neutral';
    }

    public function button(string $color, ?string $size = null): string
    {
        $variant = $this->buttonVariant($color);
        $size = in_array($size, [null, '', 'md'], true) ? 'default' : $size;

        return $this->classes("button.{$variant}.{$size}", $this->classes("button.{$variant}.default"));
    }

    public function badge(string $color): string
    {
        return $this->classes('status.' . $this->tone($color));
    }

    public function alert(string $type): string
    {
        return $this->classes('alert.' . $this->tone($type) . '.callout');
    }
}
