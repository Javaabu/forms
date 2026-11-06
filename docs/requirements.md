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

## npm packages

You only need these when your app builds forms' JavaScript and CSS with its own Vite (manifest's Vite plugin). Without the plugin, manifest serves the prebuilt files in the package's `dist/`, and you install nothing. `php artisan manifest:check` lists what's missing.

| Package | Why |
| --- | --- |
| `tom-select` | `select2`, `bulk-actions`, `per-page` |
| `flatpickr` | `date`, `datetime`, `time` |
| `@javaabu/onu` | Its Thaana keyboard (`thaana` fields) and its Tailwind styles |
| `tailwindcss` | The Onu stylesheet |
| `react` | Must be installed, though none of it is bundled: `@javaabu/onu/thaana` also exports React hooks, so Vite has to resolve `react` while building |

forms registers all of these for manifest's **assets** scope, the files Blade pages load. It registers nothing for the **pages** scope (Inertia pages and code imported through a package alias): forms has no Inertia pages, and `@javaabu/forms-blade` imports are the same Blade scripts. So a Blade-only app isn't asked for `react-dom`, Inertia or the React package `@javaabu/forms`. Install `@javaabu/forms` yourself only if you write Inertia React pages; it's a separate package with the same components (see [Parity](./parity.md)).

CI installs exactly the registered packages into an empty app and builds the Blade sources (`scripts/blade-app-build.sh`), so a missing one fails forms' build rather than yours.
