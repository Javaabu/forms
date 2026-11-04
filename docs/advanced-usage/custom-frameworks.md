---
title: Custom frameworks
sidebar_position: 4
---

# Custom frameworks

A framework is a folder of views plus a small class that maps colour names to classes. To add one, for example for your own design system:

1. Copy the views of the closest framework, `vendor/javaabu/forms/resources/views/onu` or `…/bootstrap-6`, to `resources/views/vendor/forms/my-theme` and change the markup.
2. Write a class implementing `Javaabu\Forms\Frameworks\Framework`:

```php
<?php

namespace App\Forms;

use Javaabu\Forms\Frameworks\Framework;

class MyTheme implements Framework
{
    public function name(): string
    {
        return 'my-theme';
    }

    public function button(string $color, ?string $size = null): string
    {
        return trim("button button--{$color} " . ($size ? "button--{$size}" : ''));
    }

    public function badge(string $color): string
    {
        return "badge badge--{$color}";
    }

    public function alert(string $type): string
    {
        return "alert alert--{$type}";
    }
}
```

3. Register it in a service provider, and select it in config or per component:

```php
use App\Forms\MyTheme;
use Javaabu\Forms\Frameworks\Frameworks;

public function boot(): void
{
    Frameworks::register('my-theme', MyTheme::class);
}
```

```php
// config/forms.php
'framework' => 'my-theme',
'frameworks' => [
    'my-theme' => [
        'inline_label_class' => 'w-1/4',
        'inline_input_class' => 'w-3/4',
    ],
],
```

Views your framework doesn't have fall back to `forms::common`.

## Changing a bundled framework's colours

Register a subclass under the bundled name:

```php
use Javaabu\Forms\Frameworks\Bootstrap6;
use Javaabu\Forms\Frameworks\Frameworks;

class AppBootstrap6 extends Bootstrap6
{
    public function button(string $color, ?string $size = null): string
    {
        return $color === 'primary'
            ? 'btn-solid btn-styled theme-primary'
            : parent::button($color, $size);
    }
}

Frameworks::register('bootstrap-6', AppBootstrap6::class);
```

## Colour names

Components accept Bootstrap's colour names everywhere: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark`, `link`, and `outline-{colour}` for buttons. The `Onu` class maps them to Onu variants (`danger` → `destructive`) and tones (`danger`, `success`, `warning`, `info`, `neutral`); `Bootstrap6` maps them to `.theme-*` classes.
