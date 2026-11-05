<?php

namespace Javaabu\Forms\Support;

use Illuminate\Support\Arr;
use Javaabu\Helpers\Media\AllowedMimeTypes;

/**
 * The file types, mime types, extensions and size limits of file and image inputs.
 *
 * When javaabu/helpers is installed, this reads its AllowedMimeTypes, so types an app
 * registers there still apply. Without it, the same lists ship with this package
 * (resources/data/mime-types.php), and apps register extra types here.
 */
class MimeTypes
{
    /** @var array{mime_types: array<string, array<int, string>>, extensions: array<string, string>, file_size_settings: array<string, array<int, string>>}|null */
    protected static ?array $data = null;

    protected static function helpers(): bool
    {
        return class_exists(AllowedMimeTypes::class);
    }

    /** @return array{mime_types: array<string, array<int, string>>, extensions: array<string, string>, file_size_settings: array<string, array<int, string>>} */
    protected static function data(): array
    {
        return static::$data ??= require __DIR__ . '/../../resources/data/mime-types.php';
    }

    /**
     * @param  string|array<int, string>  $types  e.g. "image", "document" or ["image", "pdf"]
     * @return array<int, string>
     */
    public static function mimeTypes(string|array $types = ''): array
    {
        if (static::helpers()) {
            return AllowedMimeTypes::getAllowedMimeTypes($types);
        }

        $all = static::data()['mime_types'];

        if (! $types) {
            return Arr::flatten($all);
        }

        return Arr::flatten(array_map(fn ($type) => $all[$type] ?? [], Arr::wrap($types)));
    }

    /**
     * @param  array<int, string>  $mime_types
     * @return array<int, string>
     */
    public static function extensions(array $mime_types): array
    {
        if (static::helpers()) {
            return AllowedMimeTypes::getExtensions($mime_types);
        }

        $extensions = static::data()['extensions'];

        return array_values(array_unique(array_filter(array_map(fn ($mime_type) => $extensions[$mime_type] ?? null, $mime_types))));
    }

    /**
     * The largest size (KB) allowed for any of the types: from settings when javaabu/settings
     * is installed (max_{type}_file_size, then the type's size setting), else
     * forms.defaults.max_upload_file_size, else 10240.
     *
     * @param  string|array<int, string>  $types
     */
    public static function maxFileSize(string|array $types = ''): int
    {
        if (static::helpers() && function_exists('get_setting')) {
            return AllowedMimeTypes::getMaxFileSize($types);
        }

        $types = $types ? Arr::wrap($types) : array_keys(static::data()['mime_types']);
        $max_size = 0;

        foreach ($types as $type) {
            $size = (int) Settings::get("max_{$type}_file_size", 0)
                ?: (int) Settings::get(static::fileSizeSetting($type), 0)
                ?: (int) Settings::get('max_upload_file_size', 10240);

            $max_size = max($max_size, $size);
        }

        return $max_size;
    }

    public static function fileSizeSetting(string $type): string
    {
        foreach (static::data()['file_size_settings'] as $setting => $types) {
            if (in_array($type, $types)) {
                return $setting;
            }
        }

        return 'max_upload_file_size';
    }

    /**
     * @param  array<int, string>  $mime_types
     */
    public static function register(string $type, array $mime_types): void
    {
        static::data();

        static::$data['mime_types'][$type] = $mime_types;

        if (class_exists(AllowedMimeTypes::class)) {
            AllowedMimeTypes::registerMimeTypes($type, $mime_types);
        }
    }

    /**
     * @param  array<string, string>  $extensions  mime type => extension
     */
    public static function registerExtensions(array $extensions): void
    {
        static::data();

        static::$data['extensions'] = array_merge(static::$data['extensions'], $extensions);

        if (class_exists(AllowedMimeTypes::class)) {
            AllowedMimeTypes::registerMimeTypeExtensions($extensions);
        }
    }

    /**
     * A size in KB for people: "512 KB", "1.5 MB", "2 GB", with translated units.
     */
    public static function formatFileSize(int $kb): string
    {
        if ($kb < 0) {
            return '';
        }

        $bytes = $kb * 1024;

        [$size, $unit] = match (true) {
            $bytes < 1000000 => [$bytes / 1024, 'kb'],
            $bytes < 1000000000 => [$bytes / 1024 / 1024, 'mb'],
            default => [$bytes / 1024 / 1024 / 1024, 'gb'],
        };

        return round($size, 2) . trans("forms::strings.{$unit}");
    }
}
