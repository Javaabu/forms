<?php

/*
 * Writes resources/boost/skills/javaabu-forms/references/components.md from the
 * component constructors. Run: php scripts/components-reference.php
 */

use Illuminate\Support\Str;

require __DIR__ . '/../vendor/autoload.php';

$dir = __DIR__ . '/../src/Views/Components';
$rows = [];

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($files as $file) {
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $relative = substr($file->getPathname(), strlen($dir) + 1, -4);
    $class = 'Javaabu\\Forms\\Views\\Components\\' . str_replace('/', '\\', $relative);
    $reflection = new ReflectionClass($class);

    if ($reflection->isAbstract()) {
        continue;
    }

    $tag = implode('.', array_map(fn ($part) => Str::kebab($part), explode('/', $relative)));
    $attributes = [];

    foreach ($reflection->getConstructor()?->getParameters() ?? [] as $parameter) {
        if ($parameter->getName() === 'framework') {
            continue;
        }

        $name = Str::kebab($parameter->getName());
        $type = (string) ($parameter->getType() ?? 'mixed');

        if (! $parameter->isDefaultValueAvailable()) {
            $attributes[] = "`{$name}` ({$type}, required)";

            continue;
        }

        $default = $parameter->getDefaultValue();
        $default = match (true) {
            is_bool($default) => $default ? 'true' : 'false',
            is_null($default) => 'null',
            is_array($default) => $default ? 'array' : '[]',
            $default === '' => "''",
            default => (string) $default,
        };

        $attributes[] = "`{$name}` = {$default}";
    }

    $rows[$tag] = "| `x-forms::{$tag}` | " . ($attributes ? implode(', ', $attributes) : '—') . ' |';
}

ksort($rows);

$output = <<<'MD'
# Component attributes

Generated from the component constructors by `scripts/components-reference.php`. Every field also accepts `form-group-class`, `thaana`, `auto-resize` (textarea) and `decimals` (number), every component accepts `framework`, and any other attribute (`class`, `id`, `placeholder`, `min`, `step`, `data-*`, …) goes on the control.

| Component | Attributes (kebab-case) = default |
| --- | --- |

MD;

file_put_contents(
    __DIR__ . '/../resources/boost/skills/javaabu-forms/references/components.md',
    $output . implode("\n", $rows) . "\n",
);

echo count($rows) . " components\n";
