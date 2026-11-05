---
title: Requirements
sidebar_position: 1.1
---

- PHP 8.4 or newer
- Laravel 12 or 13
- [javaabu/manifest](https://github.com/Javaabu/manifest), installed with the package, to load the JavaScript and CSS

For the `onu` framework, either Tailwind CSS v4 with [`@javaabu/onu`](https://www.npmjs.com/package/@javaabu/onu) in your build, or the prebuilt stylesheet. For `bootstrap-6`, Bootstrap 6 (6.0.0-alpha.1). See [Frameworks](./frameworks/onu.md).

Optional packages:

| Package | For |
| --- | --- |
| `spatie/laravel-medialibrary` | Binding `file` and `image` inputs to media collections |
| `matanyadaev/laravel-eloquent-spatial` | Binding `map-input` to points and polygons |
| `javaabu/settings` (v1 or v2) | Reading the per-page, map and file size defaults from settings |
| `javaabu/helpers` | File inputs read the file types your app registers with `AllowedMimeTypes` (helpers v1 needs settings v1) |
| TinyMCE (hosted by your app) | `wysiwyg` textareas |
